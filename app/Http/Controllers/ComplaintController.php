<?php

namespace App\Http\Controllers;

use App\Mail\BrevoMailer;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.complaints.index');
        }

        return view('home');
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.complaints.index');
        }

        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anonymous' => ['required', 'in:SI,NO'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'areas' => ['nullable', 'array'],
            'areas.*' => ['string', 'max:100'],
            'other_area' => ['nullable', 'string', 'max:150'],
            'public_servant_name' => ['nullable', 'string', 'max:150'],
            'public_servant_position' => ['nullable', 'string', 'max:150'],
            'public_servant_physical_description' => ['nullable', 'string', 'max:1000'],
            'incident_day' => ['nullable', 'integer', 'between:1,31'],
            'incident_month' => ['nullable', 'string', 'max:30'],
            'incident_year' => ['nullable', 'integer', 'between:2000,2100'],
            'incident_time' => ['nullable', 'date_format:H:i'],
            'incident_location' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:4000'],
            'witnesses' => ['required', 'in:SI,NO'],
            'has_evidence' => ['required', 'in:SI,NO'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/quicktime,video/x-msvideo,video/webm,application/pdf', 'max:51200'],
        ]);

        $data['user_id'] = null;
        $data['areas'] = $data['areas'] ?? [];
        $data['category'] = $this->resolveCategory($data['areas'], $data['other_area'] ?? null);
        $data['name'] = $data['anonymous'] === 'SI' ? 'Denuncia anonima' : 'Denunciante';
        $data['status'] = 'Nueva';
        $data['attachments'] = $this->storeAttachments($request);

        Complaint::create($data);

        return redirect()
            ->route('complaints.index')
            ->with('success', 'su queja ha sido enviada, recibira a su correo una respuesta, gracias');
    }

    public function adminIndex()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $complaints = Complaint::with('responder')->latest()->get();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function respond(Request $request, Complaint $complaint)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $data = $request->validate([
            'response' => ['required', 'string', 'max:3000'],
        ]);

        $complaint->update([
            'response' => $data['response'],
            'status' => 'Respondida',
            'responded_at' => now(),
            'responded_by' => Auth::id(),
        ]);

        try {
            $html = view('emails.complaint-response', [
                'complaint'    => $complaint,
                'responseText' => $data['response'],
            ])->render();

            BrevoMailer::send(
                $complaint->email,
                'Respuesta a su denuncia — Folio #' . $complaint->id,
                $html,
            );
            $flash = ['success' => 'La respuesta fue guardada y el correo fue enviado.'];
        } catch (\Throwable $e) {
            \Log::error('Error enviando correo de respuesta: ' . $e->getMessage());
            $flash = ['warning' => 'La respuesta fue guardada, pero no se pudo enviar el correo: ' . $e->getMessage()];
        }

        return redirect()
            ->route('admin.complaints.index')
            ->with($flash);
    }

    public function destroy(Complaint $complaint)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        foreach ($complaint->attachments ?? [] as $attachment) {
            if (! empty($attachment['path'])) {
                Storage::disk(config('filesystems.default'))->delete($attachment['path']);
            }
        }

        $complaint->delete();

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'La queja fue eliminada correctamente.');
    }

    private function storeAttachments(Request $request): array
    {
        if (! $request->hasFile('attachments')) {
            return [];
        }

        \Log::info('[S3-DEBUG] Disco activo: ' . config('filesystems.default'));

        return collect($request->file('attachments'))->map(function ($file) {
            $path = $file->store('complaint-attachments', config('filesystems.default'));
            \Log::info('[S3-DEBUG] Path resultado: ' . ($path ?: 'FALSE'));
            $mime = (string) $file->getMimeType();

            return [
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime' => $mime,
                'size' => $file->getSize(),
                'type' => str_starts_with($mime, 'video/') ? 'video' : (str_contains($mime, 'pdf') ? 'pdf' : 'image'),
            ];
        })->all();
    }

    private function resolveCategory(array $areas, ?string $otherArea): string
    {
        if ($otherArea) {
            return $otherArea;
        }

        if ($areas !== []) {
            return implode(', ', array_slice($areas, 0, 2));
        }

        return 'Sin area especifica';
    }
}

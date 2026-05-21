@extends('layouts.app', ['title' => 'Encuesta de Satisfacción'])

@section('content')
    <div class="topbar">
        <div>
            <h2 class="section-title">Encuesta de Satisfacción</h2>
            <p class="muted">Ayúdanos a mejorar calificando la atención recibida después de tu queja.</p>
        </div>
    </div>

    <div style="max-width:700px;margin:0 auto;">
        <section class="panel">
            <form action="#" method="POST">
                @csrf
                <div class="field">
                    <label for="rating">¿Cómo calificaría la atención recibida?</label>
                    <div class="radio-row">
                        @for($i=1;$i<=5;$i++)
                            <label class="radio-option">
                                <input type="radio" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                {{ $i }}
                            </label>
                        @endfor
                    </div>
                    @error('rating')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="comments">Comentarios adicionales (opcional)</label>
                    <textarea id="comments" name="comments" rows="5">{{ old('comments') }}</textarea>
                </div>

                <div class="field">
                    <label for="followup">¿Desea que le contactemos para dar seguimiento?</label>
                    <select id="followup" name="followup">
                        <option value="NO" selected>NO</option>
                        <option value="SI">SI</option>
                    </select>
                </div>

                <button type="submit" class="button">Enviar Encuesta</button>
            </form>
        </section>
    </div>
@endsection

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'administracion@acateno.gob.mx'],
            [
                'name'     => 'Administrador',
                'password' => 'admin123',
                'role'     => 'admin',
            ]
        );
    }

    public function down(): void
    {
        User::where('email', 'administracion@acateno.gob.mx')->delete();
    }
};

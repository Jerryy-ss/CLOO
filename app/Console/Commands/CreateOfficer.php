<?php

namespace App\Console\Commands;

use App\Models\Officer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateOfficer extends Command
{
    protected $signature = 'library:create-officer
        {--nama= : Nama petugas}
        {--username= : Username petugas}
        {--email= : Email petugas}
        {--password= : Password petugas}';

    protected $description = 'Membuat akun petugas pada Firestore.';

    public function handle(): int
    {
        $nama = $this->option('nama') ?: $this->ask('Nama petugas');
        $username = $this->option('username') ?: $this->ask('Username petugas');
        $email = $this->option('email') ?: $this->ask('Email petugas');
        $password = $this->option('password') ?: $this->secret('Password petugas');

        if (! $nama || ! $username || ! $email || ! $password) {
            $this->error('Semua data wajib diisi.');
            return self::FAILURE;
        }

        Officer::create([
            'id_petugas' => 'PTG-'.strtoupper(\Illuminate\Support\Str::random(8)),
            'nama' => $nama,
            'username' => $username,
            'email' => strtolower($email),
            'password' => Hash::make($password),
            'role' => 'petugas',
        ]);

        $this->info('Akun petugas berhasil dibuat di collection "petugas".');

        return self::SUCCESS;
    }
}

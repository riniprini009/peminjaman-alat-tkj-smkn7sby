<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;

class ReminderPeminjaman extends Command
{
    protected $signature = 'peminjaman:reminder';
    protected $description = 'Reminder peminjaman';

    public function handle(PeminjamanService $service)
    {
        Peminjaman::where('status_pinjam', 'aktif')->chunk(100, function ($data) use ($service) {
                foreach ($data as $pinjam) {
                    $service->checkReminder($pinjam);
                }
            });

        $this->info("Reminder jalan");
    }
}
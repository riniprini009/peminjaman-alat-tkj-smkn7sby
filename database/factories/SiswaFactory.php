<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\AkunUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Siswa::class;
    public function definition(): array
    {
        $nis = fake()->unique()->numerify('######');
        $kelas = fake()->randomElement([
            'X TKJ 1',
            'X TKJ 2',
            'XI TKJ 1',
            'XI TKJ 2',
            'XII TKJ 1',
            'XII TKJ 2'
        ]);
        $akun = AkunUser::factory()->create([
            'username' => $nis,
            'password' => Hash::make($nis . $kelas),
            'role' => fake()->randomElement([
                'Siswa',
                'Admin',
                'Kepala Laboratorium'
            ]),
            'status_akun' => fake()->randomElement([
                'Aktif',
                'Tidak Aktif'
            ])
        ]);

        return [
            'id_akun_user' => $akun->id_akun_user,
            'nama_siswa' => fake()->name(),
            'nis' => $nis,
            'kelas' => $kelas,
            'jenis_kelamin' => fake()->randomElement([
                'Laki-Laki',
                'Perempuan'
            ])
        ];
    }
}

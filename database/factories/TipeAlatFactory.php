<?php

namespace Database\Factories;

use App\Models\JenisAlat;
use App\Models\TipeAlat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipeAlat>
 */
class TipeAlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TipeAlat::class;
    public function definition(): array
    {
        static $number = 1;
        return [
            'id_tipe' => 'T' . $number++,
            'id_jenis' => JenisAlat::factory(),
            'nama_tipe' => fake()->randomElement([
                'Mikrotik RB_941_2nd',
                'Mikrotik_Rb_750r2',
                'SW Manageable TPLink TL-SG105E',
                'SW Manageable DLink DGS-1100'
            ]),
            'stok' => fake()->randomDigitNotNull(),
            'lokasi_rak' => fake()->randomElement([
                'A1',
                'A2',
                'A3',
                'A4',
            ])
        ];
    }
}

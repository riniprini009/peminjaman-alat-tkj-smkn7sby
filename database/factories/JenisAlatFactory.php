<?php

namespace Database\Factories;

use App\Models\JenisAlat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisAlat>
 */
class JenisAlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = JenisAlat::class;
    public function definition(): array
    {
        return [
            'nama_jenis' => fake()->randomElement([
                'Mikrotik',
                'Switch',
                'Access Point'
            ])
        ];
    }
}

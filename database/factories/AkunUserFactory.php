<?php

namespace Database\Factories;

use App\Models\AkunUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AkunUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AkunUser::class;
    public function definition(): array
    {
        return [
            'username' => 'dummy',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'status_akun' => 'aktif'
        ];
    }
}

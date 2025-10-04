<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            'usia' => $this->faker->numberBetween(18, 65),
            'no_hp' => $this->faker->phoneNumber(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'kesibukan' => $this->faker->randomElement([
                'mahasiswa', 'siswa', 'karyawan', 'fresh graduate', 'profesional', 'wiraswasta', 'wirausaha'
            ]),
            'koin' => $this->faker->numberBetween(0, 500),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

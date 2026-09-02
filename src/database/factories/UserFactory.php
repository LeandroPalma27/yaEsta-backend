<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
        ];
    }

    /**
     * Create the user with password authentication.
     */
    public function withPassword(string $password = 'password'): static
    {
        return $this->afterCreating(function (User $user) use ($password) {
            $user->authAccounts()->create([
                'provider' => 'password',
                'provider_account_id' => null,
                'password_hash' => Hash::make($password),
            ]);
        });
    }

    /**
     * Indicate that the user's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
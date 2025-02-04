<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * O nome do model associado a esta factory.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define o estado padrão do model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('12345678'), // Hash da senha padrão
            'perfil' => 'solicitante', // Tipo de utilizador padrão (pode ser alterado para 'aprovador' conforme necessário)
            'email_verified_at' => now(), // Define a verificação de e-mail para agora
            'remember_token' => Str::random(10), // Token de lembrança
            'profile_photo_path' => 'painel/assets/avatars/user.png', // Foto de perfil padrão
        ];
    }

    /**
     * Indica que o endereço de e-mail do usuário deve estar não verificado.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indica que o utilizador deve ter uma equipe pessoal.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}

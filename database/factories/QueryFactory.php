<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Query\Expression;
use PhpCfdi\Rfc\RfcFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Query>
 */
class QueryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'rfc' => (new RfcFaker)->mexicanRfcFisica(),
            'endPoint' => $this->faker->randomElement(['cfdi', 'retenciones']),
            'downloadType' => $this->faker->randomElement(['issued', 'received']),
            'requestType' => $this->faker->randomElement(['xml', 'metadata']),
            'dateTimePeriodStart' => $this->faker->dateTime(),
            'dateTimePeriodEnd' => $this->faker->dateTime(),
            'requestId' => $this->faker->uuid,
            'numeroCFDIs' => $this->faker->numberBetween(1, 2000),
            'documentType' => $this->faker->randomElement(['I', 'E', 'N', 'T', 'P']),
            'documentStatus' => $this->faker->randomElement(['active', 'cancelled']),
            'complementoCfdi' => 'cfdiRegistroFiscal10',
            'rfcMatches' => new Expression("(JSON_ARRAY('" .
                (new RfcFaker)->mexicanRfcFisica() . "','" . (new RfcFaker)->mexicanRfcFisica() . "'))"),
            'rfcOnBehalf' => (new RfcFaker)->mexicanRfcFisica(),
            'uuid' => $this->faker->uuid,
        ];
    }
}

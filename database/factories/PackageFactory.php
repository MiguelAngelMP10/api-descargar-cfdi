<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use PhpCfdi\Rfc\RfcFaker;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rfc = (new RfcFaker)->mexicanRfcFisica();
        $packageId = $this->faker->uuid . '_01';
        return [
            'query_id' => 1,
            'packageId' => $packageId,
            'path' => 'datos/' . $rfc . '/' . $packageId,
            'statusCode' => '5000',
            'statusMessage' => 'Solicitud Aceptada',
            'packageSize' => $this->faker->numberBetween(500, 2000),
        ];
    }
}

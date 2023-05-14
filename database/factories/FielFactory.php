<?php

namespace Database\Factories;

use App\Models\Fiel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use PhpCfdi\Credentials\Credential;

/**
 * @extends Factory<Fiel>
 */
class FielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $pathFakeFiel = base_path('tests/_files/fake-fiel/');

        $certificatePath = $pathFakeFiel.'EKU9003173C9-pem.cer';
        $privateKeyPath = $pathFakeFiel.'EKU9003173C9-pem.key';

        $passPhrase = trim(file_get_contents($pathFakeFiel.'EKU9003173C9-password.txt'));

        $cer = file_get_contents($certificatePath);
        $key = file_get_contents($privateKeyPath);

        $fiel = Credential::create($cer, $key, $passPhrase);

        $certificado = $fiel->certificate();

        return [
            'user_id' => 1,
            'rfc' => $certificado->rfc(),
            'legalName' => $certificado->legalName(),
            'cer' => Crypt::encryptString($cer),
            'key' => Crypt::encryptString($key),
            'password' => Crypt::encryptString($passPhrase),
        ];
    }
}

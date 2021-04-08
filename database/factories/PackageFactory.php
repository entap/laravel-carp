<?php
namespace Entap\Laravel\Carp\Database\Factories;

use Entap\Laravel\Carp\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition()
    {
        return [
            'name' => $this->faker->uuid,
        ];
    }
}

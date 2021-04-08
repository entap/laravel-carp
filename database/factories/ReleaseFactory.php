<?php
namespace Entap\Laravel\Carp\Database\Factories;

use Entap\Laravel\Carp\Models\Package;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReleaseFactory extends Factory
{
    protected $model = Release::class;

    public function definition()
    {
        return [
            'package_id' => Package::factory(),
            'name' => $this->faker->uuid,
            'url' => $this->faker->url,
            'notes' => $this->faker->paragraph,
        ];
    }

    public function published()
    {
        return $this->state([
            'publish_date' => $this->faker->dateTime(),
        ]);
    }

    public function publishing()
    {
        return $this->state([
            'publish_date' => now()->addDays($this->faker->numberBetween(2, 5)),
        ]);
    }

    public function expired()
    {
        return $this->state([
            'expire_date' => $this->faker->dateTime(),
        ]);
    }

    public function expiring()
    {
        return $this->state([
            'expire_date' => now()->addDays($this->faker->numberBetween(2, 5)),
        ]);
    }
}

<?php

namespace Entap\Laravel\Carp\Tests\Feature\Console\Commands;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishTest extends TestCase
{
    public function test_リリースを公開する()
    {
        $this->travelTo(now());

        $release = Release::factory()->make();
        $package = $release->package;

        $this->artisan(
            "carp:publish {$package->name} {$release->name}"
        )->assertExitCode(0);

        $this->assertDatabaseHas('releases', [
            'name' => $release->name,
            'publish_date' => now(),
        ]);
    }
}

<?php

namespace Entap\Laravel\Carp\Tests\Feature\Console\Commands;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpireTest extends TestCase
{
    public function test_リリースを廃止する()
    {
        $this->travelTo(now());

        $release = Release::factory()->create();
        $package = $release->package;

        $this->artisan(
            "carp:expire {$package->name} {$release->name}"
        )->assertExitCode(0);

        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'expire_date' => now(),
        ]);
    }
}

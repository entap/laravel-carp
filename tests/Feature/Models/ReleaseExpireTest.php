<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Illuminate\Support\Carbon;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReleaseExpireTest extends TestCase
{
    use WithFaker;

    public function test_リリースを廃止する()
    {
        Carbon::setTestNow(now());

        $release = Release::factory()->create();

        $release->expire();

        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'expire_date' => now(),
        ]);
    }

    public function test_日付を指定できる()
    {
        $release = Release::factory()->create();
        $expireDate = new Carbon($this->faker->dateTime);

        $release->expire($expireDate);

        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'expire_date' => $expireDate,
        ]);
    }
}

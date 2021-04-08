<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Illuminate\Support\Carbon;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReleasePublishTest extends TestCase
{
    use WithFaker;

    public function test_リリースを公開する()
    {
        Carbon::setTestNow(now());

        $release = Release::factory()->create();

        $release->publish();

        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'publish_date' => now(),
        ]);
    }

    public function test_日付を指定できる()
    {
        $release = Release::factory()->create();
        $publishDate = new Carbon($this->faker->dateTime);

        $release->publish($publishDate);

        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'publish_date' => $publishDate,
        ]);
    }
}

<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Release->published()
 */
class ReleasePublishedScopeTest extends TestCase
{
    public function test_公開されたリリースを絞り込む()
    {
        $unpublishedRelease = Release::factory()->create();
        $publishedRelease = Release::factory()
            ->published()
            ->create();
        $publishingRelease = Release::factory()
            ->publishing()
            ->create();

        $this->assertEquals(
            collect([$publishedRelease->id]),
            Release::published()
                ->get()
                ->pluck('id')
        );
    }

    public function test_日付を渡せる()
    {
        $publishingRelease = Release::factory()->create([
            'publish_date' => now()->addDays(3),
        ]);
        $publishedDate = $publishingRelease->publish_date;

        $this->assertEquals(
            collect([$publishingRelease->id]),
            Release::published($publishedDate)
                ->get()
                ->pluck('id')
        );
    }
}

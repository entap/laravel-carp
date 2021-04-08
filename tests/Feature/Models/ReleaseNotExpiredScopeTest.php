<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Release->notExpired()
 */
class ReleaseNotExpiredScopeTest extends TestCase
{
    public function test_廃止されていないリリースを絞り込む()
    {
        $unexpiredRelease = Release::factory()->create();
        $expiredRelease = Release::factory()
            ->expired()
            ->create();
        $expiringRelease = Release::factory()
            ->expiring()
            ->create();

        $this->assertEquals(
            collect([$unexpiredRelease->id, $expiringRelease->id]),
            Release::notExpired()
                ->get()
                ->pluck('id')
        );
    }

    public function test_日付を渡せる()
    {
        $expiringRelease = Release::factory()->create([
            'expire_date' => now()->addDays(3),
        ]);
        $expiredDate = $expiringRelease->expire_date;

        $this->assertEquals(1, Release::notExpired()->count());
        $this->assertEquals(0, Release::notExpired($expiredDate)->count());
    }
}

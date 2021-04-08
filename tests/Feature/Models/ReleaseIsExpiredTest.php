<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * リリースが廃止されているかどうか判別する
 */
class ReleaseIsExpiredTest extends TestCase
{
    public function test_リリースが廃止されていたら真()
    {
        $release = new Release([
            'expire_date' => now(),
        ]);

        $this->assertTrue($release->isExpired());
    }

    public function test_初期化してすぐは偽()
    {
        $release = new Release();

        $this->assertFalse($release->isExpired());
    }

    public function test_廃止がまだ先なら偽()
    {
        $now = now();
        $expireDate = $now->copy()->addSecond();
        $release = new Release(['expire_date' => $expireDate]);

        $this->assertFalse($release->isExpired($now));
    }
}

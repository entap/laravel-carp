<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * リリースが公開されているかどうか判定する
 */
class ReleaseIsPublishedTest extends TestCase
{
    public function test_リリースが公開されていたら真()
    {
        $release = new Release([
            'publish_date' => now(),
        ]);

        $this->assertTrue($release->isPublished());
    }

    public function test_初期化してすぐは偽()
    {
        $release = new Release();

        $this->assertFalse($release->isPublished());
    }

    public function test_公開がまだ先なら偽()
    {
        $now = now();
        $publishDate = $now->copy()->addSecond();
        $release = new Release(['publish_date' => $publishDate]);

        $this->assertFalse($release->isPublished($now));
    }
}

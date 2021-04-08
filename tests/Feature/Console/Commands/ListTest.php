<?php
namespace Entap\Laravel\Carp\Tests\Feature\Console\Commands;

use Entap\Laravel\Carp\Models\Package;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends TestCase
{
    public function test_一覧を表示する()
    {
        $packages = Package::factory(2)
            ->hasReleases(2)
            ->create();

        $this->artisan("carp:list")->assertExitCode(0);
    }
}

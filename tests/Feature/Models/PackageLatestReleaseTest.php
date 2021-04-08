<?php

namespace Entap\Laravel\Carp\Tests\Feature\Models;

use Entap\Laravel\Carp\Models\Package;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Package->latestRelease()
 */
class PackageLatestReleaseTest extends TestCase
{
    public function test_最新のリリースを取得する()
    {
        $package = Package::factory()->create();
        $unpublishedRelease = Release::factory()->create([
            'package_id' => $package->id,
        ]);
        $olderRelease = Release::factory()->create([
            'package_id' => $package->id,
            'publish_date' => '2020-01-01',
        ]);
        $newerRelease = Release::factory()->create([
            'package_id' => $package->id,
            'publish_date' => '2020-01-02',
        ]);
        $expiredRelease = Release::factory()
            ->expired()
            ->create([
                'package_id' => $package->id,
                'publish_date' => '2020-01-03',
            ]);

        $this->assertEquals($newerRelease->id, $package->latestRelease()->id);
    }

    public function test_最新のリリースがなければnull()
    {
        $package = Package::factory()->create();

        $this->assertNull($package->latestRelease());
    }
}

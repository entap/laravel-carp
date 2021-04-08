<?php

namespace Entap\Laravel\Carp\Tests\Feature\Http;

use Entap\Laravel\Carp\Models\Package;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGetLatestReleaseTest extends TestCase
{
    public function test_最新のリリースを取得する()
    {
        $package = Package::factory()->create();
        $oldRelease = Release::factory()->create([
            'package_id' => $package->id,
            'name' => 'v1.1.0',
            'publish_date' => '2020-01-01',
        ]);
        $release = Release::factory()->create([
            'package_id' => $package->id,
            'name' => 'v1.2.0',
            'publish_date' => '2020-01-02',
        ]);
        $otherPackageRelease = Release::factory()->create([
            'name' => 'v1.3.0',
            'publish_date' => '2020-01-03',
        ]);

        $response = $this->getLatestRelease($package->name, $oldRelease->name);

        $response->assertOk();
        $this->assertResponseHasRelease($response, $release);
    }

    public function test_最新のリリースが指定したバージョン未満なら何も返さない()
    {
        $package = Package::factory()->create();
        $release = Release::factory()->create([
            'package_id' => $package->id,
            'name' => 'v1.2.0',
            'publish_date' => '2020-01-02',
        ]);

        $response = $this->getLatestRelease($package->name, $release->name);

        $response->assertNoContent();
    }

    public function test_リリースが公開されていなかったら何も返さない()
    {
        $unpublishedRelease = Release::factory()->create();
        $package = $unpublishedRelease->package;

        $response = $this->getLatestRelease($package->name);

        $response->assertNoContent();
    }

    public function test_パッケージが登録されていなかったら失敗する()
    {
        $response = $this->getLatestRelease('example');

        $response->assertNotFound();
    }

    /**
     * 最新のリリースを取得する
     */
    protected function getLatestRelease($packageName, $version = null)
    {
        return $this->getJson(
            "/api/packages/{$packageName}/releases/latest?version={$version}"
        );
    }

    /**
     * レスポンスにリリースが含まれる
     */
    protected function assertResponseHasRelease($response, $release)
    {
        return $response->assertJson([
            'name' => $release->name,
            'url' => $release->url,
            'notes' => $release->notes,
            'publish_date' => $release->publish_date->toJson(),
        ]);
    }
}

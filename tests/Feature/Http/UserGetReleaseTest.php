<?php

namespace Entap\Laravel\Carp\Tests\Feature\Http;

use Entap\Laravel\Carp\Models\Package;
use Entap\Laravel\Carp\Models\Release;
use Illuminate\Foundation\Testing\WithFaker;
use Entap\Laravel\Carp\Tests\Feature\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGetReleaseTest extends TestCase
{
    public function test_リリースを取得する()
    {
        $release = Release::factory()
            ->published()
            ->create();
        $package = $release->package;

        $response = $this->getRelease($package->name, $release->name);

        $response->assertOk();
        $this->assertResponseHasRelease($response, $release);
    }

    public function test_パッケージ内にリリースが登録されていなかったら何も返さない()
    {
        $package = Package::factory()->create();
        $release = Release::factory()
            ->published()
            ->create();

        $response = $this->getRelease($package->name, $release->name);

        $response->assertNoContent();
    }

    public function test_リリースが廃止されていたら何も返さない()
    {
        $release = Release::factory()
            ->published()
            ->expired()
            ->create();
        $package = $release->package;

        $response = $this->getRelease($package->name, $release->name);

        $response->assertNoContent();
    }

    public function test_パッケージが登録されていなかったら失敗する()
    {
        $response = $this->getRelease('example', 'v1.0.0');

        $response->assertNotFound();
    }

    /**
     * リリースを取得する
     */
    protected function getRelease($packageName, $releaseName)
    {
        return $this->getJson(
            "/api/packages/{$packageName}/releases/{$releaseName}"
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

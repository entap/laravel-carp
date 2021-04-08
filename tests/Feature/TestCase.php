<?php
namespace Entap\Laravel\Carp\Tests\Feature;

use Entap\Laravel\Carp\CarpServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    protected function getPackageProviders($app)
    {
        return [CarpServiceProvider::class];
    }
}

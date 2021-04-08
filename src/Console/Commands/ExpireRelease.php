<?php

namespace Entap\Laravel\Carp\Console\Commands;

use Illuminate\Console\Command;
use Entap\Laravel\Carp\Models\Package;

/**
 * リリースを廃止する
 */
class ExpireRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carp:expire {package} {version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire a release.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $packageName = $this->argument('package');
        $package = Package::where('name', $packageName)->first();
        if (empty($package)) {
            $this->error("Package `{$packageName}` is not found.");
            return 1;
        }

        $releaseName = $this->argument('version');
        $release = $package
            ->releases()
            ->where('name', $releaseName)
            ->first();
        if (empty($release)) {
            $this->error("Release `{$releaseName}` is not found.");
            return 1;
        }

        if ($release->isExpired()) {
            $this->info("Release `{$releaseName}` is already expired.");
            return 0;
        }

        $release->expire();
        $this->info("Release `{$releaseName}` is expired.");
        return 0;
    }
}

<?php

namespace Entap\Laravel\Carp\Console\Commands;

use Illuminate\Console\Command;
use Entap\Laravel\Carp\Models\Package;

/**
 * リリースを公開する
 */
class PublishRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carp:publish {package} {version} {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a release.';

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
            $latestRelease = $package->latestRelease();
            if (optional($latestRelease)->isNewerThan($releaseName)) {
                $this->error(
                    "Release `{$releaseName}` is older than `{$latestRelease->name}` (latest)."
                );
                return 1;
            }
            $package->releases()->create([
                'name' => $releaseName,
                'url' => $this->argument('url'),
                'publish_date' => now(),
            ]);
            $this->info("Release `{$releaseName}` is created and published.");
            return 0;
        }

        if ($release->isPublished()) {
            $this->info("Release `{$releaseName}` is already published.");
            return 0;
        }

        if (!$this->confirmUpdatePublish($releaseName)) {
            $this->info('Canceled.');
            return 0;
        }

        $release->publish();
        $this->info("Release `{$releaseName}` is published.");
        return 0;
    }

    protected function confirmUpdatePublish($releaseName)
    {
        return $this->confirm(
            "Release `{$releaseName}` already exists. Are you sure to publish this?"
        );
    }
}

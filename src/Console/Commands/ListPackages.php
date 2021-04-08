<?php

namespace Entap\Laravel\Carp\Console\Commands;

use Illuminate\Console\Command;
use Entap\Laravel\Carp\Models\Package;

class ListPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carp:list {package?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List packages and releases.';

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
        $packages = $this->getPackages($this->argument('package'));
        $headers = [
            'Version',
            'URL',
            'Availability',
            'Publish Date',
            'Expire Date',
        ];
        foreach ($packages as $package) {
            $this->comment($package->name);
            $rows = [];
            foreach ($package->releases as $release) {
                $rows[] = [
                    $release->name,
                    $release->url,
                    $release->isAvailable() ? 'y' : '',
                    optional($release->publish_date)->format('Y-m-d H:i'),
                    optional($release->expire_date)->format('Y-m-d H:i'),
                ];
            }
            $this->table($headers, $rows);
        }

        return 0;
    }

    protected function getPackages($packageName)
    {
        $packages = Package::query();
        if ($packageName) {
            $packages->where('name', $packageName);
        }

        return $packages->get();
    }
}

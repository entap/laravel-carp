<?php
namespace Entap\Laravel\Carp\Http\Controllers;

use Illuminate\Http\Request;
use Entap\Laravel\Carp\Models\Package;

class LatestReleaseController
{
    /**
     * 最新のリリースを取得する
     */
    public function show(Request $request, Package $package)
    {
        $request->validate([
            'version' => 'nullable|string',
        ]);
        $version = $request->version;

        $release = $package->latestRelease();
        if (empty($release) || ($version && !$release->isNewerThan($version))) {
            return response()->noContent();
        }
        return $release;
    }
}

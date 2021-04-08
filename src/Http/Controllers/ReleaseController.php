<?php
namespace Entap\Laravel\Carp\Http\Controllers;

use Entap\Laravel\Carp\Models\Package;

class ReleaseController
{
    /**
     * リリースを取得する
     */
    public function show(Package $package, string $releaseName)
    {
        $release = $package
            ->releases()
            ->available()
            ->where('name', $releaseName)
            ->first();

        if (empty($release)) {
            return response()->noContent();
        }
        return $release;
    }
}

<?php

namespace Entap\Laravel\Carp\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * パッケージ
 */
class Package extends Model
{
    protected $fillable = ['name', 'description'];

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    /**
     * 最新のリリース
     */
    public function latestRelease(Carbon $at = null): ?Release
    {
        return $this->releases()
            ->available($at)
            ->latest('publish_date')
            ->first();
    }
}

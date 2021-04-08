<?php

namespace Entap\Laravel\Carp\Models;

use Entap\Laravel\Carp\Database\Factories\PackageFactory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * パッケージ
 */
class Package extends Model
{
    use HasFactory;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return PackageFactory::new();
    }
}

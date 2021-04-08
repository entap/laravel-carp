<?php

namespace Entap\Laravel\Carp\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * リリース
 */
class Release extends Model
{
    protected $fillable = [
        'name',
        'url',
        'notes',
        'publish_date',
        'expire_date',
    ];

    protected $dates = ['publish_date', 'expire_date'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * 有効なリリース
     */
    public function scopeAvailable($query, Carbon $at = null)
    {
        return $query->published($at)->notExpired($at);
    }

    /**
     * 公開されたリリース
     */
    public function scopePublished($query, Carbon $at = null)
    {
        return $query->where('publish_date', '<=', $at ?? Carbon::now());
    }

    /**
     * 廃止されていないリリース
     */
    public function scopeNotExpired($query, Carbon $at = null)
    {
        return $query->where(function ($q) use ($at) {
            $q
                ->whereNull('expire_date')
                ->orWhere('expire_date', '>', $at ?? Carbon::now());
        });
    }

    /**
     * 有効かどうか
     */
    public function isAvailable(Carbon $at = null): bool
    {
        return $this->isPublished($at) && !$this->isExpired($at);
    }

    /**
     * 公開されているかどうか
     */
    public function isPublished(Carbon $at = null): bool
    {
        return (bool) optional($this->publish_date)->lte($at ?? Carbon::now());
    }

    /**
     * 廃止されているかどうか
     */
    public function isExpired(Carbon $at = null): bool
    {
        return (bool) optional($this->expire_date)->lte($at ?? Carbon::now());
    }

    /**
     * 公開する
     */
    public function publish(Carbon $at = null)
    {
        $this->publish_date = $at ?? Carbon::now();
        return $this->save();
    }

    /**
     * 廃止する
     */
    public function expire(Carbon $at = null)
    {
        $this->expire_date = $at ?? Carbon::now();
        return $this->save();
    }

    /**
     * 指定したバージョンよりも新しいかどうか
     */
    public function isNewerThan(string $version): bool
    {
        return version_compare($this->name, $version, '>');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Drug
 * @package App\Models
 */
class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $perPage = 10;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function substances()
    {
        return $this->belongsToMany(Substance::class);
    }

    public function matches()
    {
        return $this->belongsToMany(Substance::class);
    }

    public static function substancesSearch($ids)
    {
        return function ($q) use ($ids) {
            $q->whereIn('id', $ids)->where('visible', true);
        };
    }
}

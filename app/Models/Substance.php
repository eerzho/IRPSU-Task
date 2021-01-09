<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'visible',
    ];

    protected $perPage = 5;

    public function drugs()
    {
        return $this->belongsToMany(Drug::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'title',
        'model',
        'serial',
        'asset_id'
    ];

    public function warranty() {
        return $this->hasOne(Warranty::class);
    }
}

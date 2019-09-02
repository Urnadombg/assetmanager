<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [

    ];
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_media', 'media_id', 'id');
    }
}

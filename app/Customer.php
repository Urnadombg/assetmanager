<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'address',
        'city',
        'IsLegalEntity',
        'created_at',
        'updated_at',
        'legalEntity_id'
    ];

    public function legalInfo()
    {
        return $this->hasOne(LegalEntity::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}

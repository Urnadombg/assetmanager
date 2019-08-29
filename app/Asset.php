<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'type_of_asset',
        'model',
        'location',
        'customer_id',
        'serial',
        'purchaseDate',
        'department',
        'title'
    ];

    public function components()
    {
        return $this->hasMany(Component::class);
    }
    public function warranty() {
        return $this->hasOne(Warranty::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
    public function scopeOfType($query, $type) {
        return $query->where('type_of_asset', $type);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }
}

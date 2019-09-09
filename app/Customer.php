<?php

namespace App;

use Illuminate\Console\Scheduling\Schedule;
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

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function sendEmailReminder(Schedule $schedule)
    {
//        $schedule->command()
    }
}

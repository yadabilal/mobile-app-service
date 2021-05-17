<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{

    const OPERATING_TYPE_GOOGLE = 'GOOGLE';
    const OPERATING_TYPE_IOS = 'IOS';

    protected $table = "devices";

    protected $fillable = [
        'uid',
        'app_id',
        'language',
        'client_token',
        'operating_system',
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class, "device_id");
    }

    public function generateToken()
    {
        $token = Str::random(30);

        if (Device::where(['client_token' => $token])->exists()) {
            return $this->generateToken();
        }

        return $token;
    }

    public static function boot()
    {
        static::creating(function($model){
            $model->client_token = $model->generateToken();
        });

        parent::boot();
    }
}

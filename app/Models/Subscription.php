<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    const STATUS_WAITING = 'WAITING';
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_ERROR = 'ERROR';

    protected $table = "subscriptions";

    protected $fillable = [
        'device_id',
        'expire_date',
        'status'
    ];


    protected $dates = [
        'expire_date',
        'created_at',
        'updated_at'
    ];

    public function device()
    {
        return $this->hasOne(Device::class, "id","device_id");
    }

    public function status() {

        if($this->status == Subscription::STATUS_WAITING) {
            return "Bekliyor";
        }else if($this->status == Subscription::STATUS_ERROR) {
            return "Hata";
        }

        return "Başarılı";
    }

    public static function boot()
    {
        static::creating(function($model){
            $model->status = self::STATUS_WAITING;
            if (!$model->expire_date) {
                $model->expire_date = Carbon::now()->addMonth(1);
            }
        });

        parent::boot();
    }
}

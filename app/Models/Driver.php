<?php

namespace App\Models;

use App\Notifications\Auth\DriverResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  protected $primaryKey = 'national_id';
  public $incrementing = false;
  protected $keyType = 'int';

  protected $fillable = [
    'national_id',
    'first_name',
    'last_name',
    'email',
    'phone_number',
    'password',
    'license_number',
    'vehicle_type',
    'vehicle_registration_number',
    'is_active',
    'status',
  ];
  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = bcrypt($value);
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new DriverResetPasswordNotification($token));
  }

  protected $hidden = [
    'password',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];
}

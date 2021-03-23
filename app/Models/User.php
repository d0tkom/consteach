<?php

namespace App\Models;

use App\Notifications\UserRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Order;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'timezone',
        'email',
        'password',
        'provider_id',
        'role',
        'currency',
        'spoken_languages',
        'site_language',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'spoken_languages' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function extra()
    {
        return $this->role == 'student' ? $this->hasOne(Student::class) : $this->hasOne(Teacher::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function defaultProfilePhotoUrl()
    {
        return '/img/profile_placeholder.jpg';
    }

    public static function boot() {
        parent::boot();

        static::created(function($item) {
            $item->notify(new UserRegistered($item));
        });
    }
}

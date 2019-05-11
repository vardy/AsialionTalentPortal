<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use Uuids;
    use HasRoles;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['invoices', 'personalDetails'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personalDetails() {
        return $this->hasOne(PersonalDetails::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function getProfilePicturePath($user) {
        $profilePictureID =  $user->personalDetails->profilePicture->id;

        $virtualPath = '/storage/user_data/profile_pictures/' . $profilePictureID;
        $actualPath = storage_path() . '/app/public/user_data/profile_pictures/' . $profilePictureID;
        $defaultPath = '/storage/user_data/profile_pictures/default.png';
        return file_exists($actualPath) ? $virtualPath : $defaultPath;
    }
}

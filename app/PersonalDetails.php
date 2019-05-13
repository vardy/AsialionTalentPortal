<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalDetails extends Model
{
    use Uuids;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['cv', 'profilePicture'];

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
        'first_name', 'last_name', 'email', 'skype_id',
        'country_of_residence', 'mobile_number', 'home_number',
        'highest_education', 'work_experience', 'industry_specialization',
        'language_pairs', 'tools', 'turnaround_per_day', 'currency_used',
        'translation_rate', 'editing_rate', 'transcription_rate',
        'hourly_rate', 'account_name', 'account_number', 'bank_name',
        'bank_address', 'swift_code'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cv() {
        return $this->hasOne(CV::class);
    }

    public function profilePicture() {
        return $this->hasOne(ProfilePicture::class);
    }
}

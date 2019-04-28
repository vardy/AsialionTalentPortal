<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
}

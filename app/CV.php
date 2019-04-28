<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function personalDetails() {
        return $this->belongsTo(PersonalDetails::class);
    }
}

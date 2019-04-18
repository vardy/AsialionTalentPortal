<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
}

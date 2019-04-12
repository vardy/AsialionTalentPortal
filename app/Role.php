<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Uuids;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

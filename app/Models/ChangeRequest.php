<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    protected $table = "change_request";

    public function team()
    {
        /* @return Model, Foriegn Key, Local Key */
        return $this->hasOne('App\Models\Attendees', 'cert_id', 'cert_id');
    }
}

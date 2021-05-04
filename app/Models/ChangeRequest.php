<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    protected $table = "change_request";


    /**
     * Get Team Info => Retrieve Team Info
     * @author Tittu Varghese (tittu@servntire.com)
     */

    public function team()
    {
        /* @return Model, Foriegn Key, Local Key */
        return $this->hasOne('App\Models\Attendees', 'team_id', 'team_id');
    }
}

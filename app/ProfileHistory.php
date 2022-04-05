<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileHistory extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'news_id' => 'required',
        'edited_at' => 'required',
    );
    // Profile?? Model??に関連付けを行う
    public function profile()
    {
        return $this->belongsTo('App\Profile');

    }
    
}

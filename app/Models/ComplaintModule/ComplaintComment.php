<?php

namespace App\Models\ComplaintModule;

use App\Models\UserModule\User;
use Illuminate\Database\Eloquent\Model;

class ComplaintComment extends Model
{
    public function user(){
        return $this->belongsTo(User::class,"user_id", "id");
    }
}

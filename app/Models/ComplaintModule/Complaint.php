<?php

namespace App\Models\ComplaintModule;

use App\Models\UserModule\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    public function created_user(){
        return $this->belongsTo(User::class,"created_by","id");
    }
}

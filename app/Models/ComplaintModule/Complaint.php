<?php

namespace App\Models\ComplaintModule;

use App\Models\UserModule\User;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\FilePathTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

    use HasFactory, FilePathTrait;

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $common_service = new CommonService();

        return $this->image ? $common_service->get_image_link($this->image, $this->get_file_path("complaint")) : null;
    }

    public function created_user(){
        return $this->belongsTo(User::class,"created_by","id");
    }
}

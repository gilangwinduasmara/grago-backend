<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected $guarded = ['id'];

    public function getUrlAttribute()
    {
        return asset('storage/' . str_replace('public/', '', $this->path));
    }

    public function saveForModel($model)
    {
        $this->fileable_id = $model->id;
        $this->fileable_type = get_class($model);
        return $this->save();
    }
}

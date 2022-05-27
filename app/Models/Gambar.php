<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'gambar';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function scopeTodolist($q)
    {
        return $q->where('imageable_type','App\Models\Todolist');
    }

    public function scopeTask($q)
    {
        return $q->where('imageable_type','App\Models\Task');
    }

    public function scopeImage($q, $type='')
    {
        $model='';
        if($type=='task'){
            $model='App\Models\Task';
        }elseif($type=='todolist'|| $type==''){
            $model = 'App\Models\Todolist';
        }
        return $q->where('imageable_type',$model);
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}

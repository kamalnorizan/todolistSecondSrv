<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StatusScope;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new StatusScope);
    }

    /**
     * Get the todolist that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function todolist()
    {
        return $this->belongsTo(Todolist::class, 'todolist_id', 'id');
    }

    public function images()
    {
        return $this->morphMany(Gambar::class,'imageable');
    }
}

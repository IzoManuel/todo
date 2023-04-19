<?php

namespace Modules\Task\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'due-date',
        'status_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Task\Database\factories\TaskFactory::new();
    }

    /**
     * The tasks that belong to the user.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

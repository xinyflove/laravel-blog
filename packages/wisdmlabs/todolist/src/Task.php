<?php

namespace wisdmlabs\todolist;

use Illuminate\Database\Eloquent\Model;

/**
 * Model of the table tasks.
 */
class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
    ];
}

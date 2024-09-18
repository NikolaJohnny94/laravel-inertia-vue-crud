<?php

namespace App\Utils;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Task;


class TaskUtils
{
    public static function handleTaskNotFound(string $id)
    {
        if (Task::where('id', $id)->exists()) {
            throw new AuthorizationException();
        } else {
            throw new ModelNotFoundException();
        }
    }
}

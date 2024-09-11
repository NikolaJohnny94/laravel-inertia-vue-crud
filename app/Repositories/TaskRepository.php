<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function findTaskById(string $id)
    {
        return Task::find($id);
    }

    public function updateTask(Task $task, array $data)
    {
        $task->update($data);
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
}

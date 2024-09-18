<?php

namespace App\Repositories;

use App\Models\Task;
use App\Utils\TaskUtils;
use App\Utils\UserUtils;


class TaskRepository
{

    protected $userUtils;

    public function __construct(UserUtils $userUtils)
    {
        $this->userUtils = $userUtils;
    }
    public function getAllTasks()
    {
        $user = $this->userUtils->getCurrentUser();
        $tasks = Task::where('user_id', $user->id)->get();
        return $tasks;
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function findTaskById(string $id)
    {
        $user = $this->userUtils->getCurrentUser();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task)
            TaskUtils::handleTaskNotFound($id);

        return $task;
    }

    public function updateTask($id, array $data)
    {
        $task = $this->findTaskById($id);
        $task->update($data);
    }

    public function deleteTask(string $id)
    {
        $task = $this->findTaskById($id);
        $task->delete();
    }
}

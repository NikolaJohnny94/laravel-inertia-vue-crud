<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskRepository->getAllTasks();
        return Inertia::render('Task/Tasks', ['tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tasks')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
                ],
                'description' => 'required|string|max:255',
                'category' => 'required|in:work,personal,other',
                'finished' => 'required|boolean',
            ],
            ['title.unique' => 'Task with this title already exists.',]
        );

        $this->taskRepository->createTask(array_merge($validatedData, ['user_id' => Auth::id()]));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, string $slug)
    {
        $task = $this->taskRepository->findTaskById($id);
        return Inertia::render('Task/TaskDetails', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('tasks')->where(function ($query) use ($id) {
                    return $query->where('user_id', Auth::id())->where('id', '<>', $id);
                    ;
                }),
            ],
            'description' => 'sometimes|required|string',
            'finished' => 'sometimes|required|boolean',
            'category' => 'sometimes|required|in:work,personal,other',
        ]);

        $this->taskRepository->updateTask($id, $validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->taskRepository->deleteTask($id);
    }
}

<?php

namespace Modules\Task\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Task\Entities\Task;
use Modules\Task\Http\Requests\StoreTaskRequest;
use Modules\Task\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;
use Modules\Task\Transformers\TaskResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $tasks = Task::paginate(10);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'status_id' => $request->statusId
        ]);
        
        return $this->sendResponse(null,'Task creation successful');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return TaskResource
     */
    public function show($id): TaskResource
    {
        $task = Task::find($id);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateTaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'status_id' => $request->statusId
        ]);

        return $this->sendResponse(null,'Task update successful');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::find($id);

        $task->delete();

        return $this->sendResponse(null, 'Task deleted');
    }
}

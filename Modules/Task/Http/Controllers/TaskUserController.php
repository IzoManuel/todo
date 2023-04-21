<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Modules\Task\Http\Requests\AssignTaskRequest;
use Modules\Task\Http\Requests\UnassignTaskRequest;
use Modules\Task\Http\Requests\UpdateAssignedTaskRequest;
use Modules\User\Entities\User;
use Modules\Task\Entities\Task;
use Illuminate\Http\JsonResponse;
use Modules\Task\Entities\TaskUser;
use Modules\User\Transformers\UserResource;
use Illuminate\Support\Arr;


class TaskUserController extends BaseController
{

    /**
     * Assign task to specific user.
     * @param AssignTaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function assignTask(AssignTaskRequest $request, $taskId): JsonResponse
    {
        $user = User::find($request->userId);

        $task = $user->tasks->find($taskId);
        if(!$task){
            $user->tasks()->attach(
                $taskId,[
                    'due_date' => $request->dueDate,
                    'start_time' => $request->startTime,
                    'end_time' => $request->endTime,
                    'remarks' => $request->remarks,
                    'status_id' => $request->statusId
                ]);
        }else{
            TaskUser::withTrashed()->find($task->pivot->id)->restore();
        }

        return $this->sendResponse(null,'Task assigned');
    }

    /**
     * Unassign task to specific user.
     * @param UnassignTaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function unassignTask(UnassignTaskRequest $request, $taskId): JsonResponse
    {
        $user = User::find($request->userId);

        $user->tasks()->detach($taskId);

        return $this->sendResponse(null,'Task unassigned');
    }

    /**
     * Update assigned task.
     * @param UpdateAssignedTaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateAssignedTask(UpdateAssignedTaskRequest $request, $taskId): JsonResponse
    {
        $user = User::find($request->userId);

        $user->tasks()->updateExistingPivot(
            $taskId,[
                'due_date' => $request->dueDate,
                'start_time' => $request->startTime,
                'end_time' => $request->endTime,
                'remarks' => $request->remarks,
                'status_id' => $request->statusId
            ]);

        return $this->sendResponse(null,'Assigned task updated');
    }

    public function assignees($id)
    {
        $assignees = Task::find($id)->users->map(function($value, $key){
            if(!$value->pivot->deleted_at){
                return $value;
            }
        })->filter();

        return UserResource::collection($assignees);
    }
}

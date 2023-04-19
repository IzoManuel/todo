<?php

namespace Modules\Status\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Status\Entities\Status;
use Modules\Status\Http\Requests\StoreStatusRequest;
use Modules\Status\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\JsonResponse;
use Modules\Status\Transformers\StatusResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $statuses = Status::paginate(10);

        return StatusResource::collection($statuses);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreStatusRequest $request
     * @return JsonResponse
     */
    public function store(StoreStatusRequest $request): JsonResponse
    {
        $status = Status::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'status_id' => $request->statusId
        ]);
        
        return $this->sendResponse(null,'Status creation successful');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return StatusResource
     */
    public function show($id): StatusResource
    {
        $status = Status::find($id);

        return new StatusResource($status);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateStatusRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateStatusRequest $request, $id): JsonResponse
    {
        $status = Status::find($id);

        $status->update([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'status_id' => $request->statusId
        ]);

        return $this->sendResponse(null,'Status update successful');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $status = Status::find($id);

        $status->delete();

        return $this->sendResponse(null, 'Status deleted');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        return TaskResource::collection(
            Task::withTrashed()
                ->when(!$user->is_admin, function ($q) use ($user) {
                    return $q->where('user_id', '=', (int)$user->id);
                })
                ->with('user')
                ->get()
        );
    }
    public function changeStatus(ChangeTaskStatusRequest $request, Task $task)
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        if (!($task->update($request->validated()))) abort(500, __('Update error.'));
        $task->load('user');

        return new TaskResource($task);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

             if (!($task = Task::create($request->validated()))) abort(500, __('Create error'));

        $task->load('user');

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        return new TaskResource($task);
    }

    /**+
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        if (!($task->update($request->validated()))) abort(500, __('Update error.'));

        $task->load('user');

        return new TaskResource($task);
    }

    public function restore(int $task)
    {

        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        if (!$task = Task::withTrashed()->find($task)) {
            abort(404, __('A keresett task nem található.'));
        }

        try {
            if ($task->deleted_at) {
                $task->restore();
                return response(
                    ['data' => [
                        'task' => $task,
                    ],
                        'message' => __('Aktiválva')
                    ],
                    201);
            } else {
                return response(
                    ['data' => [
                        'task' => $task,
                    ],
                        'message' => __('Már aktív volt')
                    ],
                    201);
            }
        } catch (exception $e) {
            info($e);
            abort(500, 'Nem sikerült törölni...');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $task)
    {
        abort_if(!$user = Auth::guard('sanctum')->user(), 401, __('Unauthorized'));

        if (!$task = Task::withTrashed()->find($task)) {
            abort(404, __('A keresett task nem található.'));
        }
        try {
            if (is_null($task->deleted_at)) {
                $task->delete();
                return response(
                    ['data' => [
                        'task' => $task,
                    ],
                        'message' => __('Inaktiválva')
                    ],
                    201);
            } else {
                $task->forceDelete();
                return response(
                    ['data' => [
                        'task' => $task,
                    ],
                        'message' => __('Véglegesen törölve')
                    ],
                    201);
            }
        } catch (exception $e) {
            info($e);
            abort(500, 'Nem sikerült törölni...');
        }


    }
}

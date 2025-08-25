<?php

namespace App\Http\Controllers;

use App\Events\TaskUpdated;
use App\Models\Task;
use App\Models\Task_assignees;
use App\Models\Task_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'project_id' => 'required|exists:projects,id',
                'status' => 'required|string',
                'deadline' => 'required|date_format:Y-m-d H:i',
                'title' => 'required|string',
                'user_id' => 'required|array',
                'user_id.*' => 'exists:users,id',
            ],
            [
                'project_id.required' => 'Dự án chưa được gán',
                'project_id.exists' => 'Dự án không tồn tại',
                'status.required' => 'Trạng thái chưa được gán',
                'deadline.required' => 'Thời hạn hoàn thành là bắt buộc',
                'deadline.date_format' => 'Định dạng thời hạn không hợp lệ',
                'title.required' => 'Vui lòng điền tiêu đề',
                'user_id.required' => 'Bạn chưa chọn người thực hiện',
                'user_id.array' => 'Danh sách người thực hiện không hợp lệ',
                'user_id.*.exists' => 'Người dùng được chọn không tồn tại',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::id();
        if (!$user) {
            return response()->json(['message' => 'User chưa đăng nhập'], 401);
        }

        DB::beginTransaction();

        try {
            $task = new Task();
            $task->project_id = $request->project_id;
            $task->created_by = $user;
            $task->title = $request->title;
            $task->status = $request->status;
            $task->deadline = $request->deadline;
            $task->description = $request->description;
            $task->save();

            if ($request->has('user_id') && is_array($request->user_id)) {
                $task->assignees()->sync($request->user_id);
            } else {
                $task->assignees()->sync([]);
            }

            $task_history = new Task_history();
            $task_history->task_id = $task->id;
            $task_history->changed_by = $user;
            $task_history->new_value = 'Nhiệm vụ đã được tạo';
            $task_history->save();

            DB::commit();

            return response()->json([
                'message' => 'Thêm thành công',
                'task' => $task
            ], 201);
        } catch (\Exception $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Có lỗi xảy ra, không thể tạo nhiệm vụ.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|string',
        ], [
            'task_id.required' => 'ID task không được bỏ trống',
            'task_id.exists' => 'Task không tồn tại',
            'status.required' => 'Trạng thái không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::id();
        if (!$user) {
            return response()->json(['message' => 'User chưa đăng nhập'], 401);
        }

        $task = Task::find($request->task_id);
        $task->status = $request->status;

        $task_history = new Task_history();
        $task_history->task_id = $task->id;
        $task_history->changed_by = $user;
        $task_history->change_type = 'Giai đoạn';
        $task_history->new_value = $request->new_value;
        $task_history->old_value = $request->old_value;
        $task_history->save();
        if ($task->save()) {
            return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
        } else {
            return response()->json(['message' => 'Cập nhật thất bại'], 500);
        }
    }
    public function updateDescription(Request $request)
    {

        $user = Auth::id();
        if (!$user) {
            return response()->json(['message' => 'User chưa đăng nhập'], 401);
        }

        $task = Task::find($request->task_id);
        $task->description = $request->description;

        if ($task->save()) {
            event(new TaskUpdated($task->description));
            return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
        } else {
            return response()->json(['message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $url = asset('storage/' . $path);
            return response()->json(['url' => $url]);
        }
        return response()->json(['error' => 'No image uploaded'], 400);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::with(
            [
                'history' => function ($query) {
                    $query->orderByDesc('changed_at');
                },
                'history.creator',
                'creator',
                'assignees',
                'project',
                'project.users'
            ]
        )
            ->withAggregate([
                'history' => fn($query) => $query->where('change_type', 'Giai đoạn')
            ], 'changed_at', 'max')
            ->find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Không tìm thấy task'
            ], 404);
        }

        return response()->json([
            'task' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Không tìm thấy task'
            ], 404);
        }
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'message' => 'Chưa đăng nhập'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $task->project_id = $request->project_id;
            $task->title = $request->title ?? '';
            $task->description = $request->description ?? null;
            $task->status = $request->status ?? null;
            $task->deadline = $request->deadline ?? null;
            $task->save();

            if ($request->has('user_id') && is_array($request->user_id)) {
                $task->assignees()->sync($request->user_id);
            } else {
                $task->assignees()->sync([]);
            }

            $task_history = new Task_history();
            $task_history->task_id = $id;
            $task_history->changed_by = $userId;
            $task_history->change_type = $request->change_type;
            $task_history->old_value = $request->old_value;
            $task_history->new_value = $request->new_value;
            $task_history->save();

            DB::commit();
            event(new TaskUpdated($task));
            return response()->json([
                'message' => 'Cập nhật thành công'
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

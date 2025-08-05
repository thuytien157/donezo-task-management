<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Events\TaskUpdated;
use App\Models\Project;
use App\Models\Project_member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $currentUserId = Auth::id();

        $projects = Project::withCount('tasks')
            ->where('owner_id', $currentUserId)
            ->orWhereHas('users', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            })
            ->get();

        return response()->json([
            'projects' => $projects
        ]);
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
                'owner_id' => 'required',
                'title' => 'required|string|unique:projects,title',
                'is_group_project' => 'required|boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'status' => 'required',
            ],
            [
                'owner_id.required' => 'Vui lòng đăng nhập',
                'title.required' => 'Vui lòng nhập tiêu đề dự án',
                'title.string' => 'Tiêu đề chỉ có thể chứa chữ cái, không chứa số và các ký tự đặc biệt',
                'start_date.required' => 'Vui lòng nhập ngày bắt đầu',
                'start_date.date' => 'Ngày bắt đầu không đúng định dạng',
                'end_date.required' => 'Vui lòng nhập ngày kết thúc',
                'end_date.date' => 'Ngày kết thúc không đúng định dạng',
                'status.required' => 'Vui lòng chọn trạng thái',
                'is_group_project.required' => 'Vui lòng chọn loại dự án',
                'title.unique' => 'Tiêu đề dự án không được trùng nhau',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };

        if (strtotime($request->end_date) < strtotime($request->start_date)) {
            return response()->json([
                'errors' => [
                    'end_date' => ['Ngày kết thúc không được nhỏ hơn ngày bắt đầu']
                ]
            ], 422);
        }

        $newproject = new Project();
        $newproject->owner_id = $request->owner_id;
        $newproject->title = $request->title;
        $newproject->description = $request->description;
        $newproject->is_group_project = $request->is_group_project;
        $newproject->start_date = $request->start_date;
        $newproject->end_date = $request->end_date;
        $newproject->status = $request->status;

        if ($newproject->save()) {
            $projectMember = new Project_member();
            $projectMember->project_id = $newproject->id;
            $projectMember->user_id = $request->owner_id;
            $projectMember->role = 'leader';
            $projectMember->joined_at = Carbon::now();
            $projectMember->save();
        }


        return response()->json([
            'message' => 'Thêm dự án thành công',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('tasks.creator', 'tasks.assignees', 'users')->find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Dự án không tồn tại'
            ], 404);
        };
        $list = $project->tasks;
        $grouped = $list->groupBy('status');

        foreach (TaskStatusEnum::cases() as $key => $value) {
            $status = $value->value;
            $taskByStatus[$status] = $grouped->get($status, collect());
        }

        $members = $project->users;
        $membersWithRole = $members->sortBy(function ($user) {
            return $user->pivot->role === 'leader' ? 0 : 1;
        })->values();

        return response()->json([
            'tasks_by_status' => $taskByStatus,
            'member' => $membersWithRole,
            'project_name' => $project->title,
            'isGroup' => $project->is_group_project
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::with('creator')->find($id);

        return response()->json([
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        $project->description = $request->description;
        $project->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

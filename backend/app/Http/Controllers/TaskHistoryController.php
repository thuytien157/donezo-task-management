<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Task_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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

        $user = Auth::id();
        $task_history = new Task_history();
        $task_history->task_id = $request->task_id;
        $task_history->changed_by = $user;
        $task_history->content = $request->content;
        // $task_history->image = $request->image;
        $task_history->save();

        return response()->json([
            'message' => 'Thêm thành công'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task_history = Task_history::with('creator')->where('task_id', $id)
            ->orderByDesc('changed_at')
            ->get();
        return response()->json([
            'task_history' => $task_history
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\Invite;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\Project_member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

Carbon::setLocale('vi');
date_default_timezone_set('Asia/Ho_Chi_Minh');
class ProjectMemberController extends Controller
{
    // public function getMemberByProject($project_id){
    //     $projectMember = Project_member::with('user')->where('project_id', $project_id)->get();

    //     return response()->json([
    //         'projectMember' => $projectMember
    //     ]);
    // }

    public function inviteMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }



        $project = Project::find($request->project_id);

        $token = Str::random(64);
        $invitation = new Invitation();
        $invitation->project_id = $project->id;
        $invitation->invited_by_user_id = Auth::id();
        $invitation->invited_email = $request->email;
        $invitation->token = $token;
        $invitation->status = 'pending';
        $invitation->expires_at = Carbon::now()->addDays(3);
        $invitation->save();
        $inviteLink = env('FRONTEND_URL') . '/invite?token=' . $token;

        try {
            Mail::to($request->email)->queue(new Invite($inviteLink, $project->title));

            return response()->json(['message' => 'Lời mời đã được gửi thành công.']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi email mời: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'email' => $request->email,
            ]);

            $invitation->delete();

            return response()->json(['message' => 'Đã xảy ra lỗi. Không thể gửi lời mời.'], 500);
        }
    }

    public function acceptInvitation(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:64',
        ]);

        $invitation = Invitation::where('token', $request->token)
            ->where('status', 'pending')
            ->first();

        if (!$invitation) {
            return response()->json(['message' => 'Lời mời không hợp lệ.'], 404);
        }
        if ($invitation->expires_at && Carbon::now()->gt($invitation->expires_at)) {

            $invitation->update(['status' => 'expired']);
            return response()->json(['message' => 'Lời mời đã hết hạn.'], 404);
        }

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập để chấp nhận lời mời.'], 401);
        }

        if ($invitation->invited_email !== $user->email) {
            return response()->json(['message' => 'Lời mời này không dành cho bạn.'], 403);
        }

        $isMember = Project_member::where('user_id', $user->id)
            ->where('project_id', $invitation->project_id)
            ->exists();

        if ($isMember) {
            $invitation->update(['status' => 'accepted']);
            return response()->json(['message' => 'Bạn đã là thành viên của dự án này.'], 200);
        }

        $projectMember = new Project_member();
        $projectMember->user_id = $user->id;
        $projectMember->project_id = $invitation->project_id;
        $projectMember->role = 'member';
        $projectMember->joined_at = Carbon::now();
        $projectMember->save();

        $invitation->update(['status' => 'accepted']);

        return response()->json(['message' => 'Bạn đã tham gia dự án thành công.'], 200);
    }
}

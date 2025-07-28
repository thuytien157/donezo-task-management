<?php

namespace App\Http\Controllers;

use App\Mail\ResetPass;
use App\Models\PasswordReset;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class UserController extends Controller
{
    function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|string',
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'password_confirmation' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            [
                'fullname.required' => 'Vui lòng nhập tên',
                'fullname.string' => 'Tên chỉ có thể chứa chữ cái',
                'email.required' => 'Vui lòng nhập email',
                'email.unique' => 'Email đã được sử dụng',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.confirmed' => 'Mật khẩu xác nhận không đúng',
                'password.min' => 'Mật khẩu phải có ít nhất 6 chữ số',
                'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',

            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };

        $user = new User;
        $user->fullname = $request->fullname;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($request->fullname);
        $user->save();
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json(
            [
                'message' => 'Đăng ký thành công',
                'user' => $user->avatar,
                'token' => $token
            ],
            201
        );
    }

    function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 6 chữ số',
                'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'user' => $user->avatar,
            'token' => $token
        ]);
    }

    function logout()
    {
        $user = Auth::user();
        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Đăng xuất thành công!'
        ]);
    }

    function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                return redirect("http://localhost:5173/login-success?error=" . urlencode('Email đã được đăng ký, vui lòng đăng nhập bằng mật khẩu hoặc phương thức khác.'));
            }
            if (!$user) {
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'fullname' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                    'password' => bcrypt('default_password')
                ]);
            }

            $token = $user->createToken('token')->plainTextToken;
            // return response()->json([
            //     'token' => $token,
            //     'user' => $user->avatar
            // ]);
            return redirect("http://localhost:5173/login-success?token=$token&user=" . urlencode(json_encode($user->avatar)));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đăng nhập thất bại!',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    // public function sendResetLink(Request $request)
    // {
    //     $request->validate(['email' => 'required|email']);
    //     $user = User::where('email', $request->email)->first();
    //     if (!$user) {
    //         return response()->json(['message' => 'Email không tồn tại trong hệ thống!'], 404);
    //     }
    //     $token = Str::random(64);
    //     $passwordReset = new PasswordReset;
    //     $passwordReset->email = $request->email;
    //     $passwordReset->token = $token;
    //     $passwordReset->created_at = Carbon::now();

    //     $resetLink = env('FRONTEND_URL') . '/reset-password?token=' . $token . '&email=' . urlencode($request->email);

    //     Mail::to($request->email)->send(new ResetPass($resetLink));

    //     return response()->json(['message' => 'Link đặt lại mật khẩu đã được gửi!']);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'email' => 'required|email',
    //             'token' => 'required|string',
    //             'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
    //         ],
    //         [
    //             'email.required' => 'Vui lòng nhập email',
    //             'email.email' => 'Email không đúng định dạng',
    //             'password.required' => 'Vui lòng nhập mật khẩu',
    //             'password.min' => 'Mật khẩu phải có ít nhất 6 chữ số',
    //             'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     };
    //     $reset = PasswordReset::where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //     if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
    //         return response()->json(['message' => 'Token không hợp lệ hoặc đã hết hạn.'], 400);
    //     }


    //     $user = User::where('email', $request->email)->first();
    //     $user->password = bcrypt($request->password);
    //     $user->save();
    //     // PasswordReset::where('email', $request->email)->delete();

    //     return response()->json(['message' => 'Đặt lại mật khẩu thành công!']);
    // }
}

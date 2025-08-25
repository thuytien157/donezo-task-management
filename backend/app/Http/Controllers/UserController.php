<?php

namespace App\Http\Controllers;

use App\Mail\ResetPass;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
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

    private function generateUniqueUsername(int $length = 8, string $prefix = 'user_')
    {
        $username = '';
        $isUnique = false;

        do {
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            $generatedUsername = $prefix . $randomString;

            $isUnique = !User::where('username', $generatedUsername)->exists();

            if ($isUnique) {
                $username = $generatedUsername;
            }
        } while (!$isUnique);

        return $username;
    }


    function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'password_confirmation' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            [
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
        $user->username = $this->generateUniqueUsername();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->avatar = json_encode('https://ui-avatars.com/api/?name=' . urlencode($user->username));
        $user->save();
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json(
            [
                'message' => 'Đăng ký thành công',
                'user' => $user->id,
                'avatar' => $user->avatar,
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
            'user' => $user->id,
            'avatar' => json_encode($user->avatar),
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

            // Email đã tồn tại và là tài khoản đăng ký bằng mật khẩu
            if ($user && $user->provider_name === null) {
                $token = $user->createToken('token')->plainTextToken;
                return redirect("https://donezo-vue.netlify.app/login-success?token=$token&login_existing_account=true");
            }

            // Email chưa tồn tại, tạo tài khoản mới
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

            // Đăng nhập thành công (tài khoản mới hoặc tài khoản social đã tồn tại)
            $token = $user->createToken('token')->plainTextToken;
            return redirect("https://donezo-vue.netlify.app/login-success?token=$token&user=" . urlencode(json_encode($user->avatar)) . '&id=' . $user->id);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đăng nhập thất bại!',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    function sendResetLink(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email:rfc,dns',
            ],
            [
                'email.required' => 'Vui lòng nhập email!',
                'email.email' => 'Email không đúng định dạng',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };


        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại trong hệ thống!'], 404);
        }
        $token = Str::random(64);
        $passwordReset = new PasswordReset;
        $passwordReset->email = $request->email;
        $passwordReset->token = $token;
        $passwordReset->created_at = Carbon::now();
        $passwordReset->save();
        $resetLink = env('FRONTEND_URL') . '/reset-password?token=' . $token . '&email=' . urlencode($request->email);

        Mail::to($request->email)->send(new ResetPass($resetLink));

        return response()->json(['message' => 'Link đặt lại mật khẩu đã được gửi!']);
    }

    function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/|confirmed',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 6 chữ số',
                'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };
        $reset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'Token không hợp lệ hoặc đã hết hạn.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        PasswordReset::where('email', $request->email)->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'message' => 'Đặt lại mật khẩu thành công!',
                'avatar' => json_encode($user->avatar),
                'user' => $user->id,
                'token' => $token
            ]
        );
    }
}

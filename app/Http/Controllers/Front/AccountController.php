<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Service\Order\OrderServiceInterface;
use App\Service\User\UserServiceInterface;
use App\Utilities\Constant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    private $userService;
    private $orderService;

    public function __construct(UserServiceInterface $userService, OrderServiceInterface $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function checkLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => [Constant::user_level_Client],
        ];

        $remember = $request->remember;

        if(Auth::attempt($credentials, $remember)) {
            // Kiểm tra email đã được xác minh chưa
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('notification', 'Vui lòng xác minh email trước khi đăng nhập. Kiểm tra hộp thư của bạn.');
            }

            Session::put('client_logged_in', true);
            Session::put('client_id', Auth::id());
            Session::put('client_name', Auth::user()->name);
            Session::put('client_email', Auth::user()->email);
            return redirect()->intended('/');
        } else {
            return back()->with('notification', 'Email hoặc mật khẩu không đúng. Vui lòng thử lại.');
        }
    }

    public function logout()
    {
        Session::forget('client_logged_in');
        Session::forget('client_id');
        Session::forget('client_name');
        Session::forget('client_email');
        Auth::logout();
        
        return back();
    }
    
    public function register()
    {
        return view('front.account.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        try {          
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'level' => Constant::user_level_Client,
            ]);
       
            // Gửi email xác minh
            event(new Registered($user));

            return redirect('./account/login')
                ->with('notification', 'Đăng ký thành công! Vui lòng kiểm tra email để xác minh tài khoản.');
                
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('notification', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function profileInfo()
    {
        $user = Auth::user();
        return view('front.account.profile-info', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:500',
            'town_city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'street_address.required' => 'Vui lòng nhập địa chỉ',
            'town_city.required' => 'Vui lòng chọn tỉnh/thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
        ]);

        try {
            $user = Auth::user();
            $user->update($validated);

            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function userOrders()
    {
        if (!Auth::check()) {
            return redirect('/account/login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng.');
        }
        $orders = Order::with([
            'orderDetails.product.productImages',           
        ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.account.user-orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        if (!Auth::check()) {
            return redirect('/account/login')->with('error', 'Vui lòng đăng nhập để xem chi tiết đơn hàng.');
        }

        $order = Order::with([
            'orderDetails.product.productImages',
            'orderDetails.voucher'
        ])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('front.account.order-detail', compact('order'));
    }

    public function cancelOrder(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/account/login')->with('error', 'Vui lòng đăng nhập.');
        }

        try {
            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $allowedStatuses = [
                Constant::order_status_Unconfirmed,
                Constant::order_status_Confirmed,
                Constant::order_status_Processing
            ];

            if ($order->payment_type !== 'COD') {
                return back()->with('error', 'Chỉ có thể hủy đơn hàng thanh toán COD.');
            }

            if (!in_array($order->status, $allowedStatuses)) {
                return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
            }

            $order->status = Constant::order_status_Canceled;
            $order->save();

            return back()->with('success', 'Đơn hàng #' . $order->id . ' đã được hủy thành công.');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->email))) {
            return redirect('/account/login')->with('notification', 'Link xác minh không hợp lệ.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/account/login')->with('notification', 'Email đã được xác minh trước đó.');
        }

        $user->markEmailAsVerified();

        return redirect('/account/login')->with('notification', 'Xác minh email thành công! Bạn có thể đăng nhập ngay.');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('notification', 'Email không tồn tại trong hệ thống.');
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('notification', 'Email đã được xác minh.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('notification', 'Email xác minh đã được gửi lại! Vui lòng kiểm tra hộp thư.');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        try {
            $user = Auth::user();
           
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
            }

            if (Hash::check($request->new_password, $user->password)) {
                return redirect()->back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu hiện tại!');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
            
        } catch (\Exception $e) {
            Log::error('Change password error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function forgotPassword()
    {
        return view('front.account.forgot-password');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại trong hệ thống'
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('notification', 'Link đặt lại mật khẩu đã được gửi đến email của bạn!');
            }

            return back()->with('notification', 'Không thể gửi email. Vui lòng thử lại.');
            
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->with('notification', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


    public function resetPassword($token)
    {
        return view('front.account.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect('/account/login')->with('notification', 'Mật khẩu đã được đặt lại thành công! Bạn có thể đăng nhập.');
            }

            return back()->with('notification', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.');
            
        } catch (\Exception $e) {
            Log::error('Password update error: ' . $e->getMessage());
            return back()->with('notification', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
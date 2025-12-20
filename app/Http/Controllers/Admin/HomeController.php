<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function getLogin()
    {
        if (Session::has('admin_id')) {
            return redirect('admin/users');
        }
        
        return view('admin.login');
    }
    
    public function postLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
     
        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->level == Constant::user_level_Admin) {
                
                Session::put('admin_id', $user->id);
                Session::put('admin_name', $user->name);
                Session::put('admin_email', $user->email);
                
                return redirect('admin/users');
            } else {
                return back()->with('notification', 'Bạn không có quyền truy cập vào trang này!');
            }
        } else {
            return back()->with('notification', 'Sai email hoặc mật khẩu!');
        }
    }
    
    public function logout()
    {
        Session::forget('admin_id');
        Session::forget('admin_name');
        Session::forget('admin_email');
        
        return redirect('admin')->with('notification', 'Đăng xuất thành công!');
    }
}
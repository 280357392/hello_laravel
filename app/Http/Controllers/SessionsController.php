<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //guest 属性进行设置，只让未登录用户访问登录页面和注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //显示登陆界面
    public function create()
    {
        return view('sessions.create');
    }

    //登陆
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

//        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // 该用户存在于数据库，且邮箱和密码相符合
//        }

        if (Auth::attempt($credentials,$request->has('remember'))) {
            // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');
            //Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由
            //intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
        } else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            //这时如果尝试输入错误密码则会显示登录失败的提示信息。使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容
            return redirect()->back()->withInput();
        }
    }

    //退出登录
    public function destroy(){
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
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

        if (Auth::attempt($credentials)) {
            // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');
            //Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            //这时如果尝试输入错误密码则会显示登录失败的提示信息。使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容
            return redirect()->back()->withInput();
        }
    }

    public function destroy(){
        return 'destroy';
    }
}

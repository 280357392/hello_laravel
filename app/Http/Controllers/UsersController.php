<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

//表名称+Controller
class UsersController extends Controller
{
    //首页点击'注册'按钮 -> 执行create方法显示注册页面
    public function create()
    {
        return view('users.create');
    }

    //显示用户信息
    // get /users/{user}  变量名匹配路由片段
    public function show(User $user)
    {
        //$user 查询对象
        return view('users.show', compact('user'));
    }

    //使用该参数$request来获得用户的所有输入数据
    //点击注册界面的'注册'按钮 -> 数据post提交到store方法处理
    public function store(Request $request)
    {
        /*
        中文提示：
                1.下载：
                    $ composer require "overtrue/laravel-lang:~3.0"
                2.修改config/app.php：
                    Illuminate\Translation\TranslationServiceProvider::class,
                    替换为：
                    Overtrue\LaravelLang\TranslationServiceProvider::class,
                    return [
                     .
                     'locale' => 'zh-CN',
                     .
                    ];
                3.配置缓存重新加载：$ php artisan config:cache
                4.属性或者验证消息改写：
                    resources/lang/zh-CN/validation.php 中编写你需要定制的部分即可
         */

        //第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则。
        //如果验证不通过，终止运行当前方法，重定向到上个方法（相当于刷新当前页），并显示错误提示
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        //数据验证通过后
        //将用户提交的信息存储到数据库
        //创建成功后会返回一个用户对象
        //如果字段名写错了会报错
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]
        );

        //注册完自动登陆
        Auth::login($user);

        //flash 方法，缓存数据只在下一次的请求内有效
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        //重定向到users.show个人信息页面
        return redirect()->route('users.show', [$user]);
    }

    //个人信息编辑界面
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //update 动作来处理用户提交的个人信息。
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            //如果填写了密码
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }

}

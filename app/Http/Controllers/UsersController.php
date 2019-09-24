<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

//表名称+Controller
class UsersController extends Controller
{
    //
    public function create(){
        //显示注册页面
        return view('users.create');
    }

    // get /users/{user}  变量名匹配路由片段
    public function show(User $user){
        //$user 查询对象
        return view('users.show',compact('user'));
    }

}

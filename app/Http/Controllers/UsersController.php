<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {

        return view('users.show', compact('user'));
    }

    //修改
    public function edit(User $user){
        return view('users/edit', compact('user'));
    }
    //保存添加
    public function store(User $user, Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required|max:50',
            'email' =>  'required|email|unique:users|max:55',
            'password'  =>  'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'      =>   $request->name,
            'email'     =>  $request->email,
            'password'  =>  bcrypt($request->password)
        ]);
        Auth::login($user);
        session()->flash('success','welcome to the  new world!');
        return redirect()->route('users.show',[$user]);
    }
    //保存修改
    public function update(Request $request){
        $this->validate($request, [
            'name'  => 'required|max:50',
            'password'  =>  'required|confirmed|min:6'
        ]);

        $user->update([
            'name'  =>  $request->name,
            'password'  =>  bcrypt($request->password)
        ]);

    }
}

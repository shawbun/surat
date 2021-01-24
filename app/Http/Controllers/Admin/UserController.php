<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class UserController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $users = User::orderBy('id','=','DESC')->get();

        return view('admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'string', 'max:15', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'level' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $attributes = ([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        User::create($attributes);

        return redirect()->back()->with('success', 'Delete data successfully !');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.useredit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => ['required', 'string', 'max:15', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'level' => ['required'],
        ]);

        $attributes = ([
            'username' => $request->username,
            'email' => $request->email,
            'level' => $request->level,
        ]);

        if ($request->password) {
            $attributes = array_add($attributes, 'password', Hash::make($request->password));
        }

        $user->update($attributes);

        return redirect('/users')->with('success', 'Data Update Successfully');

    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'Delete data successfully !');
    }
}

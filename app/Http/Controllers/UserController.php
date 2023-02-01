<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::select('id', 'email', 'name')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'unique:users,email'],
            'name' => ['required'],
            'password' => ['required']
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        $data['name'] = $request->name;
        $data['password'] = bcrypt($request->password);
        $data['email'] = $request->email;
        User::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil menyimpan data'
        ]);
    }

    public function update(Request $request, $id) {
        $user = User::select('id', 'email')->get();
        if($request->has('email')) {
            foreach($user as $u) {
                if($u->email == $request->email) {
                    if($u->id != $id) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Email sudah digunakan'
                        ], 422);
                    }
                }
            }
        }

        $data = [];
        if($request->has('email')) $data['email'] = $request->email;
        if($request->has('password')) $data['password'] = $request->password;
        if($request->has('name')) $data['name'] = $request->name;

        User::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil update data'
        ]);
    }
}

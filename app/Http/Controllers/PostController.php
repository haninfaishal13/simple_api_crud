<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->has('email')) {
            return response()->json([
                'status' => false,
                'message' => ['Email wajib diisi']
            ], 422);
        }
        $data = User::with('post')->where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapat data',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id_target' => ['required', 'exists:users,id'],
            'content' => ['required'],
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        Post::create($request->only('user_id_target', 'content'));
        return response()->json([
            'status' => true,
            'message' => 'Berhasil simpan post',
        ]);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if($post) {
            $post->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil hapus data'
        ]);
    }


}

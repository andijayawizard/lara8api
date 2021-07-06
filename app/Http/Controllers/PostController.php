<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'list data post',
            'data' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
            return response()->json($validator->errors(), 200, $headers);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'category' => $request->category
        ]);

        if ($post) {
            $data = array('success' => true, 'message' => 'post created', 'data' => $post);
            $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
            return response()->json($data, 200, $headers);
        }

        $data = array('success' => false, 'message' => 'post failed to save');
        $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
        return response()->json($data, 200, $headers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $data = array('success' => true, 'message' => 'detail data post', 'data' => $post);
        $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
        return response()->json($data, 200, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $post = Post::find($id);
        // $post->update($request->all());
        // return new PostResource($post);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
            return response()->json($validator->errors(), 200, $headers);
        }

        $post = Post::find($id);

        if ($post) {
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'author' => $request->author,
                'category' => $request->category
            ]);

            $data = array('success' => true, 'message' => 'updated success', 'data' => $post);
            $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
            return response()->json($data, 200, $headers);
        }

        $data = array('success' => false, 'message' => 'post not found');
        $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
        return response()->json($data, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post) {
            $post->delete();
            $data = array('success' => true, 'message' => 'deleted success');
            $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
            return response()->json($data, 200, $headers);
        }

        $data = array('success' => false, 'message' => 'deleted failed');
        $headers = array('kepala' => 'kepalanya', 'isi' => 'isinya');
        return response()->json($data, 200, $headers);
    }
}
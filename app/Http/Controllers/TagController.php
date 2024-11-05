<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::getTags(Auth::user()->school_id);
        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        return view('tag.create');
    }    

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();    

        $tag = new Tag();
        $tag->school_id = auth()->user()->school_id;
        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('tag.index')->with([
            'result' => 'success',
            'msg'    => __('messages.created_success')
        ]);
    }    

    public function edit(Request $request)
    {
        $tag = Tag::getTagById($request->id, Auth::user()->school_id);

        return view('tag.edit', compact('tag'));
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ])->validate();

        $tag = Tag::getTagById($request->id, Auth::user()->school_id);
        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('tag.index')->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function delete(Request $request)
    {
        $tag = Tag::getTagById($request->id, Auth::user()->school_id);
        $tag->delete();

        return redirect()->route('tag.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LabelFolder;
use App\Label;
use App\Http\Requests\LabelFolderRequest;

class LabelFolderController extends Controller
{
    // 認証を適用
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ユーザーに紐づいたフォルダをget
    public function index()
    {
        $folders = Auth::user()->label_folders()->get();
        return $folders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ユーザーに紐づけてフォルダを作成
    public function store(LabelFolderRequest $request)
    {
        $form = $request->all();
        $folder = Auth::user()->label_folders()->create($form);
        return $folder;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // フォルダ更新
    public function update(LabelFolderRequest $request, LabelFolder $label_folder)
    {
        $form = $request->all();
        $label_folder->fill($form)->save();
        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // フォルダ削除
    public function destroy(LabelFolder $label_folder)
    {
        $label_folder->delete();
        return response('', 200);
    }
}

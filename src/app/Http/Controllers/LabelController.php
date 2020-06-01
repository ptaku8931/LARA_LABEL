<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Label;
use App\LabelFolder;


class LabelController extends Controller
{
    // 認証を適用
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ラベル新規作成
    public function store(Request $request)
    {
        $form = $request->all();
        $label = new Label;
        $label->fill($form)->save();
        return $label;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // フォルダーに紐づいたラベルがnullでなければget
    public function show($id)
    {
        $folder = LabelFolder::find($id);
        if($folder->labels() !== null) {
            $labels = $folder->labels()->get();
            return $labels;
            return response('', 200);
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ラベル更新
    public function update(Request $request, Label $label)
    {
        $form = $request->all();
        $label->fill($form)->save();
        return $label;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ラベル削除
    public function destroy(Label $label)
    {
        $label->delete();
        return response('', 200);
    }
    // ドラッグアンドドロップ
    public function dragdrop(Request $request)
    {
        // ドラッグされたラベルに紐づいたフォルダをfind
        $label = $request[0];
        $id = $label['label_folder_id'];
        $folder = LabelFolder::find($id);
        // そのフォルダのラベルを全てget
        $labels = $folder->labels()->get();
        $i = 0;
        // foreachで回して、新しい並び順に更新
        foreach($labels as $label) {
            $label->fill($request[$i])->save();
            $i++;
        }
        return response ('', 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LabelFolder;
use App\Http\Requests\UserRequest;



class UserController extends Controller
{
    // ソフトデリート
    public function softdelete() {
        // ユーザーに紐づくフォルダーをget
        $folders = Auth::user()->label_folders()->get();
        // フォルダーに紐づいたラベルを削除した後、フォルダー削除
        \DB::transaction (function() use($folders) {
            foreach ($folders as $folder) {
                $folder->labels()->delete();
                $folder->delete();
            }
        });
        // フォルダー及びラベルを全て削除したらユーザーdelete
        Auth::user()->delete();
        return response('', 200);
    }
}

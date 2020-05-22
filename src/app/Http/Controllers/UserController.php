<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LabelFolder;


class UserController extends Controller
{
    public function softdelete() {
        $folders = Auth::user()->label_folders()->get();
        \DB::transaction (function() use($folders) {
            foreach ($folders as $folder) {
                $folder->labels()->delete();
                $folder->delete();
            }
        });
        Auth::user()->delete();
        return response('', 200);
    }
}

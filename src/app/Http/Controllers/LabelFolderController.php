<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LabelFolder;
use App\Label;
use App\Http\Requests\LabelFolderRequest;

class LabelFolderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Auth::user()->label_folders()->get();
        return $folders;
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
    public function store(LabelFolderRequest $request)
    {
        $form = $request->all();
        $folder = Auth::user()->label_folders()->create($form);
        return $folder;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function destroy(LabelFolder $label_folder)
    {
        $label_folder->delete();
        return response('', 200);
    }

    public function drugdrop(Request $request) 
    {

        $folders = Auth::user()->label_folders()->get();
        $i = 0;

        foreach ($folders as $folder) {
            $new_folder = $request[$i];
            $folder->fill($new_folder)->save();
            $i++;
        }

        return response('', 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders['folder1']  = Storage::allFiles('folder1');
        $folders['folder2']  = Storage::allFiles('folder2');
        return view('welcome')->with(['folders' => $folders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $file->store('folder1','s3');

        return redirect()->route('storage.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        Storage::move($request->path,'folder2/'.str_replace('folder1','',$request->path));
        return redirect()->route('storage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Storage::delete($request->path);
        return redirect()->route('storage.index');
    }

    public function getMetadata(Request $request)
    {
        return Storage::getMetadata($request->path);
    }
}

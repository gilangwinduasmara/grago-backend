<?php

namespace App\Http\Controllers;

use App\Models\Fileable;
use Illuminate\Http\Request;

class FileableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $files = $request->files;
        $fileables = [];
        foreach ($files as $key=>$file) {
            $path = $request->file($key)->store('public');
            $fileables[] = Fileable::create([
                'path' => $path,
                'name' => $key,
            ]);
        }

        return $fileables;
    }

    /**
     * Display the specified resource.
     */
    public function show(Fileable $fileable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fileable $fileable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fileable $fileable)
    {
        //
    }
}

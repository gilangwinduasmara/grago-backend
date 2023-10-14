<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Thread $thread)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:up,down,retract'],
        ]);

        $vote = auth()->user()->voteThread($thread, $validated['type']);

        return response()->json([
            'message' => 'Vote successful',
            'data' => $vote,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread, Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread, Vote $vote)
    {
        //
    }
}

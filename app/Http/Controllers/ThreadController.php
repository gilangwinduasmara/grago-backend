<?php

namespace App\Http\Controllers;

use App\Models\Fileable;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $threads = Thread::withCount('replies')
                            ->with(['user.avatar', 'attachment'])
                            ->whereNull('parent_id')
                            ->latest()
                            ->paginate();
        return JsonResource::collection($threads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => ['required'],
            'attachment' => 'nullable|exists:fileables,id',
        ]);

        $thread = $request->user()->startThread($request->only('content'));
        if(isset($validated['attachment'])){
            $fileable = Fileable::whereNull('fileable_type')->find($validated['attachment']);
            if (!$fileable) {
                return response()->json([
                    'message' => 'Invalid attachment',
                ], 400);
            }
            $fileable->saveForModel($thread);
        }

        return new JsonResource($thread);
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        $thread->loadMissing(['user.avatar', 'replies.user', 'replies.attachment']);
        $thread->loadCount('replies');
        return new JsonResource($thread);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        //
    }
}

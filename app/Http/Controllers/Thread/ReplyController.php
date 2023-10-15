<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Models\Fileable;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyController extends Controller
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
        $replies = $thread->replies()->with(['attachment', 'user.avatar'])->withCount(['upVotes', 'downVotes'])->paginate();
        return JsonResource::collection($replies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'content' => 'required',
            'attachment' => 'nullable|exists:fileables,id',
            'product_id' => 'nullable|string',
        ]);

        $thread = $request->user()->replyThread($thread, $request->only(['content', 'product_id']));

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
    public function show(Thread $thread, Thread $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread, Thread $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread, Thread $reply)
    {
        //
    }
}

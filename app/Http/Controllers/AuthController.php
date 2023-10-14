<?php

namespace App\Http\Controllers;

use App\Models\Fileable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('profile');
    }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('auth-token');
            $user = $request->user();
            $user->accessToken = $token->plainTextToken;
            $user->loadMissing('avatar');
            return response()->json($user);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'avatar' => 'required|exists:fileables,id'
        ]);

        // if fileable_type exists: file already claimed
        $fileable = Fileable::whereNull('fileable_type')->find($validated['avatar']);
        if (!$fileable) {
            return response()->json([
                'message' => 'Invalid avatar',
            ], 400);
        }

        $user = User::create([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'password' => bcrypt($validated['password']),
        ]);

        $fileable->saveForModel($user);

        $user->load('avatar');
        return new JsonResponse($user);

    }

    public function profile(){
        $user = auth()->user();
        $user->load('avatar');
        return new JsonResponse($user);
    }
}

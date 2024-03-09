<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount(['departments'])->with('departments')->orderBy('created_at', 'desc')->paginate(8);
        return Inertia::render('User/Index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated() + ['password' => Hash::make('password')]);
        return back()->with(compact('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['departments'])->loadCount(['departments']);
        $departments = Department::orderBy('name', 'asc')->get()->except($user->departments()->pluck('id')->toArray());
        return Inertia::render('User/Show', compact('user','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return back()->with(compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->departments()->count()){
            return back()->withErrors(['user' => 'User cannot be deleted because it is assigned to departments']);
        }
        $user->delete();
        return redirect()->route('user.index');
    }
}

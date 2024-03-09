<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query('query');
        $departments = Department::withCount(['childDepartments', 'users'])->when($query,fn($sql,$query) => $sql->whereLike('name',$query))->with('parentDepartment')->orderBy('created_at','desc')->paginate(8);
        return Inertia::render('Department/Index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function linkWithDepartment(Department $department, Department $parentDepartment)
    {
        $department->parent_department_id = $parentDepartment->id;
        $department->save();
        return back()->with(compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function linkWithUser(Department $department, User $user)
    {
        $department->users()->attach($user->id);
        return back()->with(compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function unlinkWithUser(Department $department, User $user)
    {
        $department->users()->detach($user->id);
        return back()->with(compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->validated());
        return back()->with(compact('department'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load(['users', 'childDepartments', 'parentDepartment'])->loadCount(['childDepartments', 'users']);
        $departments = Department::orderBy('name','asc')->get()->except([$department->id]);
        $users = User::all()->except($department->users->pluck('id')->toArray());
        return Inertia::render('Department/Show', compact('department', 'departments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return back()->with(compact('department'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department.index');
    }
}

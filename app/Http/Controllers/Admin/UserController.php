<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();
        if(request()->has('role') && request()->role != ''){
            $users = $users->role(request()->role);
        }
        $users = $users->paginate();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'ref_code' => 'nullable',
            'extra_discount' => 'nullable|numeric',
            'shipment_price' => 'nullable|numeric|min:0',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->ref_code = $request->ref_code;
        $user->extra_discount = $request->extra_discount ?? 0;
        $user->shipment_price = $request->shipment_price ?? 5;
        $user->password = bcrypt($request->password);
        $user->save();
        
        // Assign role to user
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|unique:users,mobile,' . $id,
            'ref_code' => 'nullable',
            'extra_discount' => 'nullable|numeric',
            'shipment_price' => 'nullable|numeric|min:0',
            'role' => 'required|exists:roles,name',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->ref_code = $request->ref_code;
        $user->extra_discount = $request->extra_discount ?? 0;
        $user->shipment_price = $request->shipment_price ?? 5;
        $user->save();
        
        // Update user role
        $user->syncRoles([$request->role]);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account');
        }
        
        // Delete the user
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;;
use Inertia\Inertia;
use Illuminate\Http\Request;
class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->withCount('chirps')->get();
        return Inertia::render('Admin/UserManage', [
            'users' => $users,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usermanager)
    {
        $request->validate([
            'status' => 'in:active,banned',
            'role' => 'in:user,moderator,admin',
        ]);
        
        // Update status di tabel users
        $usermanager->update([
            'status' => $request->status ?? $usermanager->status,
        ]);
        // Update role menggunakan Spatie
        if ($request->role) {
            $usermanager->syncRoles($request->role);
        }
        return redirect()->back()->with(['success' => 'User updated successfully.']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usermanager)
    {
        //
        $usermanager->delete();
        return redirect()->back()->with(['success'=> 'User deleted successfully.']);
    }
}

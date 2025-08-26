<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        $roles = Role::pluck('name', 'id');
        return view('admin.users.index', compact('users','roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name');
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'     => ['required','string','max:100'],
            'email'    => ['required','email','max:150','unique:users,email'],
            'password' => ['required','string','min:6'],
            'roles'    => ['nullable','array'],
            'roles.*'  => ['string','exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('users.index')->with('ok','User dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name','name');
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $r, User $user)
    {
        $data = $r->validate([
            'name'  => ['required','string','max:100'],
            'email' => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:6'],
            'roles' => ['nullable','array'],
            'roles.*' => ['string','exists:roles,name'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return back()->with('ok','User diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error','Tidak bisa menghapus diri sendiri.');
        }
        $user->delete();
        return back()->with('ok','User dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserForm;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_VIEW_USER)) {
            return redirect('/home')->with('message-error', 'Sorry, access restricted');
        }

        return view('user.index', [
            'user' => User::all(),
            'tipe' => User::getAllTypes(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_CREATE_USER)) {
            return redirect('/user')->with('message-error', 'Sorry, access restricted');
        }

        return view('user.create', ['types' => User::getAllTypes()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserForm $request)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_CREATE_USER)) {
            return redirect('/user')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'password' => Hash::make($validated['password']),
        ];

        $user = User::create($data);

        $permissions = array_map(function () { return true; }, Role::getUserPermissionMapping());
        if ($validated['type'] == User::TYPE_ADMIN) {
            $permissions = array_map(function () { return true; }, Role::getAdminPermissionMapping());
        }

        Role::create([
            'user_id' => $user->id,
            'permissions' => json_encode($permissions),
        ]);

        return redirect('/user')->with('message-success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_USER)) {
            return redirect('/user')->with('message-error', 'Sorry, access restricted');
        }

        return view('user.edit', ['user' => $user, 'types' => User::getAllTypes()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, User $user)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_EDIT_USER)) {
            return redirect('/user')->with('message-error', 'Sorry, access restricted');
        }

        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->type = $validated['type'];

        if (!is_null($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $permissions = array_map(function () { return true; }, Role::getUserPermissionMapping());
        if ($validated['type'] == User::TYPE_ADMIN) {
            $permissions = array_map(function () { return true; }, Role::getAdminPermissionMapping());
        }

        $role = Role::updateOrInsert(
             ['user_id' => $user->id],
             ['permissions' => json_encode($permissions)],
        );

        return redirect('/user')->with('message-success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // if not allow redirect with message
        if (!Gate::allows(Role::PERMISSION_DELETE_USER)) {
            return redirect('/user')->with('message-error', 'Sorry, access restricted');
        }

        $role = Role::where('user_id', $user->id);
        $role->delete();

        $user->delete();

        return redirect('/user')->with('message-success', 'User deleted successfully');
    }
}

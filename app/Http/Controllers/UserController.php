<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->ValidateForm($request->all());
        try {
            DB::beginTransaction();
            $password = Str::random(8);
            $data['password'] = Hash::make($password);
            $user = User::create($data);
            $roles = Role::whereIn('id', $data['roles'])->get();
            $user->assignRole($roles);
            Mail::to($user->email)->queue(new UserCreated($user, $password));
            DB::commit();
            return response()->json(null, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    protected function ValidateForm($data, $id = null)
    {
        return Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'gender' => 'required',
            'roles' => 'required|array',
            'roles.*' => 'required|numeric|exists:roles,id'
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->ValidateForm($request->all(), $user->id);
        try {
            DB::beginTransaction();
            $user->update(Arr::except($data, 'roles'));
            $roles = Role::whereIn('id', $data['roles'])->get();
            $user->syncRoles($roles);
            DB::commit();
            return response()->json(UserResource::make($user), 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

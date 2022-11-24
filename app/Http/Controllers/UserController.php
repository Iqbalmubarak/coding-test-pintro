<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Sentinel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(8);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $role = Role::pluck('name', 'id');
            return view('user.create', compact('role'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|same:password_confirmation',
        ]);
        try {
            $credentials = [
                'name'    => $request->name,
                'username'    => $request->username,
                'password'    => bcrypt($request->password),
            ];
            // /dd($credentials);
            $user = Sentinel::registerAndActivate($credentials);
            $role = Sentinel::findRoleById($request->role);
            $role->users()->attach($user);

            return redirect()->route('user.index')->with('success', 'Data has been saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = User::find($id);
            return view('user.show', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = User::find($id);
            $role = Role::pluck('name', 'id');
            return view('user.edit', compact('data', 'role'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            if($request->password){
                $request->validate([
                    'password' => 'required|string|min:8|same:password_confirmation',
                ]);
                $request['password'] = bcrypt($request->password);
                $data = $request->except(['password_confirmation']);
            }else{
                $data = $request->except(['password','password_confirmation']);
            }
            $update = User::find($id);
            $update->roles()->sync($request->role);
            $update->update($data);
            return redirect()->back()->with('success', 'Data has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}

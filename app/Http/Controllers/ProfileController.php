<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class ProfileController extends Controller
{
    public function index()
    {
        $data = Sentinel::getUser();
        return view('profile.index',compact('data'));
    }

    public function editProfile()
    {
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|max:20|unique:users,username,'.Sentinel::getUser()->id
        ]);

        try {

          $update = Sentinel::getUser();
          $data = $request->all();
          $update->update($data);
          return redirect()->back()->with('success', 'Data has been updated successfully!');
        } catch (\Exception $e) {
          return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        try {
          $request->validate([
              'baru_password'          => 'required|string|min:8',
              'confirm_password'      => 'required|string|min:8|same:baru_password',
          ]);

          $data = Sentinel::getUser();
          $data->password = bcrypt($request->baru_password);
          $data->update();
          return redirect('profile')->with('success', 'Data has been updated successfully!');
        } catch (\Exception $e) {
          return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use DB;
use Hash;
use Auth;
use Image;
use File;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'image' => 'sometimes|image|max:200'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $input['image'] = $filename;
        }

        $user = User::create($input);
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'image' => 'sometimes|image|max:200'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);
        // image upload
        if(!$user->image == NULL || !$user->image == ''){
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = $user->image;
                $location   = public_path('/images/users/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $input['image'] = $filename;
            }
        } else {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('images/users/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $input['image'] = $filename;
            }
        }

        $user->update($input);
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $image_path = public_path('images/users/'. $user->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $user->delete();
        
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function getProfile()
    {
        $user = User::find(Auth::user()->id);
        
        return view('users.profile')->withUser($user);
    }
}

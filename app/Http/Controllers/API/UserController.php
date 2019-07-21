<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
// use Illuminate\Auth\Access\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Gate::allows('isAdmin') || \Gate::allows('isSupport')){
            return User::latest()->paginate(10);   
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users',
            'username' => 'required|string|max:25|unique:users',
            'mac_address' => 'required|string|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'ip_address' => 'required|ip|string',
            'active_subscription' => 'required|string',
            'user_group' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $hash_password = Hash::make($request->password);
        $request->merge(['password' => $hash_password]);

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user = User::findOrFail($id);
        // $current_user = auth('api')->user();

        // if($current_user->user_group ==)

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'username' => 'required|string|max:25|unique:users,username,' . $user->id,
            'mac_address' => 'required|string|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'ip_address' => 'required|ip|string',
            'active_subscription' => 'required|string',
            'user_group' => 'required|string',
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($request->has('password')){
            $password_hash = Hash::make($request->password);
            $request->merge([
                'password' => $password_hash
            ]);
        }

        $user->update($request->all());
        return ['message' => 'Update user'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        $user->delete();
        return ['mesage' => 'User deleted'];
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request, [
            'mac_address' => 'required|string|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'ip_address' => 'required|ip|string',
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        $input = $request->only(['mac_address', 'password', 'ip_address']);


        if ($request->has('password')){
            $password_hash = Hash::make($request->password);
            $request->merge([
                'password' => $password_hash
            ]);
        }

        if(time() - strtotime($user->updated_at) < 10800){
            return response()->json(['success'=> FALSE, 'message' => 'You have to wait 3hrs before updating your profile. Please try again later.']);
        }else{
            $user->update($request->all());
            return ['success' => TRUE,'message' => 'Profile updated'];
        }

    }
}

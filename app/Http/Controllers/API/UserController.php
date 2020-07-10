<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:8'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id', 'DESC')->get();

        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, $this->rules);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'], ['rounds' => 12]),
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'active' => $request['active']
        ]);

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($user) {

        $userDate = User::findOrfail($user);

        return response()->json($userDate, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'), ['rounds' => 12]),
            'type' => request('type'),
            'bio' => request('bio'),
            'photo' => request('photo'),
            'active' => $request['active']
        ]);

        return response()->json([ 'id' => $user->id ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get the user
        $user = User::findOrfail($id);

        // gelete user
        $user->delete();

        return response()->json($user, 200);
    }
}

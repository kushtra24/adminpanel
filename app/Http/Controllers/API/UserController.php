<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    // validation rules for user
    private $rules = [
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:8'
    ];

    // validation rules for user
    private $updateUserRules = [
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|',
    ];

    // validation rules for profile
    private $profileRules = [
        'name' => 'required|string|max:191',
//        'password' => 'string|min:8'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index() {

        // get users and order them by id discanding
        $user = User::orderBy('id', 'DESC')->get();

        // return json response with user
        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request) {

        // validate user
        $this->validate($request, $this->rules);

        // photo request
        $requestedPhoto = $request['photo'];
        // check if requested photo is not an empty string and does not contain storage in it
        if ( $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            $this->updatePhoto($request, $requestedPhoto, 'user');
        }

        // hash password request
        $request->merge(['password' => Hash::make($request['password'])]);
        // create user
        $user = User::create($request->all());

        // return json response with user
        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($user) {

        // find the user or fail
        $user = User::findOrfail($user);

        // return json response with user
        return response()->json($user, 200);
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

        // validate user
        $this->validate($request, $this->updateUserRules);

        // find user or fail
        $user = User::findOrfail($id);

        // get current uploaded photo from DB
        $currentPhoto = $user->photo;
        $requestedPhoto = $request['photo'];

        // check if requested photo is not the same as the photo on the db, is not an empty string and does not contain storage in it
        if ($requestedPhoto != $currentPhoto && $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            $this->updatePhoto($request, $requestedPhoto, 'user', $currentPhoto);
        }
        // check if password is empty
        if (!empty($request->password)) {
            // hash the password
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        // update user
        $user->update($request->all());

        // return json response with user id
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

        // return json response with user
        return response()->json($user, 200);
    }

    /**
     * return authenticated user
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile() {
        // return authenticated user
        return auth('api')->user();
    }

    /**
     * update the user profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(request $request) {

        // validate form
        $this->validate($request, $this->profileRules);

        // get authenticated user
        $authUser = auth('api')->user();
        // get current uploaded photo from DB
        $currentPhoto = $authUser->photo;
        // photo request
        $requestedPhoto = $request['photo'];
        // check if requested photo is not the same as the photo on the db, is not an empty string and does not contain storage in it
        if ($requestedPhoto != $currentPhoto && $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage')) {

            $this->updatePhoto($request, $requestedPhoto, 'user', $currentPhoto);
        }

        // check if password is empty
        if (!empty($request->password)) {
            // hash password
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        if (Str::contains($requestedPhoto, 'storage')) {
            // update user profile except the photo
            $authUser->update($request->except(['photo']));
        } else {
            // update user profile
            $authUser->update($request->all());
        }

        // return json response with updated profile
        return response()->json($authUser, 200);

    }
}

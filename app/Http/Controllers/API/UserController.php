<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:8'
    ];

    private $profileRules = [
        'name' => 'required|string|max:191',
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request) {

        $this->validate($request, $this->rules);

        Log::info(var_export('here'. $request->photo, true));
        $requestedPhoto = $request['photo'];

        // check if requested photo is not an empty string and does not contain storage in it
        if ( $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            Log::info(var_export('here2', true));
            $image_64 = $request->photo;  // your base64 encoded
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            Storage::disk('public')->put($imageName, base64_decode($image));
            $request->merge(['photo' => $imageName]);
        }

        $request->merge(['password' => Hash::make($request['password'])]);
        $user = User::create($request->all());

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
        $this->validate($request, $this->rules);

        $user = User::findOrfail($id);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'), ['rounds' => 12]),
            'type' => request('type'),
            'bio' => request('bio'),
            'photo' => request('photo'),
            'active' => request('active')
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

    /**
     * return authenticated user
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile() {
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
        $requestedPhoto = $request['photo'];

        // check if requested photo is not the same as the photo on the db, is not an empty string and does not contain storage in it
        if ($requestedPhoto != $currentPhoto && $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            Log::info(var_export('profile', true));
            $image_64 = $request->photo;  // your base64 encoded
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            // find substring fro replace here eg: data:image/png;base64,
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            Storage::disk('public')->put($imageName, base64_decode($image));
            $request->merge(['photo' => $imageName]);
        }

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $authUser->update($request->all());

        return response()->json($authUser, 200);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $user = User::find($jwt_payload["sub"]);
            if (!$user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        return $this->ok(["data" => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $user = User::find($jwt_payload["sub"]);
            if (!$user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $validation = Validator::make($request->all(), [
            "username" => "required|min:4",
            "password" => "required|min:6|max:8"
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors());
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->ok($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $user = User::find($jwt_payload["sub"]);
            if (!$user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $user = User::find($id);

        if ($user) return $this->ok($user);
        return $this->error("user not found");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $user = User::find($jwt_payload["sub"]);
            if (!$user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $validation = Validator::make($request->all(), [
            "username" => "required|min:4",
            "password" => "required|min:6|max:8"
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors());
        }

        $user = User::find($id);
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->ok($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $user = User::find($jwt_payload["sub"]);
            if (!$user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $user = User::find($id);

        if (!$user) return $this->error("no user found");

        $user->delete();
        return $this->ok(["success" => "Data Deleted Successfully"]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlayerController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $this->user = User::find($jwt_payload["sub"]);
            if (!$this->user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        return $this->ok(["data" => Player::all()]);
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

            $this->user = User::find($jwt_payload["sub"]);
            if (!$this->user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $validation = Validator::make($request->all(), [
            "posisi" => "required",
            "nama" => "required",
            "nomor_punggung" => "required",
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors());
        }

        $player = new Player();
        $player->posisi = $request->posisi;
        $player->nama = $request->nama;
        $player->nomor_punggung = $request->nomor_punggung;
        $player->created_by_id = $this->user->id;
        $player->modified_by_id = $this->user->id;
        $player->save();

        return $this->ok($player->only(["nama", "nomor_punggung", "posisi"]));
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

        $player = Player::find($id);

        if ($player) return $this->ok($player);
        return $this->error("player not found");
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

            $this->user = User::find($jwt_payload["sub"]);
            if (!$this->user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $validation = Validator::make($request->all(), [
            "posisi" => "required",
            "nama" => "required",
            "nomor_punggung" => "required",
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors());
        }

        $player = Player::find($id);
        $player->nama = $request->nama;
        $player->posisi = $request->posisi;
        $player->nomor_punggung = $request->nomor_punggung;
        $player->modified_by_id = $this->user->id;
        $player->save();

        return $this->ok($player);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $jwt_payload = JWTAuth::getPayload($request->token)->toArray();

            $this->user = User::find($jwt_payload["sub"]);
            if (!$this->user) return $this->error("no user found");
        } catch (TokenExpiredException $e) {
            return $this->error("Token expired");
        } catch (TokenInvalidException $e) {
            return $this->error("Token invalid");
        } catch (JWTException $e) {
            return $this->error("JWTException: " . $e->getMessage());
        }

        $player = Player::find($id);

        if (!$player) return $this->error("no player found");

        $player->delete();
        return $this->ok(["success" => "Data Deleted Successfully"]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiUserRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(
            User::with('tasks')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function register(ApiUserRegisterRequest $request)
    {
        $toStore=$request->validated();
        $toStore['is_admin']=0;
        $toStore['password']=Hash::make($toStore['password']);

        if (!($user=User::create($toStore)))  abort( 500, __('Create Error'));

        $token = $user->createToken('api')->plainTextToken;

        return response(
            ['data' => [
                'token' => $token,
                'user' => $user,
                'is_admin' => $user->is_admin
            ],
                'message' => __('Sikeres regisztráció')
            ],
            201);
    }



    public function login(LoginRequest $request)
    {

        if ($user = User::select(['id', 'email', 'name', 'password','is_admin'])
            ->where('email', request('email'))
            ->with('tasks')
            ->first()) {
        }


        abort_if(!$user || !Hash::check(request('password'), $user->getAuthPassword()), 401, __('Unauthorized.'));

        $token = $user->createToken('api')->plainTextToken;

        return response(
            ['data' => [
                'token' => $token,
                'user' => $user,
                'is_admin' => $user->is_admin
            ],
                'message' => __('Logged in successfully.')
            ],
            201);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

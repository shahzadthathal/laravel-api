<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Interfaces\IAuth;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Classes\ApiResponseClass;


class AuthController extends Controller
{

    private IAuth $authRepo;

    public function __construct(IAuth $iAuth)
    {
        $this->authRepo = $iAuth;
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="storeUser",
     *     tags={"Auth"},
     *     summary="Create a new user",
     *     description="Create a new user api",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        $details = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        DB::beginTransaction();
        try {
            $model = $this->authRepo->register($details);
            $token = $model->createToken('auth_token')->plainTextToken;
            $model->token = $token;
            DB::commit();
            return ApiResponseClass::sendResponse(new UserResource($model), 'User created successful', 201);
        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Auth"},
     *     summary="Login a user",
     *     description="Login a  user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User login successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function login(LoginUserRequest $request)
    {
        $credentials    =   $request->only('email', 'password');
        if (!Auth::attempt($credentials))
        {
            return ApiResponseClass::throw('','Invalid username/password.');
        }
        DB::beginTransaction();
        try {
            $model = $this->authRepo->findByEmail($request->email);
            $token  = $model->createToken('auth_token')->plainTextToken;
            $model->token = $token;
            DB::commit();
            return ApiResponseClass::sendResponse(new UserResource($model), 'User login successful', 201);
        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="logoutUser",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     description="Logout user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function logout()
    {
        DB::beginTransaction();
        try {
            Auth::user()->tokens()->delete();
            return ApiResponseClass::throw('','User logout successfull');
        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }
    
}

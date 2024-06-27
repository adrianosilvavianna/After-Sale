<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    /**
     * Post create User with Token Laravel Passport 
     * Using Request to validate FormData
     *
     * @param  Request  $request
     * @return void
     */
    public function register(RegisterUserRequest $request)
    {
        try{
            $validatedData = $request->validated();
    
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $userFormat = new UserResource($user);

            return response()->json([
                'user' => $userFormat,
            ]);
            
        }catch(Exception $e){
            return response()->json($e->getMessage(), 500);
        }
        
    }

    /**
     * Post Login User return token to Laravel Passport
     *
     * @param  Request  $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = $request->user();
        
            
            $token = $user->createToken('TokenGenarate');

            return response()->json([
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'user' => $user,
                'message' => 'User-Authorized'
            ]);
         
            
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Get User Authenticator
     *
     * @param  Request  $request
     * @return void
     */
    public function user()
    {
        return response()->json(auth()->user());
    }
}

<?php

namespace App\Models;

use Exception;
use Google_Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable;

    protected $collection = 'users';

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        "name",
        "avatarAddress",
        "phoneNumber",
        "address",
        "email",
        "password",
        "type",
        "rate",
        "birthday",
        "gender",
        "cv",
        "zaloUrl",
        "facebookUrl",
        "reviews"
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAllUserBlogs() {
        return $this->hasMany(Blog::class, 'userId');
    }

    public static function login(Request $request) {
        $input = $request->only('email', 'password');

        if (!$token = FacadesJWTAuth::attempt($input)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public static function register(Request $request) {
        $validator = User::validateUser($request);     
        if ($validator->fails()) {
            return response([$validator->getMessageBag()], Response::HTTP_BAD_REQUEST);   
        } else {
            $email = $request->input('email');
            $name = $request->input('name');
            $password = $request->input('password');
            $type = $request->input('type');
            $user = User::where('email', '=', $email)->first();    
            if ($user != null){
                return response(['message' => 'Email already exists'], Response::HTTP_CONFLICT);   
            }  
            else {
                User::createNewUser($name, $email, $password, $type, null);
                return response(['message' => 'Success'], Response::HTTP_OK); 
            }
        }
    }

    public static function loginWithGG(Request $request) { 
        $idToken = $request->input('id_token');
        $res = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token='.$idToken);
        
        $email = $res->json()['email'];

        $user = User::where('email', '=', $email)->first();
        if (!$user){
            return response([
                'message' => 'This email not registered',
            ], Response::HTTP_UNAUTHORIZED);
        } 

        if(!$token = FacadesJWTAuth::attempt(['email' => $email,'password' => env('SECRET_PASS_FOR_GGLOGIN')])) {
            return response([
                'message' => 'This email used by another user',
            ], Response::HTTP_UNAUTHORIZED);
        } 

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public static function validateUser(Request $request) {
        return Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'repassword' => ['required', 'same:password']
        ]);
    }

    public static function registerWithGG(Request $request, $type) {
        $idToken = $request->input('id_token');
        $res = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token='.$idToken);
        $email = $res->json()['email'];
        $name = $res->json()['name'];
        $image = $res->json()['picture'];
        $user = User::where('email', '=', $email)->first();
        if (!$user){
            User::createNewUser($name, $email, env('SECRET_PASS_FOR_GGLOGIN'), $type, $image);
        } else {
            return User::loginWithGG($request);
        }

        $token = FacadesJWTAuth::attempt(['email' => $email,'password' => env('SECRET_PASS_FOR_GGLOGIN')]);

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public static function createNewUser($name, $email, $password, $type, $avatarAddress) {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'type' => $type,
            'avatarAddress' => $avatarAddress
        ]);  
    }

}

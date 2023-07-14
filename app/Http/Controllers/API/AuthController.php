<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role_id' => ['required', 'numeric', Rule::in([2])],
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false, 'message'=>'Validation required', 'data'=>[], 'error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input["verification_code"] = $this->generateVerificationCode();
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $user = User::find($user->id);
        return new ResourcesUser($user);
    }
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user = User::find($user->id);
            //$u = new ResourcesUser($user);
            return new ResourcesUser($user);
        } else {
            return response()->json(['status'=>false, 'message' => 'Unauthorised', 'data'=>[]], 401);
        }
    }
    public function mobile_login(Request $request){
        $jsonResponse = ["status"=>false, "message"=>"", "data"=>[]];
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if (is_null($user->email_verified_at)){
                $jsonResponse["message"] = "Email verification required.";
                return response()->json($jsonResponse);
            }
            $jsonResponse['access_token'] =  $user->createToken('MyApp')->accessToken;
            $user = User::find($user->id);
            $jsonResponse["status"] = true;
            $jsonResponse["message"] = "Logged successfully.";
            $jsonResponse["data"] = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone,
                "image" => $user->image,
                "bio" => $user->bio,
            ];
            return response()->json($jsonResponse);
        } else {
            $jsonResponse["message"] = "Invalid email and password.";
            return response()->json($jsonResponse);
        }
    }
    public function mobile_register(Request $request)
    {
        $jsonResponse = ["status"=>false, "message"=>"", "data"=>[]];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'user_type' => ['required', 'numeric', Rule::in([0, 1])],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error_message){
                $jsonResponse["message"] = $error_message;
                return response()->json($jsonResponse);
            }
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input["verification_code"] = $this->generateVerificationCode();
        $input["is_handicapper"] = $input["user_type"];
        unset($input["user_type"]);
        $user = User::create($input);
        $user = User::find($user->id);
        $jsonResponse["status"] = true;
        $jsonResponse["message"] = "Congrats! you register successfully.";
        $jsonResponse["data"] = [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "phone" => $user->phone,
            "image" => $user->image,
            "bio" => $user->bio,
        ];
        return response()->json($jsonResponse);
    }

    public function resend_email_verification_code(Request $request){
        $jsonResponse = ["status"=>false, "message"=>"", "data"=>[]];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error_message){
                $jsonResponse["message"] = $error_message;
                return response()->json($jsonResponse);
            }
        }
        $user = User::where("email", $request->email)->first();
        if (!empty($user)){
            if (is_null($user->email_verified_at)){
                $user->verification_code = $this->generateVerificationCode();
                $user->update();
                $jsonResponse["status"] = true;
                $jsonResponse["message"] = "Verification code send successfully.";
            }else{
                $jsonResponse["message"] = "Email address already verified.";
            }
        }else{
            $jsonResponse["message"] = "Invalid email address.";
        }
        return response()->json($jsonResponse);
    }
    public function email_code_verified(Request $request){
        $jsonResponse = ["status"=>false, "message"=>"", "data"=>[]];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error_message){
                $jsonResponse["message"] = $error_message;
                return response()->json($jsonResponse);
            }
        }
        $user = User::where("email", $request->email)->where("verification_code", $request->verification_code)->first();
        if (empty($user)){
            $jsonResponse["message"] = 'Invalid verification code';
            return response()->json($jsonResponse);
        }
        if ($user->markEmailAsVerified())
            event(new Verified($user));

        $jsonResponse["status"] = true;
        $jsonResponse["message"] = "Email verified successfully.";
        return response()->json($jsonResponse);

    }
    public function generateVerificationCode():int
    {
        $randomNumber = random_int(100000, 999999);
        $exists = User::where("verification_code", $randomNumber)->whereNull("email_verified_at")->first();
        if (!empty($exists)){
            $this->generateVerificationCode();
        }
        return $randomNumber;
    }
}

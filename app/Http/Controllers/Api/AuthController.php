<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use App\Models\FcmToken;
use App\Models\User;
use Validator;
use Hash;
use Auth;


class AuthController extends Controller
{
    /* --- function for casting--- */
    function allString($object)
    {
        // Get the object's attributes
        $attributes = $object->getAttributes();

        // Iterate through the attributes and apply conversions
        foreach ($attributes as $key => &$value) {
            if (is_null($value)) {
                $value = "";
            } elseif (is_numeric($value) && !is_float($value)) {
                // Convert numeric values to integers (excluding floats)
                $value = (string) $value;
            }
            // Add more conditions for other types if needed
        }

        // Set the modified attributes back to the object
        $object->setRawAttributes($attributes);
        return $object;
    }

    // signup api
    public function signUp(Request $request)
    {
        $header = $request->header('Authorization');
        if(empty($header)){
            $message = "Authorization Token is required";
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $message
            ],422);
        }else{
            if($header == "Bearer JzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkMkJSEyXiopIiw"){
                $userdata = $request->all();

                $rules = [
                    'name'             => 'required|regex:/^[^\d]+$/|min:2|max:255',
                    'email'            => 'required|email|unique:users',
                    'phone_number'     => 'required|unique:users',
                    'password'         => 'required|min:6',
                    'confirm_password' => 'required|same:password',
                    'image'            => 'mimes:jpg,jpeg,png,gif|max:2048',
                    "device_type"      => "required|in:android,ios",
                    "device_id"        => "required",
                    "fcm_token"        => "required",
                ];

                $customValidation = [
                    'phone_number.required' => 'Phone number is required',
                    'confirm_password'      => 'Confirm password is required',
                ];

                $validator = Validator::make($userdata, $rules, $customValidation);
                if($validator->fails()){
                    return response()->json([
                        'status' => false,
                        'message'     => $validator->errors()->first(),
                    ],422);
                }

                $user = new User();
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/userImage/');
                    $image->move($path, $name);
                    $user->image = $name;
                }
                $user->name  = $userdata['name'];
                $user->email = $userdata['email'];
                $user->phone_number = $userdata['phone_number'];
                $user->password = Hash::make($userdata['password']);
                $user->status = "Deactive";
                $user->save();

                // generate auth token 
                $token = $user->createToken('newspaper')->plainTextToken;
                // return $token;
                $user['token'] = $token;
                $user['image'] = asset('uploads/userImage/'.$user['image']);

                $fcm_token = new FcmToken;
                $fcm_token->user_id = $user->id;
                $fcm_token->device_type = $userdata['device_type'];
                $fcm_token->device_id = $userdata['device_id'];
                $fcm_token->fcm_token = $userdata['fcm_token'];
                $fcm_token->save();

                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'SignUp Successfully!.',
                    'data'    => $user,
                ],200); 
            }else{
                $message = "Authorization Token is Incorrect";
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => $message,
                ],422);
            }
        }
    }

    // user login api
    Public function UserLogin(Request $request)
    {
        $header = $request->header("Authorization");
        if(empty($header)){
            $message = 'Authorization Token is required';
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $message
            ],422);
        }else{
            if($header == "Bearer JzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkMkJSEyXiopIiw"){
                $userData = $request->all();

                $rules = [
                    'email'    => 'required|email',
                    'password' => 'required|min:6',
                ];

                $validator = Validator::make($userData, $rules);
                if($validator->fails()){
                    return response()->json([
                        'status'  => false,
                        'message' => $validator->errors()->first(),
                    ],422);
                }

                if(Auth::attempt(['email'=> $userData['email'], 'password'=>$userData['password']])){

                    // user exists
                    $user = Auth::user();
                    if($user->status == 'Active'){

                        // get fcm_token and device type
                        $user['fcm_token']   = "";
                        $user['device_id']   = "";
                        $user['device_type'] = "";
                        $get_data = FcmToken::where('user_id', $user->id)->first();
                        if(!empty($get_data)){
                            $user['fcm_token']   = $get_data->fcm_token;
                            $user['device_id']   = $get_data->device_id;
                            $user['device_type'] = $get_data->device_type;
                        };

                        // create token
                        $user['token'] = "";
                        $token = $user->createToken('newspaper')->plainTextToken;
                        $user['token'] = $token;
                        $user['image'] = asset('public/uploads/userImage/'.$user['image']);


                        /* --- typecasting the data --- */
                        $user = $this->allString($user);
                        return response()->json([
                            'status'      => true,
                            'status_code' => 200,
                            'message'     => 'Login Successfull!',
                            'data'        => $user,
                        ],200);
                    }else{
                        return response()->json([
                            'status'      => false,
                            'status_code' => 422,
                            'message'     => 'Your Account is not Active, please contact Admin!.',
                        ],200);
                    }
                }else{
                    return response()->json([
                        'status'      => false,
                        'status_code' => 422,
                        'message'     => 'Invalid Credentials.',
                    ],422);
                }
            }else{
                $message = 'Authorization Token is Incorrect';
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => $message,
                ],422);
            }
        }
    }

    /* --- user detail api --- */
    public function UserDetail(Request $request)
    {
        try{
            $user = auth()->user();
            $user['image'] = asset('public/uploads/userImage/'.$user['image']);

            /* -- TypeCast the data */
            $user = $this->allString($user);

            $message = "User Detail Retrieve Successfully!";
            return response()->json([
                'status'      => true,
                'status_code' => 200,
                'message'     => $message,
                'data'        => $user,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- user profile update --- */
    public function UserProfileUpdate(Request $request)
    {
        try{
            $rules = [   
                "name"         => "string|regex:/^[^\d]+$/|min:2|max:255",
                "image"        => "mimes:jpeg,jpg,png,gif",
                "phone_number" => "numeric|min:11",
            ];

            $customValidation = [
                'phone_number.numeric' => 'Phone number must be numeric',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            // return $user;
            if(isset($request->image)){
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/userImage/');
                    $image->move($path, $name);
                    $user->image = $name;
                }
            }

            // update the validated data
            $user->update($validator->validated());
            
            $user['image'] = asset('uploads/userImage/'.$user['image']);

            /* --- TypeCast the data --- */
            $user = $this->allString($user);
            $message = "Profile Updated Successfully!";
            return response()->json([
                'status'      => true,
                'status_code' => 200,
                'message'     => $message,
                'data'        => $user,
            ],200);     
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- logout api --- */
    public function UserLogout(Request $request)
    {
       try{
            $user = Auth::user();
            $user->tokens()->delete();
            return response()->json(['status'=> true,'status_code' => 200,'message'=>'User Logout Successfully!'],200);
        }catch(\Exception $e){
            return response()->json(['status'=> false,'status_code' => 422,'error' => $e->getMessage()],422);
        }
    }
}

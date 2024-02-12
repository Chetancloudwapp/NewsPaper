<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Admin;
use Validator;
use Auth;
use Hash;

class AdminController extends Controller
{
    /* --- dashboard --- */
    public function dashboard()
    {
        return view('admin::dashboard');
    }

    /* --- login --- */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            
            $rules = [
                'email'    => 'required|email',
                'password' => 'required|max:30',
            ];

            $customValidation = [
                'email.required'    => 'Email is required',
                'password.required' => 'Password is required', 
            ];

            $this->Validate($request, $rules, $customValidation);
            if(Auth::guard('admin')->attempt(['email'=> $data['email'], 'password'=> $data['password']])){

                // Remember admin email and password with cookies
                if(isset($data['remember']) && !empty($data['remember'])){
                    setcookie('email', $data['email'], time()+86400);
                    setcookie('password', $data['password'], time() + 86400);
                }else{
                    setcookie('email', '');
                    setcookie('password','');
                }
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Invalid email or password');
            }
        }
        return view('admin::login');
    }

    /* --- change password --- */
    public function ChangePassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                if($data['new_pwd'] == $data['current_pwd']){
                    return redirect()->back()->with('error_message', 'Your new password must be different from your previously used password.');
                }else if($data['new_pwd'] == $data['confirm_pwd']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>Hash::make($data['new_pwd'])]);
                    return redirect()->back()->with('success_message', 'Password Updated Successfully!.');
                }
                else{
                    return redirect()->back()->with('error_message', 'New password and confirm password does not match');
                }
            }else{
                return redirect()->back()->with('error_message', 'Your Old pasword is Incorrect!');
            }
        }
        return view('admin::change_password');
    }

    /* --- check current password --- */
    public function CheckCurrentPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($user); die;
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    /* --- logout user --- */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}

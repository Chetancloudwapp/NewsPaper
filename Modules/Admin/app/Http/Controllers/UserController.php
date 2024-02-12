<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Countries;
use Validator;

class UserController extends Controller
{
    /* --- user listing --- */
    public function index()
    {
        $common = [];
        $common['title'] = "Users List";
        $get_users = User::select('id','name','email','country','status')->get();
        return view('admin::users.index')->with(compact('common', 'get_users'));
    }

    /* --- edit user --- */
    public function editUser(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'User';
        $common['heading_title'] = 'Edit User';
        $common['button'] = 'Update';
        $id = decrypt($id);
        $users = User::findOrFail($id);
        $message = 'User Updated Successfully!';
        // return $users;
        $countries = Countries::select('id','name')->get();
        
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "name"  => "required|regex:/^[^\d]+$/|min:2|max:255",
            ];

            $customValidation = [
                "name.required" => "Name is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $users->name    = $data['name'];
            $users->email   = $data['email'];
            $users->country = $data['countries'];
            $users->status  = $data['status'];
            // echo "<pre>"; print_r($categories); die;
            $users->save();
            return redirect('admin/users')->with('success_message', $message);
        }
        return view('admin::users.edituser', compact('common', 'users','countries'));
    }

    /* --- delete users --- */
    public function destroy($id)
    {
        $users = User::findOrFail($id)->delete();
        return redirect()->back()->with('success_message' , 'User Deleted Successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    
}

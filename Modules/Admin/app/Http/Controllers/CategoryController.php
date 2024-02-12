<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Categories;
use Validator;

class CategoryController extends Controller
{
    /* --- Display a listing  ---*/
    public function index()
    {
        $common = [];
        $common['title'] = 'Categories';
        $get_categories = Categories::get();
        return view('admin::categories.index')->with(compact('common','get_categories'));
    }

    /* --- add Category --- */
    public function addCategory(Request $request)
    {
        $common = [];
        $common['title']         = "Categories";
        $common['heading_title'] = "Add Categories";
        $common['button']        = "Submit";
        $message = "Categories Added Successfully!";
         
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "title"         => "required|regex:/^[^\d]+$/|min:2|max:255",
                "image"        => "required|mimes:jpeg,jpg,png,gif",
            ];

            $customValidation = [
                "title.required" => "Title is required",
                "image.required" => "Image is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $categories = new Categories();
            if($request->has('image')){
                $image = $request->file('image');
                $name  = time(). "." .$image->getClientOriginalExtension();
                $path  = public_path('uploads/categories/');
                $image->move($path, $name);
                $categories->image = $name;
            }
            $categories->title    = $data['title'];
            $categories->status  = $data['status'];
            // echo "<pre>"; print_r($categories); die;
            $categories->save();
            return redirect('admin/category')->with('success_message', $message);
        }
        return view('admin::categories.addCategories')->with(compact('common'));
    }

    /* --- edit Categories --- */
    public function editCategory(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Categories";
        $common['heading_title'] = "Edit Categories";
        $common['button']        = "Update";
        $id = decrypt($id);
        $categories = Categories::findOrFail($id);
        $message = "Categories Updated Successfully!";
         
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "title"        => "required|regex:/^[^\d]+$/|min:2|max:255",
                "image"        => "mimes:jpeg,jpg,png,gif",
            ];

            $customValidation = [
                "title.required" => "Title is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            if(isset($request->image)){
                if($request->has('image')){
                    $image = $request->file('image');
                    $name  = time(). "." .$image->getClientOriginalExtension();
                    $path  = public_path('uploads/categories/');
                    $image->move($path, $name);
                    $categories->image = $name;
                }
            }
            $categories->title   = $data['title'];
            $categories->status  = $data['status'];
            // echo "<pre>"; print_r($categories); die;
            $categories->save();
            return redirect('admin/category')->with('success_message', $message);
        }
       return view('admin::categories.editCategories')->with(compact('common', 'categories'));
    }

    /* --- delete Categories --- */
    public function destroy($id)
    {
        $categories = Categories::findOrFail($id)->delete();
        return redirect()->back()->with('success_message' , 'Categories Deleted Successfully!');
    }
}

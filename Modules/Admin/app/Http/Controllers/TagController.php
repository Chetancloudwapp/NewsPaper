<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /* --- Display a listing  ---*/
    public function index()
    {
        $common = [];
        $common['title'] = 'Tags';
        $tags = Tag::get();
        return view('admin::tags.index')->with(compact('common','tags'));
    }
 
    /* --- add Category --- */
    public function addTags(Request $request)
    {
        $common = [];
        $common['title']         = "Tags";
        $common['heading_title'] = "Add Tags";
        $common['button']        = "Submit";
        $message = "Tag Added Successfully!";
        
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "name"     => "required|regex:/^[^\d]+$/|min:2|max:255",
            ];

            $customValidation = [
                "name.required"  => "Name is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $tags = new Tag();
            $tags->name    = $data['name'];
            $tags->status  = $data['status'];
            // echo "<pre>"; print_r($tags); die;
            $tags->save();
            return redirect('admin/tags')->with('success_message', $message);
        }
        return view('admin::tags.addTags')->with(compact('common'));
    }
 
    /* --- edit tags --- */
    public function editTags(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Tags";
        $common['heading_title'] = "Edit Tags";
        $common['button']        = "Update";
        $id = decrypt($id);
        $tags = Tag::findOrFail($id);
        $message = "Tag Updated Successfully!";
        
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
            
            $tags->name    = $data['name'];
            $tags->status  = $data['status'];
            // echo "<pre>"; print_r($categories); die;
            $tags->save();
            return redirect('admin/tags')->with('success_message', $message);
        }
    return view('admin::tags.editTags')->with(compact('common', 'tags'));
    }
 
    /* --- delete Categories --- */
    public function destroy($id)
    {
        $tags = Tag::findOrFail($id)->delete();
        return redirect()->back()->with('success_message' , 'Tag Deleted Successfully!');
    }
}

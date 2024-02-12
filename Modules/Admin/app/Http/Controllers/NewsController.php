<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\News;
use Modules\Admin\app\Models\Categories;
use Modules\Admin\app\Models\NewsImage;
use Modules\Admin\app\Models\Tag;
use Validator;

class NewsController extends Controller
{
    /* --- news list --- */
    public function index()
    {
        $common = [];
        $common['title'] = 'News List';
        $get_news = News::latest()->get();
        return view('admin::news.index')->with(compact('common','get_news'));
    }

    /* --- add news --- */
    public function addNews(Request $request)
    {
        $common = [];
        $common['title'] = 'News';
        $common['heading_title'] = 'Add news';
        $common['button'] = "Submit";
        $message = "News Added Successfully!";

        $categories = Categories::where('status','Active')->get();
        $tags = Tag::where('status','Active')->get();

        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data->toArray); die;
            $rules = [
                'title'        => 'required',
                'description'  => 'required',
                'content_type' => 'required'
            ];
            
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $news = new News();
            $news->category = $data['category'];
            $news->title = $data['title'];
            $news->tag   = implode(',', $data['tag']);
            // $news->content_type = $data['content_type'];
            $news->description  = $data['description'];
            $news->expiry_date  = $data['expiry_date'];
            $news->status       = $data['status'];

            if ($data['content_type'] === 'standard_post') {
                $news->content_type = $data['content_type'];
                $news->url = "-";
            }else if($data['content_type'] == 'youtube_video') {
                // $news->content_type = $data['youtube_video'];
                $news->content_type = 'youtube_video';
                $news->url = $data['youtube_video'];
            }else if($data['content_type'] == 'video_upload'){
                $news->content_type = 'video_upload';
                if(isset($request->upload_video)){
                    if($request->has('upload_video')){
                        $video = $request->file('upload_video');
                        $name  = time() .'.'.$video->getClientOriginalExtension();
                        $path  = public_path('uploads/news/videos/');
                        $video->move($path, $name);
                        $news->url = $name;
                    }
                }
            }else{
                $news->content_type = 'other_url';
                $news->url = $data['url_video'];
            }

            if($request->has('featured_image')){
                $image = $request->file('featured_image');
                $name  = time(). "." .$image->getClientOriginalExtension();
                $path  = public_path('uploads/news/featuredImage/');
                $image->move($path, $name);
                $news->featured_image = $name;
            }

            $news->save();

            // upload gallery image
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $key => $image){
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $path = public_path('uploads/news/galleryImage/');
                    $image->move($path, $name);

                    // insert image in news images table
                    $news_image = new NewsImage;
                    $news_image->news_id = $news->id;
                    $news_image->images = $name;
                    // echo "<pre>"; print_r($news_image->toArray()); die;
                    $news_image->save();
                }
            }
            return redirect('admin/news')->with('success_message', $message);
        }
        return view('admin::news.addnews', compact('common','categories','tags'));
    }

    /* --- view news --- */
    public function viewNews(Request $request, $id)
    {
        $id = decrypt($id);
        $news = News::with(['galleryimages','Category','Tag'])->find($id);
        // $news = News::with(['galleryimages','Category'], function($query){
        //     Tag::whereIn('id', explode(',', $news->tag))->get();
        // })->find($id);
      
        // echo "<pre>"; print_r(explode(',', $news->tag)); die;
        // echo "<pre>"; print_r($news->toArray()); die;

        return view('admin::news.viewnews')->with(compact('news'));
    }
    

    /* --- edit news --- */
    public function editNews(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'News';
        $common['heading_title'] = 'Edit news';
        $common['button'] = "Update";
        $id = decrypt($id);
        $news = News::with('galleryimages')->findOrFail($id);
        $message = "News Updated Successfully!";

        $categories = Categories::where('status','Active')->get();
        $tags = Tag::where('status','Active')->get();

        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data->toArray); die;
            $rules = [
                'title'        => 'required',
                'description'  => 'required',
                'content_type' => 'required'
            ];
            
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $news->category     = $data['category'];
            $news->title        = $data['title'];
            $news->tag          = implode(',', $data['tag']);
            // $news->content_type = $data['content_type'];
            $news->description  = $data['description'];
            $news->expiry_date  = $data['expiry_date'];
            $news->status       = $data['status'];

            if ($data['content_type'] === 'standard_post') {
                $news->content_type = $data['content_type'];
                $news->url = "-";
            }else if($data['content_type'] == 'youtube_video') {
                // $news->content_type = $data['youtube_video'];
                $news->content_type = 'youtube_video';
                $news->url  = $data['youtube_video'];
            }else if($data['content_type'] == 'video_upload'){
                $news->content_type = 'video_upload';
                if(isset($request->upload_video)){
                    if($request->has('upload_video')){
                        $video = $request->file('upload_video');
                        $name  = time() .'.'.$video->getClientOriginalExtension();
                        $path  = public_path('uploads/news/videos/');
                        $video->move($path, $name);
                        $news->url = $name;
                    }
                }
            }else{
                $news->content_type = 'other_url';
                $news->url = $data['url_video'];
            }

            // upload feature image 
            if($request->has('featured_image')){
                $image = $request->file('featured_image');
                $name  = time(). "." .$image->getClientOriginalExtension();
                $path  = public_path('uploads/news/featuredImage/');
                $image->move($path, $name);
                $news->featured_image = $name;
            }

            $news->save();

            // upload gallery image
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $key => $image){
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $path = public_path('uploads/news/galleryImage/');
                    $image->move($path, $name);

                    // insert image in news images table
                    $news_image = new NewsImage;
                    $news_image->news_id = $news->id;
                    $news_image->images = $name;
                    // echo "<pre>"; print_r($news_image->toArray()); die;
                    $news_image->save();
                }
            }
            return redirect('admin/news')->with('success_message', $message);
        }
        return view('admin::news.editnews', compact('common','categories','tags','news'));
    }

    /* --- delete gallery image */
    public function deletegalleryImages($id)
    {
        $newsImage = NewsImage::findOrFail($id);

        /* -- get gallery image path -- */
        $image_path = public_path('uploads/news/galleryImage/');

        if(file_exists($image_path.$newsImage->images)){
            unlink($image_path.$newsImage->images);
        }

        /* -- delete gallery image -- */
        $newsImage->delete();
        $message = "Gallery Image has been deleted Successfully!";
        return back()->with('success_message', $message);
    }


    /* --- delete news --- */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        /* -- get featured image path -- */
        $image_path = public_path('uploads/news/featuredImage/');

        if(file_exists($image_path.$news->featured_image)){
            unlink($image_path.$news->featured_image);
        }

        $news->delete();

        /* -- get gallery image path -- */
        $newsImage = NewsImage::where('news_id', $id);

        /* -- get gallery image path -- */
        $image_path = public_path('uploads/news/galleryImage/');

        if(file_exists($image_path.$newsImage->images)){
            unlink($image_path.$newsImage->images);
        }

        /* -- delete gallery image -- */
        $newsImage->delete();
        return redirect()->back()->with('success_message', 'News Deleted Successfully!');
    }
}

@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $common['title'] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $common['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title nofloat"> <span>{{ $common['heading_title']}} </span> 
                            {{-- <a href="{{ url('admin/news')}}">
                                <button onClick="back();"
                                    class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                    data-modal="modal-13" style="float: right"><i class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back
                                </button>
                            </a> --}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="newsDetailForm" id="main" 
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('category') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">{{('Category')}}</label>
                                        <select class="form-control" id="category" name="category">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                               <option value="{{ $category['id']}}">{{ $category['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">{{('Title')}}</label>
                                        <input
                                            class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                            name="title" type="text"
                                            value="{{ old('title') }}" placeholder="Enter title"> 
                                        @error('title')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('tag') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Tag*</label>
                                        <select class="form-control" id="tag" name="tag[]" multiple="multiple">
                                            <option value="">Select tag</option>
                                            @foreach($tags as $key => $tag)
                                            <option value="{{ $tag['id']}}">{{ $tag['name']}}</option>
                                            @endforeach
                                        </select>
                                        @error('tag')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('content_type') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Content Type</label>
                                        <select id="content_type" name="content_type" class="form-control stock">
                                            <option value="standard_post">Standard Post</option>
                                            <option value="youtube_video">Video (YouTube)</option>
                                            <option value="other_url">Video (Other URL)</option>
                                            <option value="video_upload">Video (Upload)</option>
                                        </select>
                                        @error('content_type')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="youtube_video" style="display:none;">
                                    <div class="form-group mb-3 {{ $errors->has('youtube_video') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">YouTube URL</label>
                                        <input type="text" id="youtube_video" name="youtube_video" class="form-control" placeholder="YouTube URL">
                                        @error('youtube_video')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="url_video" style="display:none;">
                                    <div class="form-group mb-3 {{ $errors->has('url_video') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Other URL</label>
                                        <input type="text" id="url_video" name="url_video" class="form-control" placeholder="Other URL">
                                        @error('url_video')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="upload_video" style="display:none;">
                                    <div class="form-group mb-3 {{ $errors->has('upload_video') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Upload Video*</label>
                                        <input type="file"
                                            class="form-control {{ $errors->has('upload_video') ? 'form-control-danger' : '' }}"
                                            onchange="loadFile(event,'image_1')" name="upload_video">
                                        @error('upload_video')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('featured_image') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Banner Image*</label>
                                        <input type="file"
                                            class="form-control {{ $errors->has('featured_image') ? 'form-control-danger' : '' }}"
                                            onchange="loadFile(event,'image_1')" name="featured_image">
                                        {{-- @if(!empty($news['featured_image']))
                                        <input type="hidden" name="current_image" value="{{ $news['featured_image'] }}">
                                        @endif --}}
                                        @error('featured_image')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- <div class="media-left">
                                        <a href="#" class="profile-image">
                                        <img class="user-img img-css" id="image_1"
                                            src="{{ $news['featured_image'] != '' ? asset('uploads/news/bannerImage/'. $news['featured_image']) : asset('assets/upload/placeholder.png') }}">
                                        </a>
                                    </div> --}}
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('images') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Gallery Images : (Recommend Size: Less than 2 Mb)</label>
                                        <input type="file"
                                            class="form-control {{ $errors->has('images') ? 'form-control-danger' : '' }}"
                                            onchange="loadFile(event,'image_1')"  name="images[]" multiple="" id="images">
                                        @error('images')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="media-left">
                                        <ul class="multiImg">
                                            {{-- @foreach($news['images'] as $value)
                                            <li>
                                                @if($value['product_id'] == $products['id'])
                                                    <a target="_blank" href="{{ asset('uploads/news/galleryImages/'. $value['image'])}}"><img src="{{ $value['image'] != '' ? asset('uploads/products/galleryImages/small/'. $value['image']) : asset('assets/upload//placeholder.png') }}"  class="user-img img-css" id="image_1">
                                                    </a>&nbsp;
                                                    <a href="{{ url('admin/product/deleteImage/'. $value['id'])}}" title="Delete Image" name="product" title="Delete Product Image"> <i class="fa-solid fa-trash" style="color: red;"></i> 
                                                    </a>
                                                @endif  
                                            </li>
                                            @endforeach --}}
                                        </ul>
                                    </div>
                                </div>                         
                                <div class="col-md-12">
                                    <div class="form-group mb-3 {{ $errors->has('description') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Description*</label>
                                        <textarea
                                        class="form-control summernote {{ $errors->has('description') ? 'form-control-danger' : ''}}"
                                        name="description" type="message"
                                            placeholder="Enter Description">{{ old('description') }}</textarea>  
                                        @error('description')
                                            <div class="col-form-alert-label">
                                            {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('expiry_date') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">{{('Show Till (Expiry Date)')}}</label>
                                        <input
                                            class="form-control {{ $errors->has('expiry_date') ? 'form-control-danger' : '' }}"
                                            name="expiry_date" type="date"
                                            value="{{ old('expiry_date') }}"> 
                                        @error('expiry_date')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Status</label>
                                        <select id="status" name="status" class="form-control stock">
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                        </select>
                                        @error('status')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer"> <button type="submit" class="btn btn-primary">{{$common['button']}}</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // multiple tag selection
        $('#tag').select2({
            placeholder : 'Select tag',
            allowClear : true,
            minimumResultsForSearch : 2,
            multiple : true,
        });

        $('#content_type').change(function() {
            var selectedValue = $(this).val();

            // show youtube url 
            if (selectedValue === 'youtube_video') {
                $('#youtube_video').show();
            } 
            else {
                $('#youtube_video').hide();
            }

            // show video url
            if(selectedValue === 'other_url') {
                $('#url_video').show();
            }else{
                $('#url_video').hide();
            }

            // upload video 
            if(selectedValue === 'video_upload') {
                $('#upload_video').show();
            }else{
                $('#upload_video').hide();
            }
        });
    });
</script>
@endsection


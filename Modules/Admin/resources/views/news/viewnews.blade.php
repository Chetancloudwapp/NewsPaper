@extends('admin::layouts.master')
@section('content')
<style>
    .multiImg{
        margin: 0px; 
        padding: 0px;
        list-style: none; 
        display: flex; 
        flex-wrap: wrap;
    }
    .multiImg li{
    width: 100px;
    position: relative;
    /* background: #00000091; */
    border: 1px solid #000;
    position: relative;
    margin-right: 15px;
    border-radius: 5px;
    padding: 43px;
    margin-top: 10px;

    }
    .multiImg li a {
    position: absolute;
    top: 4px;
    right: 7px;
    color: #000;
    /* background: #000; */
    /* padding: 5px; */
    /* border-radius: 50%; */
}
    .multiImg li img{width: 100%; height:100px}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>News</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">News</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @csrf
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card card-primary">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Title</label>
                                            <h6>{{ $news->title}} </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Category</label>
                                            <h6>{{ $news->Category->title ?? '-'}} </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <h6>{{ strip_tags($news->description) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Featured Image </label>
                                            <section class="uploadImg">
                                                <img src="{{ $news->featured_image !='' ? asset('public/uploads/news/featuredImage/'. $news->featured_image) : asset('public/uploads/placeholder/default_user.png') }}" width="15%"> 
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Gallery Image </label>
                                            <ul class="multiImg">
                                                @foreach($news['galleryimages'] as $value)
                                                <li>
                                                    <a target="_blank" href="{{ asset('public/uploads/news/galleryImage/'. $value['images'])}}"><img src="{{ $value['images'] != '' ? asset('public/uploads/news/galleryImage/'. $value['images']) : asset('public/uploads/placeholder/default_user.png') }}"  class="user-img img-css" id="image_1">
                                                    </a>&nbsp;
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
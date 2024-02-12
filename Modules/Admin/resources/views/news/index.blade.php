@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$common['title']}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$common['title']}}</li>
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
                            @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <h3 class="card-title nofloat"> <span>{{$common['title']}}</span>
                                <span> 
                                    <a href="{{ url('admin/news/add') }}"> <button type="button"
                                        class="btn btn-block btn-primary"><i
                                            class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add News</button>
                                    </a> 
                                </span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Content Type</th>
                                        <th>Featured Image</th>
                                        {{-- <th>Gallery Image</th> --}}
                                        <th>Description</th>
                                        <th>status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($get_news as $key => $news)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <?php
                                              if($news['category']){
                                                $get_category = Modules\Admin\app\Models\Categories::select('id','title','status')->where(['status'=>'Active', 'id'=>$news['category']])->first();
                                                if($get_category){
                                                    echo $get_category->title;
                                                }else{
                                                    echo "-";
                                                }
                                              }else{
                                                echo "-";
                                              }
                                            ?>
                                        </td>
                                        <td>{{ $news['title'] }}</td>
                                        <td>{{ $news['content_type'] }}</td>
                                        <td>
                                            <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius: 50%;"
                                                src="{{ $news['featured_image'] !='' ? asset('public/uploads/news/featuredImage/'. $news['featured_image']) : asset('uploads/placeholder/default_user.png')}}">
                                        </td>
                                        {{-- <td>
                                            <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius: 50%;"
                                                src="{{ $news['gallery_image'] !='' ? asset('public/uploads/news/'. $news['gallery_image']) : asset('uploads/placeholder/default_user.png')}}">
                                        </td> --}}
                                        <td>{{ strip_tags($news['description']) }}</td>
                                        <td>
                                            @if($news['status'] == 'Active')
                                               <span class="badge badge-pill badge-success">{{ $news['status']}}</span>
                                            @else
                                               <span class="badge badge-pill badge-danger">{{ $news['status'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/news/view/'. encrypt($news['id']))}}"> 
                                                <button class="btn btn-info btn-sm">view</button>
                                                {{-- <i class="fa-solid fa-eye"></i>  --}}
                                            </a>
                                            <a href="{{ url('admin/news/edit/'. encrypt($news['id'])) }}"> 
                                                <button class="btn btn-primary btn-sm">Edit</button>
                                            </a>
                                            <a href="javascript:void(0)" style="margin-left:0em" record="news/delete"
                                                record_id="{{ $news['id'] }}" class="confirmDelete" name="news"
                                                title="Delete news Page"> 
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', ".confirmDelete", function(){
           var record = $(this).attr('record');
           var record_id = $(this).attr('record_id');
           Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )

                root = "{{ config('app.url') }}"
                window.location.href = root + "/admin/"+record+"/"+record_id;
            }
            });
        });
    });
</script>
@endsection
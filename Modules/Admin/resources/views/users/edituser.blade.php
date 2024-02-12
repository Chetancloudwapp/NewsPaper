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
                                {{-- <a href="{{ url('admin/users')}}">
                                    <button onClick="back();"
                                        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                        data-modal="modal-13" style="float: right"> <i class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back
                                    </button>
                                </a> --}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="usersDetailForm" id="main" 
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('name') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Name*</label>
                                        <input
                                            class="form-control {{ $errors->has('name') ? 'form-control-danger' : '' }}"
                                            name="name" type="text"
                                            value="{{ old('name', $users['name']) }}" placeholder="Enter name">      
                                        @error('name')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Email*</label>
                                        <input
                                            class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                            name="email" type="email"
                                            value="{{ old('email', $users['email']) }}" placeholder="Enter email">      
                                        @error('email')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('countries') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Countries*</label>
                                        <select class="form-control" id="countries" name="countries">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                               <option value="{{$country['id']}}" {{ $country['id'] == $users['country'] ? 'selected' : ''}}>{{ $country['name']}}</option>
                                            @endforeach
                                        </select>
                                        @error('email')
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
                                            {{-- <option value="Deactive">Deactive</option> --}}
                                            <option value="Deactive"
                                                {{ $users['status'] == 'Deactive' ? 'selected' : '' }}>Deactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer"> <button type="submit" class="btn btn-primary">{{$common['button']}}</button> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


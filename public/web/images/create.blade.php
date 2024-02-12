@extends('admin::layouts.master') @section('content')
<!-- Preloader --> @include('admin::partials.sidebar')

<style>
    .btn-info {
    color: #fff !important;
    background-color: #ff6e2c !important;
    border-color: #ff6e2c !important;
    box-shadow: none;
}
.ui.dropdown .menu .active.item {
    
    color: #fff !important;
    background: #FD7418 !important;
    margin: 0 10px;
    padding:8px !important;
}
.ui.multiple.dropdown .menu {
    cursor: auto;
    padding-bottom: 15px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{isset($page_title) ? $page_title:''}}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li><li class="breadcrumb-item active">{{isset($page_title) ? $page_title:''}}</li> -->
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card card-default">
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            @if(session()->has('success')) 
                                <p class="alert alert-success text-center">{{session()->get('success')}}</p> 
                            @endif 
                            @if(session()->has('failed_email')) 
                                <p class="alert alert-danger text-center">{{session()->get('failed_email')}}</p> 
                            @endif 
                            <form method="POST" enctype="multipart/form-data"> 
                                @csrf 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" type="text" name="title" value="{{old('title')}}" style="width: 100%;" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Place Category</label>
                                            	<div class="ui form">
                                                 <div class="inline field">
                                            <select class="form-control ui fluid selection dropdown no label" type="text" id="multiple-checkboxes" name="category[]" value="{{old('category')}}"  multiple="" /> 
                                                @foreach($category as $categories) 
                                                <option value="">All</option>
                                                    <option value="{{$categories->id}}">{{$categories->name}}</option> 
                                                @endforeach 
                                            </select>
                                             </div>  
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" id="autocomplete" class="form-control" placeholder="Choose Location" required>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group" id="">
                                            <label>Latitude</label>
                                            <input type="text" id="latitude" name="lat" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group" id="">
                                            <label>Longitude</label>
                                            <input type="text" name="lng" id="longitude" class="form-control">
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="text" name="website" class="form-control" placeholder="Enter Website Url" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" id="state" name="state" class="form-control" placeholder="Enter your state" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter your city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" id="zip_code" name="zip_code" class="form-control" placeholder="Enter Zip Code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input class="form-control" type="file" name="image" value="" style="width: 100%;" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea row="6" class="form-control" name="description"></textarea>
                                            <!--<input class="form-control" type="text" name="title" value="{{old('title')}}" style="width: 100%;" required/>-->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Hours</label> 
                                            <?php $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];$count=1;?> 
                                            @foreach($days as $day) 
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label>{{$day}}</label>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <div class="form-group">
                                                                        <input type="radio" id="elementId2" name="status-{{$day}}" value="Open" class="btn btn-primary reset{{$count}}" />
                                                                        <label for="elementIda" style="margin-right:20px;" for="elementId2">Open</label>
                                                                        <input type="radio" id="elementId" name="status-{{$day}}" value="Closed" class="btn btn-primary elementId{{$count}}" />
                                                                        <label for="elementId" >Close</label>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div id="ifYes" style="">
                                                                                    <label>Start Time</label>
                                                                                    <input type="time" class="form-control input-md disable-field{{$count}}" name="start_time-{{$day}}" id="textinput">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div id="ifYes" style="">
                                                                                    <label>End Time</label>
                                                                                    <input type="time" class="form-control input-md disable-field{{$count}}" name="end_time-{{$day}}" id="textinput">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <?php $count+=1;?> 
                                            @endforeach
                                        </div>
                                    </div>
                                    </div><button class="btn btn-info" name="submit" value="submit" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
<!-- /.content -->
</div> @include('admin::partials.scripts') 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyD7fSNx2zaxcHmraMpgojfk18m3y-Spk7Y&libraries=places" ></script>
    
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js" integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    
    <script>
            $(document).ready(function () {
                $("#latitudeArea").addClass("d-none");
                $("#longtitudeArea").addClass("d-none");
            });
            
            // $(document).ready(function() {
            //     $('#multiple-checkboxes').multiselect({
            //       includeSelectAllOption: true,
            //     });
            // });
    </script>
       
       
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);
        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                // console.log(place.geometry['location'])
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
              
                
                
                // Extract address components
                let country, city, zipcode, state;
                
                for (const component of place.address_components) {
                    if (component.types.includes('country')) {
                       country = component.long_name;
                    } else if (component.types.includes('locality')) {
                       city = component.long_name;
                    } else if (component.types.includes('administrative_area_level_1')) {
                       state = component.long_name;
                    } else if (component.types.includes('postal_code')) {
                        zipcode = component.long_name;
                    }
                }
                
                $('#state').val(state);
                $('#city').val(city);
                $('#zip_code').val(zipcode);
      
      
              
                
                // $('#map').html(`<iframe src="//maps.google.com/maps?q=${place.geometry['location'].lat()},${place.geometry['location'].lng()},${place.geometry['location'].state()},${place.geometry['location'].city()}&z=15&output=embed" width="100%" height="200" frameborder="0"></iframe>`);
                // $('#map').html(`<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319" width="100%" height="200" frameborder="0" style="border:0"></iframe>`);
                
            });
        }
        
</script>
<script>
  $('.elementId1').change(function() {
    $('.disable-field1').prop('disabled', true);
  });
  $('.reset1').change(function() {
    $('.disable-field1').prop('disabled', false);
  });
</script>
<script>
  $('.elementId2').change(function() {
    $('.disable-field2').prop('disabled', true);
  });
  $('.reset2').change(function() {
    $('.disable-field2').prop('disabled', false);
  });
</script>
<script>
  $('.elementId3').change(function() {
    $('.disable-field3').prop('disabled', true);
  });
  $('.reset3').change(function() {
    $('.disable-field3').prop('disabled', false);
  });
</script>
<script>
  $('.elementId4').change(function() {
    $('.disable-field4').prop('disabled', true);
  });
  $('.reset4').change(function() {
    $('.disable-field4').prop('disabled', false);
  });
</script>
<script>
  $('.elementId5').change(function() {
    $('.disable-field5').prop('disabled', true);
  });
  $('.reset5').change(function() {
    $('.disable-field5').prop('disabled', false);
  });
</script>
<script>
  $('.elementId6').change(function() {
    $('.disable-field6').prop('disabled', true);
  });
  $('.reset6').change(function() {
    $('.disable-field6').prop('disabled', false);
  });
</script>
<script>
  $('.elementId7').change(function() {
    $('.disable-field7').prop('disabled', true);
  });
  $('.reset7').change(function() {
    $('.disable-field7').prop('disabled', false);
  });
</script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css" />
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>

<script>
	

$('.label.ui.dropdown')
  .dropdown();

$('.no.label.ui.dropdown')
  .dropdown({
  useLabels: false
});

$('.ui.button').on('click', function () {
  $('.ui.dropdown')
    .dropdown('restore defaults')
})


</script>



@endsection
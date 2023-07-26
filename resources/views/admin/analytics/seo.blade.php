@extends('layouts.admin')
@section('page-title')
    {{ __('SEO Analytics') }}
@endsection
@section('action-button')
@if(count($site_data)>0)
<div class=" d-flex align-items-center flex-wrap gap-3">
   <div class="select-box">
     <select class="form-select" name="site_name" id="site-list" >@foreach($site_data as $val) <option value="{{$val->id}}">{{$val->site_name}}</option> @endforeach  </select>
    </div>
    @if(\Auth::user()->can('manage share report settings'))

    <div class="btn p-0">
      <a class="btn btn-primary" onclick="share_setting('seo');" data-bs-toggle="modal"  data-bs-target="#share_seo_report"><span>
        <i class="ti ti-settings" data-bs-toggle="tooltip" data-bs-original-title="{{__('Share Report Setting')}}"></i></span></a>
    </div>
    @endif
    @if(\Auth::user()->can('manage share report'))
    <div class="link" data-bs-toggle="tooltip" data-bs-original-title="{{__('Share Report')}}"></div>
    @endif

</div>
@endif
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
      <li class="breadcrumb-item" aria-current="page">{{ __('SEO Analytics') }}</li>
@endsection
@section('content')
@if(count($site_data)>0)
    
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-10 ">
                  <div class=" ">
                      <ul class="nav nav-pills nav-fill row" id="pills-tab" role="tablist">
                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics active " id="pills-tab-1" onclick="get_seo_data()" data-bs-toggle="pill" data-value="ga:keyword"
                                  data-bs-target="#" type="button">{{('Keyword')}}</button>
                            
                          </li>
                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics" id="pills-tab-2" data-value="ga:socialNetworkh"  onclick="get_seo_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                  data-bs-target="#" type="button">{{('Social Network')}}</button>
                          </li>

                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics" id="pills-tab-3" data-value="ga:source"  onclick="get_seo_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                  data-bs-target="#" type="button">{{('Source')}}</button>
                          </li>
                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics" id="pills-tab-2" data-value="ga:browser"  onclick="get_seo_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                  data-bs-target="#" type="button">{{('Browser')}}</button>
                          </li>

                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics" id="pills-tab-3" data-value="ga:operatingSystem"  onclick="get_seo_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                  data-bs-target="#" type="button">{{('Operating System')}}</button>
                          </li>
                          <li class="nav-item col-sm-1" role="presentation">
                              <button class="nav-link seo-analytics" id="pills-tab-3" data-value="ga:mobileDeviceBranding"  onclick="get_seo_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                  data-bs-target="#" type="button">{{('Device')}}</button>
                          </li>
                          
                          
                          <li class="col-sm-7"></li>
                      </ul>
                  </div>
               
              </div>
                <div class="col-md-2">
                    <div class="input-group mr-sm-2">
                      <input type="text" name="date_duration"  onchange="get_seo_data()" class="form-control date_duration w-100" id="date_duration" />
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>  

<div class="col-sm-12 col-md-12 col-xxl-12">
  <div class="card">
      <div class="card-body">
          <div class="tab-content" id="pills-tabContent">
               <?php $j=1; ?>
              @foreach($metric_option as $val)
              @if($j==1)
              <div class="tab-pane fade show active" id="channel-chart-{{$j}}" role="tabpanel"
                  aria-labelledby="pills-user-tab-1">
                  @else
                  <div class="tab-pane fade =" id="channel-chart-{{$j}}" role="tabpanel"
                  aria-labelledby="pills-user-tab-1">
                  @endif
                  <div class="row">
                    <div class="col-md-6">

                       <div class="card">
                          <div class="card-body">
                            <div id="seo-line-chart-{{$val}}">
                              <div class="loader " id="progress">
                                <div class="spinner text-center" style="align-items: center;">
                                  <img height="452px"  src="{{asset('assets/images/loader.gif')}}" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                            <div id="seo-bar-chart-{{$val}}">
                              <div class="loader " id="progress">
                                <div class="spinner text-center" style="align-items: center;">
                                  <img height="452px"  src="{{asset('assets/images/loader.gif')}}" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
              </div>
              <?php $j++; ?>
              @endforeach
          </div>
      </div>
  </div>
  <div class="p-3 card">
    <ul class="nav nav-pills nav-fill row" id="pills-tab" role="tablist">
      @if(count($metric_option)>0)
      <?php $i=1;?>
      @foreach($metric_option as $val)
        <li class="nav-item col-md-3" role="presentation">
          @if($i==1)
          <div class="card nav-link seo-card-metrics active" id="{{$val}}" data-bs-toggle="pill"
                data-bs-target="#channel-chart-{{$i}}"  type="button">
          @else
          <div class="card nav-link seo-card-metrics" id="{{$val}}" data-bs-toggle="pill"
                data-bs-target="#channel-chart-{{$i}}" data-id="{{$val}}" type="button">
          @endif
            <div class="card-body px-lg-5">
              <h4 id="seo_metric_data_{{$val}}">0</h4>
              <h5>{{$val}}</h5>
            </div>
          </div>
            
        </li>
      <?php $i++;?>
      @endforeach
      @endif
    </ul>
  </div>
</div>      
 
<div id="share_seo_report" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPopoversLabel">{{__('Share Report')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('save-share-setting','seo') }}"  enctype="multipart/form-data"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="share_site"id="share_site">
                             <div class="form-group col-md-2">
                                <label for="name" class="col-form-label"> {{ __('Keyword') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="keyword" id="keyword">
                                    <label class="form-check-label" for="keyword"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label"> {{ __('Social Network') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="social_network" id="social_network">
                                    <label class="form-check-label" for="social_network"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label"> {{ __('Source') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="source" id="source">
                                    <label class="form-check-label" for="source"></label>
                                </div>
                            </div>
                           <div class="form-group col-md-2">
                                <label for="name" class="col-form-label"> {{ __('Browser') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="browser" id="browser">
                                    <label class="form-check-label" for="browser"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label"> {{ __('Operating System') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="operating_system" id="operating_system">
                                    <label class="form-check-label" for="operating_system"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label"> {{ __('Device') }} </label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="device" id="device">
                                    <label class="form-check-label" for="device"></label>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="name" class="col-form-label"> {{__('Password Protected') }} </label>
                                <div class="form-check form-switch">
                                    <input onclick="password_status()" type="checkbox" class="form-check-input input-primary"name="is_password" id="is_password">
                                    <label class="form-check-label" for="is_password"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                
                                <div style="display: none" id="password-box">
                                    <div class="action input-group input-group-merge  text-left ">
                                        <input type="password" value="12345678" class=" form-control " name="password" autocomplete="new-password" id="password" placeholder="Enter Your Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text py-3">
                                                <a href="#" data-toggle="password-text" data-target="#password">
                                                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" title="{{__('Copy')}}" class="btn  btn-primary" >{{__('Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
          <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });

    // prevent form submit
    // const form = document.querySelector("form");
    // form.addEventListener('submit', function (e) {
    //     e.preventDefault();
    // });
</script>
<script type="text/javascript">
  $(function (){      
        get_seo_data();
        if ($('.seo-card-metrics').length > 0) {
            $('.seo-card-metrics').on('click', function (e) {
                e.preventDefault();
               
                analytics_chart($(this).attr('id'),"seo");
            });
        }
    });
  
</script>
@else
<div class="col-md-12" style="height: 200px; ">
      <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
              {{__('No Data Found !')}}
             
            </div>
    </div>
@endif
@endsection
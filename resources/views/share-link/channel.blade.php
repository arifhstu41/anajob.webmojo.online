@extends('layouts.share-link')
@section('breadcrumb')
   
    <li class="breadcrumb-item" id="current_site" data-siteid="{{$data->id}}">{{$data->site_name}}</li> 
@endsection
@section('lang-section')
@foreach($languages as $language)
    <a class="dropdown-item @if($language == $currantLang) text-danger @endif" href="{{route('site.analyse.link',[\Illuminate\Support\Facades\Crypt::encrypt($data->id),\Illuminate\Support\Facades\Crypt::encrypt($type),$language])}}">{{\Str::upper($language)}}</a>
@endforeach
@endsection

@section('content')
@if($data)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                       
                        <div class="col-md-10 ">
                          <div class=" ">
                              <ul class="nav nav-pills nav-fill row" id="pills-tab" role="tablist">
                                @if($json->all==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics active " id="pills-tab-1" onclick="get_channel_data({{$data->id}})" data-bs-toggle="pill" data-value
                                          data-bs-target="#" type="button">{{('All')}}</button>
                                    
                                  </li>
                                  @endif
                                  @if($json->organic_search==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" id="pills-tab-2" data-value="gaid::-5"  onclick="get_channel_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Organic Search')}}</button>
                                  </li>
                                   @endif
                                  @if($json->paid_search==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" id="pills-tab-3" data-value="gaid::-4"  onclick="get_channel_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Paid Search')}}</button>
                                  </li>
                                   @endif
                                  @if($json->bounce==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" id="pills-tab-4" data-value="gaid::-19"  onclick="get_channel_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Bounce')}}</button>
                                  </li>
                                   @endif
                                  @if($json->referrals==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" id="pills-tab-5" data-value="gaid::-8" onclick="get_channel_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Referrals')}}</button>
                                  </li>
                                   @endif
                                  @if($json->converters==1)
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" data-value="gaid::-102" id="pills-tab-6"  onclick="get_channel_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Converters')}}</button>
                                  </li>
                                   @endif
                                  @if($json->other==1)
                                   <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link chanel-analytics" onclick="get_channel_data()" id="pills-tab-8" data-value="gaid::-18" data-bs-toggle="pill"
                                          data-bs-target="#" type="button">{{('Other')}}</button>
                                  </li>
                                   @endif
                                  <li class=""></li>
                              </ul>
                          </div>
                       
                      </div>
                        <div class="col-md-2">
                            <div class="input-group mr-sm-2">
                              <input type="text" name="date_duration"  onchange="get_channel_data()" class="form-control date_duration w-100" id="date_duration" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>  
    </div>
    <div class="row">
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
                                  <div id="channel-line-chart-{{$val}}">
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
                                  <div id="channel-bar-chart-{{$val}}">
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
                <div class="card nav-link card-metrics active" id="{{$val}}" data-bs-toggle="pill"
                      data-bs-target="#channel-chart-{{$i}}"  type="button">
                @else
                <div class="card nav-link card-metrics" id="{{$val}}" data-bs-toggle="pill"
                      data-bs-target="#channel-chart-{{$i}}" data-id="{{$val}}" type="button">
                @endif
                  <div class="card-body px-lg-5">
                    <h4 id="metric_data_{{$val}}">0</h4>
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
    </div>
   

<script type="text/javascript">
  $(function (){   
           var site = $('#current_site').attr('data-siteid');

        get_channel_data(site);
        if ($('.card-metrics').length > 0) {
            $('.card-metrics').on('click', function (e) {
                e.preventDefault();
               
                analytics_chart($(this).attr('id'),"channel");
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

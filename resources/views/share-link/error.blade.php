@extends('layouts.share-link')

@section('action-button')

@endsection

@section('lang-section')
@foreach($languages as $language)

    <a class="dropdown-item @if($language == $currantLang) text-danger @endif" href="{{route('share-link-error',[$language])}}">{{\Str::upper($language)}}</a>
@endforeach
@endsection
@section('content')
<div class="col-md-12">
    <h1>Error!</h1>
</div>  

<script type="text/javascript">
  $(function (){  
      get_custom_share_chart();
    });
  
</script>
@endsection
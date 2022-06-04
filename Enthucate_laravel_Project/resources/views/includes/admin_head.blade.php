 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Enthucate</title>
   
  <link rel="stylesheet" href="{{ asset('public/assets/vendor/jqvmap/css/jqvmap.min.css') }} ">
  <link rel="stylesheet" href="{{ asset('public/assets/vendor/chartist/css/chartist.min.css') }} ">
  <link href="{{ asset('public/assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
  <!-- Vectormap -->
  <link rel="stylesheet" href="{{ asset('public/assets/vendor/jqvmap/css/jqvmap.min.css') }} ">
  <link rel="stylesheet" href="{{ asset('public/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/css/developer.css') }}">
  <link rel="stylesheet" href="https://cdn.lineicons.com/2.0/LineIcons.css">
  <link rel="stylesheet" href="{{ asset('public/assets/vendor/owl-carousel/owl.carousel.css') }}">
  <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}" />

  <input type="hidden" name="siteurl" id="siteurl" value="{{URL::to('/')}}">
  <input type="hidden" name="csrftoken" id="csrftoken" value="{{ csrf_token() }}">
  <input type="hidden" name="role_id" id="role_id" value="{{ auth()->user()->role_id }}">
  <input type="hidden" name="organisation_url" id="organisation_url" value="{{ auth()->user()->organisation_url }}">
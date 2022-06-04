@extends('layouts.admin_layout')
@section('title', 'Dashboard - Enthucate')
@section('content')

<!--**********************************
	Content body start
***********************************-->
<div class="content-body" style="min-height: 1100px;">
	<!-- row -->
	<div class="container-fluid">
	@if(session()->has('success'))
      <div class="alert alert-success" id="successMessage" style="white-space: pre-line;">{{ session()->get('success') }}</div>
    @endif
    @if(session()->has('error'))
       <div class="alert alert-danger" id="errorMessage">
            {{ session()->get('error') }}
        </div>        
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" id="errorMessage">
           <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
           </ul>
        </div>
    @endif
		<div class="row">		
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-primary">
					<div class="card-body ">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-sitemap icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Organisations</p>
								<span class="fs-48 text-white font-w600">{{$orgcount}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-secondary">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-university icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Schools</p>
								<span class="fs-48 text-white font-w600">{{$school}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-info">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-users icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Groups</p>
								<span class="fs-48 text-white font-w600">{{$group}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-success">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-building icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Departments</p>
								<span class="fs-48 text-white font-w600">{{$department}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>




@endsection
@section('page_script')
<script type="text/javascript">
  
   $('#Membersearch').click(function(){
      $('form#myForm').submit();
});
   $(".invitesaccept").click(function(){
     var id = $(this).attr('id');
     $('#acceptid').val(id);
     });
   $(".invitesreject").click(function(){
     var id = $(this).attr('id');
     $('#rejecttid').val(id);
     });
   
</script>
@endsection
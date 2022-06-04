@extends('layouts.superadmin_layout')
@section('title', 'Add Class - Enthucate')
@section('content')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-lg-12">
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
                    <div class="col-xl-12">
                        <form method="POST" action="{{ url('/superadmin/save-class' ) }}">
                           @csrf
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Add class</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">class Details</span></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                   <select class="form-control seleorganisation_id" id="seleorganisationid" name="organisation">
                                                        <option value="">Select Organisation</option> 
                                                        @if(!empty($organisations))
                                                            @foreach($organisations as $organisation)
                                                                <option value="{{$organisation->id}}">{{$organisation->organisation_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 selectschool">
                                                <div class="form-group">
                                                    <label>School <span class="requried">*</span></label>
                                                    <select class="form-control selectschoolvalue" id="selectschoolvalue" name="school">
                                                    <option value="">Select School</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 selectgrade">
                                                <div class="form-group">
                                                    <label>Grade <span class="requried">*</span></label>
                                                    <select class="form-control selectgradevalue" id="selectgradevalue" name="grade">
                                                    <option value="">Select Grade</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Class Name <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" name="class_name" id="class_name" value="{{ old('class_name') }}" placeholder="Enter class name" />
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page_script')
@endsection
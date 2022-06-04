@extends('layouts.admin_layout')
@section('title', 'Group Edit - Enthucate')
@section('content')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
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
            <div class="col-xl-12 col-xxl-12 col-lg-12">
                <div class="row">
                    <div class="col-xl-12">
                         <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/update-group/'.$group->id ) }}">
                           @csrf
                           <?php
                            $memberid = array();
                            if($group->members != ''){
                                $memberid = explode(',', $group->members);
                            }
                            $create_memberid = array();
                            if($group->create_members != ''){
                                $create_memberid = explode(',', $group->create_members);
                            } 

                           ?>
                           <input type="hidden" name="organisation" value="{{$group->organisation_id}}">
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Group</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="submit" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Group *</label>
                                                    <input type="text" class="form-control" placeholder="Enter name"  name="group_name" value="{{$group->group_name}}"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" placeholder="Enter Description" name="description" value="{{$group->description}}"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Members</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="members[]" multiple="" class="form-control" id="sel2" tabindex="-98">
                                                            <option value="">Select Members</option> 
                                                            @if(!empty($members))
                                                                @foreach($members as $member)
                                                                    <option value="{{$member->id}}" @if(in_array($member->id, $memberid)) selected @endif >{{$member->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Message Create Members </label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="create_members[]" multiple="" class="form-control" id="sel2" tabindex="-98">
                                                            <option value="">Select Create Members</option> 
                                                            @if(!empty($members))
                                                                @foreach($members as $member)
                                                                    <option value="{{$member->id}}" @if(in_array($member->id, $create_memberid)) selected @endif>{{$member->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div>                                       
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
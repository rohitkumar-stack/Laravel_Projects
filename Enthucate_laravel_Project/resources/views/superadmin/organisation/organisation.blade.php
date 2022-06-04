@extends('layouts.superadmin_layout')
@section('title', 'Organisation List - Enthucate')
@section('content')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Organisation</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">                                                              
                                <table id="example3" class="display table-responsive-lg dataTable no-footer organisations_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Department: activate to sort column ascending">Level</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Gender: activate to sort column ascending">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Action: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(!empty($results)){
                                            if(isset($results['organisations']) && $results['organisations'] != ''){
                                                foreach ($results['organisations'] as $key => $result) { 
                                                    $hierarchy = App\Models\Hierarchy::where('id', $result->hierarchy_id)->first();
                                                    ?>
                                                    <tr role="row">
                                                    <td>{{$result->organisation_name}}</td>
                                                    <td>{{$hierarchy->level_name}}</td>
                                                    <td>
                                                        <a href="javascript:void(0);"><strong>{{$result->email}}</strong></a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{ url('/superadmin/edit-organisation/'.$result->id ) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <!-- <a href="{{ url('/superadmin/delete-organisation/'.$result->id ) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> -->
                                                            <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markorganisationdelete" data-id="{{$result->id}}" data-toggle="modal" data-target="#markdelete" title="Delete Organisation" data-placement="right" ><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete Organisation -->
<div class="modal fade" id="markdelete" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete Organisation</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this Organisation?                                    
         </div>
         <form class="form" method="POST" id="organisationdelete" action="{{ url('/superadmin/delete-organisation/') }}">
            @csrf
            <input type="hidden" name="organisation_id" id="deleteorganisation" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 organisationdelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection
@section('page_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.organisations_list').DataTable();
    } );
</script>
@endsection
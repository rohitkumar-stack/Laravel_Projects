@extends('layouts.admin_layout')
@section('title', 'Department List - Enthucate')
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
                        <h4 class="card-title">Department</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">
                                <table id="example3" class="display table-responsive-lg dataTable no-footer departments_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Department: activate to sort column ascending">Description</th>
                                           <!--  <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Members: activate to sort column ascending">Members</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Message: activate to sort column ascending">Message Create Members</th> -->
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Action: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
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
<div class="modal fade" id="deleteschool" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete Department</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this Department?                                    
         </div>
         <form class="form" method="POST" id="schooldelete" action="{{ url(Auth::User()->organisation_url.'/admin/delete-department/') }}">
            @csrf
            <input type="hidden" name="department_id" id="school_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 schooldelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- lisr Organisation -->
<div class="modal fade" id="viewdepartement" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Member List</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0 memberlist">                                
         </div>
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <!-- <button type="submit" class="btn btn-primary btn-rounded mb-2 schooldelete">Delete</button> -->
            </div>
      </div>
   </div>
</div>
@endsection
@section('page_script')
<script type="text/javascript">
    var searchorderTable;
    jQuery(document).ready(function() {
      // searchorderTable= $("#sample_2").DataTable(); 
      var organisation = '';
      load_departmentlist(organisation);
    });
    function load_departmentlist(organisation){
        siteurl = jQuery('#siteurl').val();
        var organisation_url = '<?php echo Auth::User()->organisation_url ; ?>';
        searchorderTable = jQuery('.departments_list').DataTable({
        info: true,
        cache: false,
        destroy: true,
        pageLength: 10,
        searching: true,
        serverSide: true,
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
          url : siteurl+"/"+organisation_url+"/admin/departmentlist" ,
          type: "post",
          dataType: "json",
          data: function (d) {
                d.organisation = organisation;
                d._token = $("#csrftoken").val();
            },
          dataFilter: function (response) {
            return response;
          },
        },
        columns: [
          { orderable: false, data: "orderno" },
          { orderable: false, data: "department_name" },
          { orderable: false, data: "description" },
          { orderable: false, data: "action" },
        ],
      });
    }

// $(document).on('change','#org_fillter_organisation_id',function(){  
//    var organisation = jQuery(this).val();
//   load_departmentlist(organisation);
// });
</script>
@endsection
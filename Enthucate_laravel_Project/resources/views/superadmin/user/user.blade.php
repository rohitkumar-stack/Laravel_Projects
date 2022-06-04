@extends('layouts.superadmin_layout')
@section('title', 'User List - Enthucate')
@section('content')
<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users</h4>
                        <div class="form-group select_org_fillter">
                            <select class="form-control org_fillter_organisation_id" name="organisation" id="org_fillter_organisation_id">
                                <option value="">Select Organisation</option> 
                                @if(!empty($organisations))
                                    @foreach($organisations as $organisation)
                                        <option value="{{$organisation->id}}">{{$organisation->organisation_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">
                              
                                <table id="example3" class="display table-responsive-lg dataTable no-footer user_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Role: activate to sort column ascending">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Status: activate to sort column ascending">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Email: activate to sort column ascending">Email</th>

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
<div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete user</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this user?                                    
         </div>
         <form class="form" method="POST" id="userdelete" action="{{ url('/superadmin/delete-user/') }}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 userdelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('page_script')
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.user_list').DataTable();
    // } );

     var searchorderTable;
    jQuery(document).ready(function() {
      // searchorderTable= $("#sample_2").DataTable(); 
      var organisation = '';
      load_userlist(organisation);
    });
    function load_userlist(organisation){
        siteurl = jQuery('#siteurl').val();
        searchorderTable = jQuery('.user_list').DataTable({
        info: true,
        cache: false,
        destroy: true,
        pageLength: 10,
        searching: true,
        serverSide: true,
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
          url : siteurl+"/superadmin/userlist" ,
          type: "get",
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
          { orderable: false, data: "name" },
          { orderable: false, data: "role" },
          { orderable: false, data: "status" },
          { orderable: false, data: "email" },
          { orderable: false, data: "action" },
        ],
      });
    }

$(document).on('change','#org_fillter_organisation_id',function(){  
   var organisation = jQuery(this).val();
  load_userlist(organisation);
});
</script>
@endsection
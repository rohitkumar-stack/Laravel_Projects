@extends('layouts.admin_layout')
@section('title', 'School List - Enthucate')
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
                        <h4 class="card-title">Schools</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">
                              <table id="example3" class="display table-responsive-lg dataTable no-footer school_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">School Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Group: activate to sort column ascending">Address</th>
                                            <!-- <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Members: activate to sort column ascending">Principal Name</th> -->
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Message: activate to sort column ascending">Contact No.</th>
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
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete School</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this School?                                    
         </div>
         <form class="form" method="POST" id="schooldelete" action="{{ url(Auth::User()->organisation_url.'/admin/delete-school/') }}">
            @csrf
            <input type="hidden" name="school_id" id="school_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 schooldelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('page_script')
<script type="text/javascript">
    var searchorderTable;
    jQuery(document).ready(function() {
      var organisation = '';
      load_departmentlist(organisation);
    });
    function load_departmentlist(organisation){
        siteurl = jQuery('#siteurl').val();
        var organisation_url = '<?php echo Auth::User()->organisation_url ; ?>';
        searchorderTable = jQuery('.school_list').DataTable({
        info: true,
        cache: false,
        destroy: true,
        pageLength: 10,
        searching: true,
        serverSide: true,
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
          url : siteurl+"/"+organisation_url+"/admin/schoollist" ,
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
          { orderable: false, data: "school_name" },
          //{ orderable: false, data: "organisation_name" },
          { orderable: false, data: "address" },
          { orderable: false, data: "school_phone" },
          { orderable: false, data: "action" },
        ],
      });
    }


</script>
@endsection
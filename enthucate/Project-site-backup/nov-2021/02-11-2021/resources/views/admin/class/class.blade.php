@extends('layouts.admin_layout')
@section('title', 'Class List - Enthucate')
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
                        <h4 class="card-title">Classs</h4>
                        <div class="col-sm-4">
                           <div class="form-group">
                           <select class="form-control selectschoolvalue" id="selectschoolvalue" name="school">
                                <option value="">Select School</option>
                                @if(!empty($schools))
                                      @foreach($schools as $school)
                                          <option value="{{$school->id}}">{{$school->school_name}}</option>
                                      @endforeach
                                  @endif
                              </select>
                           </div>
                        </div>
                         <div class="col-sm-4 selectgrade">
                            <div class="form-group">
                                <select class="form-control selectgradevalue" id="selectgradevalue" name="grade">
                                <option value="">Select Grade</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                          <button type="button" class="btn btn-primary btn-rounded mb-2 searchgrade">Search</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">
                                <table id="example3" class="display table-responsive-lg dataTable no-footer class_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">School</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Grade</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Group: activate to sort column ascending">Class</th>
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
<div class="modal fade" id="deleteclass" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete class</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this class?                                    
         </div>
         <form class="form" method="POST" id="classdelete" action="{{ url(Auth::User()->organisation_url.'/admin/delete-class/') }}">
            @csrf
            <input type="hidden" name="class_id" id="class_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 classdelete">Delete</button>
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
      // searchorderTable= $("#sample_2").DataTable(); 
      var organisation = '';
      var school = '';
      var grade = '';
      load_departmentlist(organisation,school,grade);
    });
    function load_departmentlist(organisation,school,grade){
        siteurl = jQuery('#siteurl').val();
        var organisation_url = '<?php echo Auth::User()->organisation_url ; ?>';
        searchorderTable = jQuery('.class_list').DataTable({
        info: true,
        cache: false,
        destroy: true,
        pageLength: 10,
        searching: true,
        serverSide: true,
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
          url : siteurl+"/"+organisation_url+"/admin/classlist" ,
          type: "get",
          dataType: "json",
          data: function (d) {
                d.organisation = organisation;
                d.schools = school;
                d.grades = grade;
                d._token = $("#csrftoken").val();
            },
          dataFilter: function (response) {
            return response;
          },
        },
        columns: [
          { orderable: false, data: "orderno" },
          //{ orderable: false, data: "organisation_name" },
          { orderable: false, data: "school" },
          { orderable: false, data: "grade" },
          { orderable: false, data: "class_name" },
          { orderable: false, data: "action" },
        ],
      });
    }

$(document).on('click','.searchgrade',function(){  
   var organisation = jQuery('#seleorganisationid').val();
   var school = jQuery('#selectschoolvalue').val();
    var grade = jQuery('#selectgradevalue').val();
   // alert(organisation+'==='+school);
  load_departmentlist(organisation,school,grade);
});
</script>@endsection
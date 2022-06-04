@extends('layouts.admin_layout') @section('title', 'Message Add - Enthucate') @section('content')
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
                        <div class="card profile-card">
                            <div class="card-header flex-wrap border-0 pb-0">
                                <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Messages</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link @if (old('message_type') != 'group' && old('message_type') != 'school') active @endif" data-toggle="tab" href="#home1" id="departments_tab"><i class="fa fa-building mr-2"></i>Departments</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if (old('message_type') == 'group') active @endif" data-toggle="tab" href="#profile1" id="groups_tab"><i class="fa fa-users mr-2"></i> Groups</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if (old('message_type') == 'school') active @endif" data-toggle="tab" href="#contact1" id="schools_tab"><i class="fa fa-university mr-2"></i> Schools</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade @if (old('message_type') != 'group' && old('message_type') != 'school') show active @endif " id="home1" role="tabpanel">
                                                <div class="pt-4">
                                                     <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/save-message' ) }}" enctype="multipart/form-data" autocomplete="off">
                                                     @csrf
                                                     <input type="hidden" name="organisation" value="{{Auth::User()->organisation_id}}">
                                                    <input type="hidden" name="message_type" value="department">

                                                        <div class="row">
                                                            
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select Department <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select name="department[]" class="form-control selectdepartmentvalue" id="selectdepartmentvalue" tabindex="-98"> 
                                                                        <option value="">Select Department</option>
                                                                        @if(!empty($departments)) @foreach($departments as $department)
                                                                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                                                                        @endforeach @endif
                                                                        </select>
                                                                    <!-- </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="{{ old('subject') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        @if(!empty($messagecategory)) @foreach($messagecategory as $category)
                                                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                                                        @endforeach @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                     <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message">{{ old('message') }}</textarea>
                                                                </div>
                                                            </div>
                                                             <div id="insert_image_001" class="insert_image_value insert_image_value_001 col-sm-12 mb-2"></div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="001" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if (old('message_type') == 'group') show active @endif" id="profile1">
                                                <div class="pt-4">
                                                     <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/save-message' ) }}" enctype="multipart/form-data" autocomplete="off">
                                                     @csrf
                                                     <input type="hidden" name="organisation" value="{{Auth::User()->organisation_id}}">
                                                    <input type="hidden" name="message_type" value="group">                                                    
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select Group <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select  name="group[]" class="form-control selectgroupvalue" id="selectgroupvalue" tabindex="-98"> 
                                                                        <option value="">Select Group</option>
                                                                        @if(!empty($groups)) @foreach($groups as $group)
                                                                        <option value="{{$group->id}}">{{$group->group_name}}</option>
                                                                        @endforeach @endif
                                                                        </select>
                                                                    <!-- </div> -->
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="{{ old('subject') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        @if(!empty($messagecategory)) @foreach($messagecategory as $category)
                                                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                                                        @endforeach @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                     <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message">{{ old('message') }}</textarea>
                                                                </div>
                                                            </div>
                                                             <div id="insert_image_002" class="insert_image_value insert_image_value_002 col-sm-12 mb-2"></div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="002" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if (old('message_type') == 'school') show active @endif" id="contact1">
                                                <div class="pt-4">
                                                     <form method="POST" action="{{ url(Auth::User()->organisation_url.'/admin/save-message' ) }}" enctype="multipart/form-data" autocomplete="off">
                                                     @csrf
                                                     <input type="hidden" name="organisation" value="{{Auth::User()->organisation_id}}">
                                                        <input type="hidden" name="message_type" value="school">
                                                        <div class="row">
                                                        
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select School <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select class="form-control selectschoolvalue" name="school[]" id="selectschoolvalue" tabindex="-98"> 
                                                                        <option value="">Select School</option>
                                                                        @if(!empty($schools)) @foreach($schools as $school)
                                                                        <option value="{{$school->id}}">{{$school->school_name}}</option>
                                                                        @endforeach @endif
                                                                        </select>
                                                                    <!-- </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="{{ old('subject') }}" />
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Filters <span class="requried">*</span></label>
                                                                    <select class="form-control" name="filters" id="">
                                                                        <option value="">Select Filters</option>
                                                                        <option value="1">All School</option>
                                                                        <option value="2">Grades</option>
                                                                        <option value="3">Classes(Subset of grades)</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                            <div class="col-sm-12 mb-4">
                                                                <label style="width: 100%;">Recipients <span class="requried">*</span></label>
                                                                <div class="row">           
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add_all"  id="customCheckBox41" name="recipientsall" value="9,10,11" />
                                                                    <label class="custom-control-label" for="customCheckBox41">All</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41t" name="recipients[]" value="9"/>
                                                                    <label class="custom-control-label" for="customCheckBox41t">Teachers</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41s" name="recipients[]" value="10"/>
                                                                    <label class="custom-control-label" for="customCheckBox41s">Students</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41p" name="recipients[]" value="11"/>
                                                                    <label class="custom-control-label" for="customCheckBox41p">Parents</label>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        @if(!empty($messagecategory)) @foreach($messagecategory as $category)
                                                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                                                        @endforeach @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                     <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message">{{ old('message') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div id="insert_image_003" class="insert_image_value insert_image_value_003 col-sm-12 mb-2"></div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="003" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('page_script')
<script type="text/javascript">
    jQuery(document).on("click", "#departments_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });
    jQuery(document).on("click", "#groups_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });
    jQuery(document).on("click", "#schools_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });

$('.school_add_all').on('click',function(){
    if($('input[name=recipientsall]').is(':checked')){
      $('.school_add').prop('checked',true);
    }else{
      $('.school_add').prop('checked',false);       
    }
});
</script>
@endsection

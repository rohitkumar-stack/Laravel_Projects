@extends('layouts.superadmin_layout') @section('title', 'Message List - Enthucate') @section('content')
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
                                <select>
                                    <option>All Messages (100)</option>
                                    <option value="Inbox">Inbox</option>
                                    <option value="Outbox">Outbox</option>
                                </select>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group message_left_side">
                                             <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    <!-- <a href="#">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a> -->
                                                   
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                   
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                   
                                                </div>
                                            </div>
                                            <div class="main d-flex align-items-center">
                                                <div class="inner">
                                                    <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                </div>
                                                <div class="inner1">
                                                    <a href="#">
                                                        <h4>Eljah Mahalnaga Communication</h4>
                                                    </a>
                                                    <p>How many products do you recom....</p>
                                                </div>
                                                <div class="inner2">
                                                    <span>2:00 PM</span>
                                                    
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                              <div class="msg-right">
                                                <h2>Eljah Mahalnaga Communication</h2>
                                                <div class="msg-box d-flex">
                                                    <div class="inner">
                                                        <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                    </div>
                                                    <div class="inner1">
                                                        <p>How many products do you recom, how many products do you recom, how many products do you recom....</p>
                                                        <span>2:00 PM</span>
                                                    </div>
                                                </div>
                                                <div class="msg-box box-rgt d-flex">
                                                    <div class="inner1">
                                                        <p>How many products do you recom, how many products do you recom, how many products do you recom....</p>
                                                        <span>2:00 PM</span>
                                                    </div>
                                                    <div class="inner">
                                                        <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                    </div>
                                                </div>
                                                <div class="msg-box d-flex">
                                                    <div class="inner">
                                                        <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                    </div>
                                                    <div class="inner1">
                                                        <p>How many products do you recom, how many products do you recom, how many products do you recom....</p>
                                                        <span>2:00 PM</span>
                                                    </div>
                                                </div>
                                                <div class="msg-box box-rgt d-flex">
                                                    <div class="inner1">
                                                        <p>How many products do you recom, how many products do you recom, how many products do you recom....</p>
                                                        <span>2:00 PM</span>
                                                    </div>
                                                    <div class="inner">
                                                        <img src="{{ asset('public/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt=""/>
                                                    </div>
                                                </div>

                                                <div class="chat-msg">
                                                    <form action="">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Message <span class="requried">*</span></label>
                                                                <textarea class="form-control" rows="4" id="message" name="message">{{ old('message') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div id="insert_image" class="insert_image_value insert_image_value_001 col-sm-12 mb-2"></div>
                                                        <div class="row m-2">
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
                                                                <!-- <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button> -->
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
</div>
@endsection @section('page_script')

@endsection

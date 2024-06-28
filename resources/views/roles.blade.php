@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="mb-4">Roles List</h4>

             
              <!-- Role cards -->
              <div class="row g-4">
                <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="card ">
                    <div class="row ">
                      <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                          <img
                            src="{{asset('app-assets/images/add-new-roles.png')}}"
                            class="img-fluid mt-sm-4 mt-md-0"
                            alt="add-new-roles"
                            width="83" />
                        </div>
                      </div>
                      <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                          <button
                            href="{{url('permission')}}"
                            class="btn btn-primary mb-2 text-nowrap add-new-role">
                            Add New Role
                          </button>
                          <p class="mb-0 mt-1">Add role, if it does not exist</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
                
                <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <h6 class="fw-normal mb-2">Total 2 users</h6>
                        <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Vinnie Mostowy" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="{{asset('app-assets/images/portrait/small/avatar-s-5.jpg')}}" alt="Avatar" height="30" width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Elicia Rieske" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="{{asset('app-assets/images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30" width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Julee Rossignol" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="{{asset('app-assets/images/portrait/small/avatar-s-10.jpg')}}" alt="Avatar" height="30" width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Darcey Nooner" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="{{asset('app-assets/images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar" height="30" width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Elicia Rieske" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="{{asset('app-assets/images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30" width="30">
                            </li>
                            <li class="d-inline-block pl-50">
                                <span>+264 more</span>
                            </li>
                        </ul>
                      </div>
                        <div class="mt-1"  style="margin-top: 1.4rem !important;">
                            <div class="role-heading">
                            <div class="d-flex"  style="justify-content: space-between;">
                                <h4 class="mb-1">Restricted User</h4>
                                <h4 class="mb-1">Total Permission</h4>
                            </div>
                            <div class="d-flex"  style="justify-content: space-between;">
                            <a
                               href="{{url('permission')}}"
                                class="role-edit-modal"
                                ><span>Edit Role</span></a
                            >
                            <a
                                hrefavascript:;"
                                data-toggle="modal"
                                data-target="#addRoleModal"
                                class="role-edit-modal"
                                ><span>0</span></a
                            >
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
    <!-- END: Content-->
@endsection


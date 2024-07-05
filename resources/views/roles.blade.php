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
                          <a
                            href="{{url('permission')}}"
                            class="btn btn-primary mb-2 text-nowrap add-new-role">
                            Add New Role
                          </a>
                          <p class="mb-0 mt-1">Add role, if it does not exist</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
                @foreach($get_role as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <h4 class="fw-normal">{{$role->name}}</h6>
                        <a href="{{url('edit-permission/' .$role->_id)}}" class="role-edit-modal"><span>Edit Role</span></a>
                        
                      </div>
                      <div class=""  style="margin-top: 1.4rem !important;">
                          <div class="role-heading">
                            <div class="d-flex"  style="justify-content: space-between;">
                                
                                <h4 class="mb-1">Total Permission</h4>
                                <h6 class="mb-1">{{$role->permissions->count()}}</h6>
                            </div>
                            <div class="d-flex"  style="justify-content: space-between;">
                                
                                <h4 class="mb-1">Total Assign User</h4>
                                <h6 class="mb-1">{{$role->RoleUser->count()}}</h6>
                            </div>
                         
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                
              
              </div>
            
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection


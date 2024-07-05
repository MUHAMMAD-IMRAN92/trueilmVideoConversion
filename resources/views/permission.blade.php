@extends('layouts.default_layout')

@section('content')

<style>

.child-row td{
    padding-left: 5%;

}


</style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="mb-4">Role &  Permissions</h4>

             
              <!-- Role cards -->
              <div class="row g-4">
                <div class="col-xl-12">
                  <div class="card p-3 p-md-5">
                    <form id="" class="row g-3"  method="post" action="{{url('role-save')}}">
                    @csrf  
                    <div class="col-12 mb-4">
                      <label class="form-label" for="modalRoleName">Role Name</label>
                      <input
                          type="text"
                          id="modalRoleName"
                          name="roleName"
                          class="form-control"
                          placeholder="Enter a role name"
                          tabindex="-1" 
                          required  
                        />
                      </div>
                      <div class="col-12">
                      <h5>Role Permissions</h5>
                      <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Administrator Access
                                        
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="Administrator-checkbox1" class="select_administrator custom-control-input"  data-type="alquran">
                                                <label class="custom-control-label" for="Administrator-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>

                                    @foreach($permission as $key=>$rows)
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            {{$key}}
                                           
                                        </td>
                                        <td>

                                            @php 
                                            $spacelesskey = str_replace(' ', '', $key);

                                            @endphp
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="al-quran-checkbox{{$spacelesskey}}" class="select_all custom-control-input"  data-type="{{$spacelesskey}}">
                                                <label class="custom-control-label" for="al-quran-checkbox{{$spacelesskey}}">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                        @foreach($rows as $keys=>$row)
                                        <tr class="child-row">
                                            <td class="text-nowrap fw-medium">{{$keys}}</td>
                                            <td>
                                                <div class="" style="display: flex;flex-wrap: wrap;">



                                                
                                                @foreach($row as $row)
                                                    <div class="custom-control mr-3 custom-checkbox" style="width: 25%;">
                                                        <input type="checkbox" id="translation-author-checkbox{{$row}}" name="{{$row}}" class="custom-control-input {{$spacelesskey}}_checkAll checkAll" >
                                                        <label class="custom-control-label" for="translation-author-checkbox{{$row}}">{{$row}}</label>
                                                    </div>
                                                @endforeach    
                                                    
                                                
                                                
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    
                                    
                              
                             
                                </tbody>
                            </table>
                        </div>
                      <!-- Permission table -->
                      </div>
                      <div class="col-12 text-right  mt-4">
                      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                      <button
                          type="reset"
                          class="btn btn-label-secondary"
                          data-dismiss="modal"
                          aria-label="Close">
                          Cancel
                      </button>
                      </div>
                  </form>
                    
                  </div>
                </div>
               
                
              
              
              </div>
            
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection


@section('js')
<script>
   
    $(document).ready(function() {

            $('.select_all').click(function() {

                let type=$(this).attr('data-type');

                if($(this).is(':checked')){
                    $('.'+type+'_checkAll').prop('checked',true );
                }
                else{
                    $('.'+type+'_checkAll').prop('checked',false );

                }
            });
            $('.select_administrator').click(function() {
                if($(this).is(':checked')){
                    $('.select_all').prop('checked',true );
                    $('.checkAll').prop('checked',true );
                    

                }
                else{
                   $('.select_all').prop('checked',false );
                   $('.checkAll').prop('checked',false );
                 


                }

            });


    });

</script>    
@endsection


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
                          tabindex="-1" />
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
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Al Quran
                                           
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="al-quran-checkbox1" class="select_all custom-control-input"  data-type="alquran">
                                                <label class="custom-control-label" for="al-quran-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Translations Author</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Surah Tafseers</td>
                                        <td>
                                            <div class="d-flex">
                                                

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Surah Translations</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Language</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox1" name="language-view" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox1">View</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox2" name="language-create" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox3" name="language-update" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Hadith
                                            
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="hadith-checkbox1" class="select_all custom-control-input"  data-type="hadith"  >
                                                <label class="custom-control-label" for="hadith-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Hadith  Translations</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox1" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox2" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox3" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Hadith Tafseer</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox1" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox2" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox3" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Content
                                            
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="Content-checkbox1" class="select_all custom-control-input"  data-type="content" >
                                                <label class="custom-control-label" for="Content-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Category</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">eBooks</td>
                                        <td>
                                            <div class="d-flex">
                                            
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox1">View</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox3">Edit</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox3">Enable/Disable</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Audio Books</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Papers</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Podcast</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Courses</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Publishers</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Author</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                              
                             
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
                    $('.content_checkAll').prop('checked',true );
                    $('.hadith_checkAll').prop('checked',true );
                    $('.alquran_checkAll').prop('checked',true );

                }
                else{
                   $('.select_all').prop('checked',false );
                   $('.content_checkAll').prop('checked',false );
                   $('.hadith_checkAll').prop('checked',false );
                   $('.alquran_checkAll').prop('checked',false );


                }

            });


    });

</script>    
@endsection

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
                          tabindex="-1" />
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
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Al Quran
                                           
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="al-quran-checkbox1" class="select_all custom-control-input"  data-type="alquran">
                                                <label class="custom-control-label" for="al-quran-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Translations Author</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="translation-author-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="translation-author-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Surah Tafseers</td>
                                        <td>
                                            <div class="d-flex">
                                                

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-tafseers-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-tafseers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Surah Translations</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox1" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox2" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="surah-translations-checkbox3" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="surah-translations-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Language</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox1" name="language-view" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox1">View</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox2" name="language-create" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="language-checkbox3" name="language-update" class="custom-control-input alquran_checkAll" >
                                                    <label class="custom-control-label" for="language-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Hadith
                                            
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="hadith-checkbox1" class="select_all custom-control-input"  data-type="hadith"  >
                                                <label class="custom-control-label" for="hadith-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Hadith  Translations</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox1" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox2" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-translation-checkbox3" class="hadith_checkAll custom-control-input hadith_checkAll" >
                                                    <label class="custom-control-label" for="hadith-translation-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Hadith Tafseer</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox1" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox2" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="hadith-tafseer-checkbox3" class="hadith_checkAll custom-control-input">
                                                    <label class="custom-control-label" for="hadith-tafseer-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                            Content
                                            
                                        </td>
                                        <td>
                                            <div class="custom-control mr-3 custom-checkbox">
                                                <input type="checkbox" id="Content-checkbox1" class="select_all custom-control-input"  data-type="content" >
                                                <label class="custom-control-label" for="Content-checkbox1">Select All</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Category</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="category-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="category-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">eBooks</td>
                                        <td>
                                            <div class="d-flex">
                                            
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox1">View</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox3">Edit</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="eBooks-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="eBooks-checkbox3">Enable/Disable</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Audio Books</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="audio-books-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="audio-books-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Papers</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="papers-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="papers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Podcast</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="podcast-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="podcast-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Courses</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="courses-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="courses-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Publishers</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="publishers-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="publishers-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row">
                                        <td class="text-nowrap fw-medium">Author</td>
                                        <td>
                                            <div class="d-flex">
                                            

                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox1" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox1">Read</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox2" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox2">Create</label>
                                                </div>
                                                <div class="custom-control mr-3 custom-checkbox">
                                                    <input type="checkbox" id="author-checkbox3" class="custom-control-input content_checkAll">
                                                    <label class="custom-control-label" for="author-checkbox3">Edit</label>
                                                </div>
                                            
                                            
                                            </div>
                                        </td>
                                    </tr>
                              
                             
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
                    $('.content_checkAll').prop('checked',true );
                    $('.hadith_checkAll').prop('checked',true );
                    $('.alquran_checkAll').prop('checked',true );

                }
                else{
                   $('.select_all').prop('checked',false );
                   $('.content_checkAll').prop('checked',false );
                   $('.hadith_checkAll').prop('checked',false );
                   $('.alquran_checkAll').prop('checked',false );


                }

            });


    });

</script>    
@endsection


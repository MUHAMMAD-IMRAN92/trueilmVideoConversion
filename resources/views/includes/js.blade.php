   <!-- BEGIN: Vendor JS-->
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
   <!-- BEGIN Vendor JS-->

   <!-- BEGIN: Page Vendor JS-->
   <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/extensions/tether.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/extensions/shepherd.min.js') }}"></script>
   <!-- END: Page Vendor JS-->

   <!-- BEGIN: Theme JS-->
   <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
   <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>
   <!-- END: Theme JS-->

   <!-- BEGIN: Page JS-->
   <script src="{{ asset('app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
   <!-- END: Page JS-->
   <script src="{{ asset('app-assets/js/scripts/datatables/datatable.js') }}"></script>

   <!-- BEGIN: Page Vendor JS-->

   <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.select.min.j') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
   <!-- BEGIN: Page Vendor JS-->
   <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>

   <!-- END: Page Vendor JS-->
   <!-- BEGIN: Page JS-->
   <script src="{{ asset('app-assets/js/scripts/ui/data-list-view.js') }}"></script>
   {{-- <script src="{{ asset('app-assets/vendors/js/charts/echarts/echarts.min.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/charts/chart-echart.js') }}"></script> --}}
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

   <!-- END: Page JS-->
   <script>
       $(document).ready(function() {

           $('.summernote').summernote({
               height: 150,
               codemirror: {
                   theme: 'default'
               }
           });

           $('#ayat-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-surah') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.surah + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = "";
                           if (row.description != null) {
                               des = row.description.slice(0, 300);
                           }

                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var type;
                           if (row.type == 1) {
                               type = 'Makki Surah';
                           } else {
                               type = 'Madni Surah';
                           }
                           return '<td>' +
                               type + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('surah/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#publisher-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-publisher') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description;
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('publisher/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#ebook-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-book') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description;
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.cover}
                               /></td>`
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var author = '';
                           if (row.author != null) {
                               author = row.author;
                           } else {
                               author = '--'
                           }
                           return '<td>' +
                               author + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var type = '';
                           if (row.type == 1) {
                               type = 'eBook';
                           }
                           if (row.type == 2) {
                               type = 'Audio Book';
                           }
                           if (row.type == 3) {
                               type = 'Research Paper';
                           }
                           return '<td>' +
                               type +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var approved = '';
                           if (row.approved == 0) {
                               approved = 'Pending For Approval';
                           }
                           if (row.approved == 2) {
                               approved = 'Rejected';
                           }
                           if (row.approved == 1) {
                               approved = 'Approved';
                           }
                           return '<td>' +
                               approved +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var user_name = '';
                           if (row.user_name != null) {
                               user_name = row.user_name;
                           } else {
                               user_name = '--'
                           }
                           return '<td>' +
                               user_name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var eye = 'feather icon-eye';
                           if (row.status == 0) {
                               eye = 'feather icon-eye-off';
                           }
                           return `<td>
                                <a  class="ml-2" href="{{ url('book/`+ row.type +`/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                <a  class="ml-2" href="{{ url('book/update-status/`+row._id+`') }}"><i class="` +
                               eye + `"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#hadees-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-hadith-books') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('hadith/book/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#user-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-user') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return '<td>' +
                               row.email +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.phone + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var type;
                           if (row.type == 1) {
                               type = 'Admin';
                           } else if (row.type == 2) {
                               type = 'Publisher';
                           } else {
                               type = 'Institute';
                           }
                           return '<td>' +
                               type + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('user/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                <a  class="ml-2" href="{{ url('user/delete/`+row._id+`') }}"><i class="fa fa-trash"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#category-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-category') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description;
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var eye = 'feather icon-eye';
                           if (row.status == 0) {
                               eye = 'feather icon-eye-off';
                           }
                           return `<td>
                                <a  class="ml-2" href="{{ url('category/`+row.type+`/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                <a  class="ml-2" href="{{ url('category/update-status/`+row._id+`') }}"><i class="` +
                               eye + `"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#pending-book-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-pending-book') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description;
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.cover}
                               /></td>`
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var author = '';
                           if (row.author != null) {
                               author = row.author;
                           } else {
                               author = '--'
                           }
                           return '<td>' +
                               author + '</td>'

                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var type = '';
                           if (row.type == 1) {
                               type = 'eBook';
                           }
                           if (row.type == 2) {
                               type = 'Audio Book';
                           }
                           if (row.type == 3) {
                               type = 'Research Paper';
                           }
                           return '<td>' +
                               type +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var user_name = '';
                           if (row.user_name != null) {
                               user_name = row.user_name;
                           } else {
                               user_name = '--'
                           }
                           return '<td>' +
                               user_name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return `<td>
                                <a  class="ml-2" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                                <a  class="ml-2" href="{{ url('book/reject/`+row._id+`') }}"><i class="fa fa-times" style="font-size:24px"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#courses-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-courses') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description;
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var eye = 'feather icon-eye';
                           if (row.status == 0) {
                               eye = 'feather icon-eye-off';
                           }
                           return `<td>
                                <a  class="ml-2" href="{{ url('course/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                <a  class="ml-2" href="{{ url('course/update-status/`+row._id+`') }}"><i class="` +
                               eye + `"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#add-translation').on('click', function() {
               var html;
               html = ` <div class="col-12">
                    <div class="card" >
                    <div class="card-body">
                            <p>Language</p>
                            <fieldset class="form-group">
                                <select class="form-control" name="langs[]" id="basicSelect">
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                    <option value="ur">Urud</option>
                                    <option value="hi">Hindi</option>
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Translation</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" name="translations[]"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>`;

               $('.append-inputs').append(html);
               $('.summernote').summernote();
           });
           $('#add-reference').on('click', function() {
               var html;
               html =
                   `<div class="col-12">

                        <p>Reference</p>
                        <fieldset class="form-group">
                            <select class="form-control" name="reference_book[]" id="basicSelect">
                                <option value="1">Sahih ul Bukhari</option>
                                <option value="2">Al Sahih Li Muslim</option>
                                <option value="3">Jame ut Tirmezi</option>
                                <option value="4">Sunan e Abi Dawood</option>
                                <option value="5">Sunan e Nasa</option>
                                <option value="6">Sunan e Ibn-e-Maja</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-12">
                            <label for="">Reference #</label>
                            <input type="number" id="" class="form-control" name="ref_number[]" placeholder="" >
                    </div>`;

               $('.append-inputs').append(html);
               $('.summernote').summernote();
           });
           $('#add-lesson').on('click', function() {
               $('#lesson-heading').css('display', 'block')
               var lenght = $('.custom-file-input').length;
               var html;
               html =
                   `<div class="col-6">
                            <label for="">Lesson Title</label>
                            <input type="text" id=""  class="form-control" name="lessons[]" placeholder="" >
                    </div>
                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Video</label>
                                                            <div class="custom-file">
                                                                <input type="file"  class="custom-file-input"
                                                                  id="file-upload-input" name="videos[]" accept="video/*"
                                                                  onchange="fileSelect(event,${lenght})">
                                                                <label class="custom-file-label" id="label-${lenght}"
                                                                    for="">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div><div class="col-12">
                            <label for="">Description</label>
                            <fieldset class="form-group">
                                <textarea class="summernote" name="descriptions[]"></textarea>
                            </fieldset>
                     </div>`;

               $('.append-inputs').append(html);
               $('.summernote').summernote();
           });

           $('#add-tafseer').on('click', function() {
               $('.no-tafseer-div').css('display', 'none');

               var html;
               html = ` <div class="col-12">
                    <div class="card" >
                    <div class="card-body">
                            <p>Language</p>
                            <fieldset class="form-group">
                                <select class="form-control" name="taf_langs[]" id="basicSelect">
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                    <option value="ur">Urud</option>
                                    <option value="hi">Hindi</option>
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Translation</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" name="tafseers[]"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>`;

               $('.tafseer-append-inputs').append(html);
               $('.summernote').summernote();
           });
           $('#add-ayat').on('click', function() {
               $('#add-ayat-div').css('display', 'block')
               $('.card-height ').css('height', '600px')
               $('#no-ayat-added-div').css('display', 'none')
           });
           $('#disable-btn-submit').on('submit', function() {
               $('#submit-btn').prop('disabled', 'true');
           });



       });

       function fileSelect(e, l) {
           console.log(e.target.files[0].name);
           $('#label-' + l).text(e.target.files[0].name);
       }


       // Ayat Translation
       function deleteTranslation(ayatId, tranId, key) {
           $('.translation-div-' + key).remove();

           $.ajax({
               type: "GET",
               url: "{{ url('ayat/translation/delete') }}",
               data: {
                   ayatId: ayatId,
                   transId: tranId,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
               },
           });
           var div = $('.lang');
           if (div.length == 0) {
               $('#no-translation-div').css('display', 'block');
           }

       }

       function editable(key) {
           $('#non-editble-translation-' + key).css('display', 'none');
           $('#editble-' + key).css('display', 'block');
       }

       function saveTranslation(ayatId, tranId, key) {
           var lang = $('#lang-select-' + key).val();
           var translation = $('#trans-input-' + key).val();
           $.ajax({
               type: "GET",
               url: "{{ url('ayat/translation/update') }}",
               data: {
                   ayatId: ayatId,
                   transId: tranId,
                   lang: lang,
                   translation: translation,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('#translation-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#translation-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   $('#non-edit-lang-select-' + key).html(response.lang);
                   $('#trans-input-' + key).val(response.translation);
                   $('#non-edit-para-des-' + key).html(response.translation);
                   $('#editble-' + key).css('display', 'none');
                   $('#non-editble-translation-' + key).css('display', 'block');
               }
           });
       }

       function addTranslation(ayatId) {
           $('#no-translation-div').css('display', 'none');
           var div = $('.lang');
           var lang = div.length;
           var html;
           html = `

                        <div class="col-12 lang translation-div-${lang}">

                                    <div class="card" >
                                    <div class="card-body">
                                        <div class="row">
                            <div class="col-8 ">
                                <h4 id="translation-saved-span-${lang }"
                                    style="display:none"> <span
                                        class="badge badge-success "><i
                                            class="fa fa-check">Translation
                                            Saved</i></span></h4>
                            </div>
                            <div class="col-4 d-flex">

                                <h4
                                    onclick="saveNewTranslation('${ayatId}','${lang }')">
                                    <span class="badge badge-success ml-1"><i
                                            class="fa fa-save">&nbspSave</i></span>
                                </h4>
                                <h4
                                    onclick="deleteNewTranslation('${lang }')">
                                    <span class="badge badge-danger ml-1"><i
                                            class="fa fa-trash">&nbspDelete</i></span>
                                </h4>
                            </div>
                        </div>
                            <p>Language</p>
                            <fieldset class="form-group">
                                <select class="form-control" name="langs[]" id="new-lang-select-${lang}">
                                    <option value="" selected>Please Select Language</option>
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                    <option value="ur">Urud</option>
                                    <option value="hi">Hindi</option>
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Translation</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" name="translations[]" id="new-description-${lang}"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>

                </div>
                `;

           $('.append-inputs').append(html);
           $('.summernote').summernote();
       }

       function deleteNewTranslation(key) {
           $('.translation-div-' + key).remove();
           var div = $('.lang');
           console.log(div.length);
           if (div.length == 0) {
               $('#no-translation-div').css('display', 'block');
           }
       }

       function saveNewTranslation(ayatId, key) {
           var lang = $('#new-lang-select-' + key).val();
           var translation = $('#new-description-' + key).val();
           $.ajax({
               type: "GET",
               url: "{{ url('ayat/translation/save') }}",
               data: {
                   ayatId: ayatId,
                   lang: lang,
                   translation: translation,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('.translation-div-' + key).remove();

                   var html;
                   html = `<div class="col-12 lang translation-div-${key }">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-8 ">

                                                                    <h4 id="translation-saved-span-${key }"
                                                                        style=""> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Translation
                                                                                Saved</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editable('${ key }')"><span
                                                                            class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTranslation('${response.ayat_id}','${response._id}','${key }')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTranslation('${response.ayat_id}','${response._id}','${key }')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-${key}">

                                                                <p>Language :
                                                                    <b id="non-edit-lang-select-${ key }">${response.lang }
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-${ key }"
                                                                        style="margin-left:10px!important">
                                                                         ${response.translation}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-${ key }"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" name="langs[]"
                                                                        id="lang-select-${ key }"

                                                                        value =  ${ response.lang }
                                                                        >
                                                                        <option value="" >Please Select Language</option>
                                                                        <option value="ar"
                                                                           >
                                                                            Arabic
                                                                        </option>
                                                                        <option value="en"
                                                                            >
                                                                            English
                                                                        </option>
                                                                        <option value="ur"
                                                                            >
                                                                            Urud
                                                                        </option>
                                                                        <option value="hi"
                                                                            >
                                                                            Hindi
                                                                        </option>
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="trans-input-${key}" name="translations[]">${ response.translation }</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;

                   //    $('#translation-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#translation-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   $('.append-inputs').append(html);
                   $('.summernote').summernote();

                   $('#lang-select-' + key).val(response.lang)
               }
           });
       }


       //Ayat Tafseer
       function deleteTafseer(ayatId, tafseerId, key) {


           $.ajax({
               type: "GET",
               url: "{{ url('ayat/tafseer/delete') }}",
               data: {
                   ayatId: ayatId,
                   tafseerId: tafseerId,
               },
               dataType: "json",
               success: function(response) {
                   $('.tafseer-div-' + key).remove();


                   var allElements = $('.tafseer-divs');
                   var count = allElements.length;

                   if (count == 0) {

                       $('.no-tafseer-div').css('display', 'block');
                   }
               },
           });

       }

       function editableTafseer(key) {
           $('#non-editble-tafseer-' + key).css('display', 'none');
           $('#tafseer-editble-' + key).css('display', 'block');
       }

       function saveTafseer(ayatId, tafseerId, key) {
           var lang = $('#tafseer-lang-select-' + key).val();
           var tafseer = $('#tafseer-trans-input-' + key).val();
           $.ajax({
               type: "GET",
               url: "{{ url('ayat/tafseer/update') }}",
               data: {
                   ayatId: ayatId,
                   tafseerId: tafseerId,
                   lang: lang,
                   tafseer: tafseer,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('#tafseer-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#tafseer-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   $('#tafseer-non-edit-lang-select-' + key).html(response.lang);
                   $('#tafseer-trans-input-' + key).val(response.tafseer);
                   $('#tafseer-non-edit-para-des-' + key).html(response.tafseer);
                   $('#tafseer-editble-' + key).css('display', 'none');
                   $('#non-editble-tafseer-' + key).css('display', 'block');
               }
           });
       }

       function addTafseer(ayatId) {
           $('.no-tafseer-div').css('display', 'none');
           var div = $('.tafseer-divs');
           var lang = div.length;
           var html;
           html = `
                        <div class="col-12 tafseer-divs tafseer-div-${lang}">

                                    <div class="card" >
                                    <div class="card-body">
                                        <div class="row">
                            <div class="col-8 ">
                                <h4 id="tafseer-saved-span-${lang }"
                                    style="display:none"> <span
                                        class="badge badge-success "><i
                                            class="fa fa-check">Translation
                                            Saved</i></span></h4>
                            </div>
                            <div class="col-4 d-flex">

                                <h4
                                    onclick="saveNewTafseer('${ayatId}','${lang }')">
                                    <span class="badge badge-success ml-1"><i
                                            class="fa fa-save">&nbspSave</i></span>
                                </h4>
                                <h4
                                    onclick="deleteNewTafseer('${lang }')">
                                    <span class="badge badge-danger ml-1"><i
                                            class="fa fa-trash">&nbspDelete</i></span>
                                </h4>
                            </div>
                        </div>
                            <p>Language</p>
                            <fieldset class="form-group">
                                <select class="form-control" name="langs[]" id="tafseer-new-lang-select-${lang}">
                                    <option value="" selected>Please Select Language</option>
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                    <option value="ur">Urud</option>
                                    <option value="hi">Hindi</option>
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Translation</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" name="translations[]" id="tafseer-new-description-${lang}"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>

                </div>
                `;

           $('.tafseer-append-inputs').append(html);
           $('.summernote').summernote();
       }

       function deleteNewTafseer(key) {
           $('.tafseer-div-' + key).remove();
           var allElements = $('.tafseer-divs');
           var count = allElements.length;

           if (count == 0) {
               $('.no-tafseer-div').css('display', 'block');
           }
       }

       function saveNewTafseer(ayatId, key) {
           var lang = $('#tafseer-new-lang-select-' + key).val();
           var tafseer = $('#tafseer-new-description-' + key).val();
           $.ajax({
               type: "GET",
               url: "{{ url('ayat/tafseer/save') }}",
               data: {
                   ayatId: ayatId,
                   lang: lang,
                   tafseer: tafseer,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('.tafseer-div-' + key).remove();

                   var html;
                   html = `<div class="col-12 tafseer-divs tafseer-div-${ key }">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-8 ">

                                                                    <h4 id="tafseer-saved-span-${ key }"
                                                                        style=""> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Tafseer
                                                                                Saved</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editableTafseer('${ key }')"><span
                                                                            class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTafseer('${response.ayat_id}','${response._id}','${key }')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTafseer('${response.ayat_id}','${response._id}','${key }')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-tafseer-${key}">

                                                                <p>Language :
                                                                    <b id="tafseer-non-edit-lang-select-${ key }">${response.lang }
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="tafseer-non-edit-para-des-${ key }"
                                                                        style="margin-left:10px!important">
                                                                         ${response.tafseer}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="tafseer-editble-${ key }"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" name="langs[]"
                                                                        id="tafseer-lang-select-${ key }"
                                                                        >
                                                                        <option value="" selected>Please Select Language</option>

                                                                        <option value="ar"
                                                                          >
                                                                            Arabic
                                                                        </option>
                                                                        <option value="en"
                                                                           >
                                                                            English
                                                                        </option>
                                                                        <option value="ur"
                                                                           >
                                                                            Urud
                                                                        </option>
                                                                        <option value="hi"
                                                                           >
                                                                            Hindi
                                                                        </option>
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="tafseer-trans-input-${key}" name="translations[]">${ response.tafseer }</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                   setTimeout(() => {
                       $('#tafseer-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   $('.tafseer-append-inputs').append(html);
                   $('.summernote').summernote();
                   $('#tafseer-lang-select-' + key).val(response.lang)

               }
           });
       }

       //Ayat References
       function addReference(ayatId) {
           $('.no-reference-div').css('display', 'none');
           var div = $('.references');
           var lang = div.length;
           var html;
           html = `
                        <div class="col-12 references reference-div-${lang}">

                                    <div class="card" >
                                    <div class="card-body">
                                        <div class="row">
                                                <div class="col-8 ">
                                                    <h4 id="reference-saved-span-${lang }"
                                                        style="display:none"> <span
                                                            class="badge badge-success "><i
                                                                class="fa fa-check">Translation
                                                                Saved</i></span>
                                                    </h4>
                                                </div>
                                                <div class="col-4 d-flex">

                                                    <h4
                                                        onclick="saveReference('${ayatId}','${lang}')">
                                                        <span class="badge badge-success ml-1"><i
                                                                class="fa fa-save">&nbspSave</i></span>
                                                    </h4>
                                                    <h4
                                                        onclick="deleteReference('${lang }')">
                                                        <span class="badge badge-danger ml-1"><i
                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                    </h4>
                                                </div>
                                         </div>
                            <p>Type</p>
                            <fieldset class="form-group">
                                <select class="form-control reference-select" onchange="getFilesAjax('${lang}' )" name="reference_type[]" id="reference-new-lang-select-${lang}">
                                    <option value="" selected>Please Select Language</option>
                                    <option value="1">eBook</option>
                                    <option value="2">Audio</option>
                                    <option value="3">Paper</option>
                                </select>
                            </fieldset>
                                <label for="">File</label>
                                <fieldset class="form-group">
                                    <select class="form-control " name="file[]" id="file-new-lang-select-${lang}">
                                    <option value="" selected>Please Select File</option>

                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>

                </div> `;

           $('.reference-append-inputs').append(html);
           $('.summernote').summernote();
       }

       function getFilesAjax(key) {
           var referenceType = $('#reference-new-lang-select-' + key).val();

           $.ajax({
               type: "GET",
               url: "{{ url('referene/get_files') }}",
               data: {
                   type: referenceType,
               },
               dataType: "json",
               success: function(response) {

                   var html = '<option value="" selected disabled>Please Select File</option>';
                   response.forEach(element => {
                       html += `<option value="${element._id}">${element.title}</option>`;
                       $('#file-new-lang-select-' + key).html(html);
                   });
               },
           });
       }

       function saveReference(ayatId, key) {

           var type = $('#reference-new-lang-select-' + key).val();
           var fileId = $('#file-new-lang-select-' + key).val();

           $.ajax({
               type: "GET",
               url: "{{ url('referene/add') }}",
               data: {
                   type: 1,
                   ayatId: ayatId,
                   ref_type: type,
                   fileId: fileId
               },
               dataType: "json",
               success: function(response) {

                   var html;
                   var type;
                   if (response.type == 1) {
                       type = "eBook";
                   } else if (response.type == 2) {
                       type = "Audio Book";

                   } else {
                       type = "Research Paper";
                   }
                   console.log(response);
                   $('.no-reference-tr').css('display', 'none');

                   html = `<tr class="ref-tr"
                    id="ref-tr-${key }">
                    <td>${ response.reference_title }
                        </td>
                        <td>${type}
                            </td>
                            <td><i class="fa fa-trash"
                                onclick="deleteReference('${response.referal_id}', '${ response._id}' , '${ key }')"></i>
                                </td>
                                </tr>`;
                   $('.ref-table').append(html);
                   $('.reference-div-' + key).remove();
                   $('#reference-saved-span').css('display', 'block');
                   setTimeout(() => {
                       $('#reference-saved-span').css('display', 'none');

                   }, 3000);
               },
           });
       }

       function deleteReference(ayatId, ref_id, key) {

           $.ajax({
                   type: "GET",
                   url: "{{ url('reference/delete') }}",
                   data: {
                       ayatId: ayatId,
                       ref_id: ref_id,
                   },
                   dataType: "json",
                   success: function(response) {
                       $('#ref-tr-' + key).remove();
                       //    $('.reference-div-' + key).remove();
                       var allElements = $('.ref-tr');
                       var count = allElements.length;
                       if (count == 0) {
                               $('.no-reference-tr').css('display', 'block');
                           }
                       },
                   });
           }
   </script>

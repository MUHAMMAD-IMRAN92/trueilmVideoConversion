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
                           var des = '';
                           if (row.ayat != null) {
                               des = row.ayat;
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.para_no + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.ruku + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('ayat/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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
                           }
                           return '<td>' +
                               des +
                               '</td>'
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
                           var eye = 'feather icon-eye';
                           if (row.status == 0) {
                               eye = 'feather icon-eye-off';
                           }
                           return `<td>
                                <a  class="ml-2" href="{{ url('book/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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
                   url: '<?= url('all-hadith') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.hadees + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('hadith/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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

                           return '<td><img src="' +
                               row.image +
                               '}}/></td>'
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
           $('#add-translation').on('click', function() {
               var html;
               html =
                   `<div class="col-12">

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
       });
   </script>

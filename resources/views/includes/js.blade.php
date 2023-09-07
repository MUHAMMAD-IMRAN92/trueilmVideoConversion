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
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
   <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
   <!-- BEGIN: Page Vendor JS-->
   <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
   <script src="{{ asset('app-assets/js/scripts/pages/app-chat.js') }}"></script>
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
       $(".select2").select2({
           tags: true
       });
       $(document).ready(function() {
           $('.summernote').summernote({
               height: 150,
               codemirror: {
                   theme: 'default'
               },
               toolbar: [
                   // [groupName, [list of button]]
                   ['style', ['bold', 'italic', 'underline', 'clear']],
                   ['font', ['strikethrough', 'superscript', 'subscript']],
                   ['fontsize', ['fontsize', 'fontname']],
                   ['color', ['color']],
                   ['para', ['ul', 'ol', 'paragraph']],
                   ['height', ['height']]
               ]
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
           $('#juz-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-juz') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.juz + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           }
                           return '<td>' +
                               des + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('juz/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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
                                <a  class="ml-2" href="{{ url('publisher/books_reading_details/`+row._id+`') }}"><i class="fa fa-info-circle" style="font-size:24px"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#author-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-author') ?>'
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
                                <a  class="ml-2" href="{{ url('author/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#order-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-order') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           var oderNo = '';
                           if (row.orderNumber != null) {
                               oderNo = row.orderNumber;
                           }
                           return '<td>' +
                               oderNo +
                               '</td>'
                       }
                   },

                   {
                       "mRender": function(data, type, row) {
                           var name = '';
                           if (row.name != null) {
                               name = row.name;
                           }
                           return '<td>' +
                               name +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var phone = '';
                           if (row.phone != null) {
                               phone = row.phone;
                           }
                           return '<td>' +
                               phone +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var city = '';
                           if (row.city != null) {
                               city = row.city;
                           }
                           return '<td>' +
                               city +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var total = '';
                           if (row.total != null) {
                               total = row.total;
                           }
                           return '<td>' +
                               total +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var status = 'Pending';
                           if (row.status == 2) {
                               status = 'Shipped';
                           } else if (row.status == 3) {
                               status = 'Delivered';
                           }
                           return '<td>' +
                               status +
                               '</td>'
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#book-for-sale-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all_books_for_sale') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.price + '</td>'
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

                                <a  class="ml-2" href="{{ url('book_for_sale/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a></td>`
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

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
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
                           if (row.type == 7) {
                               type = 'Podcast';
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
                   }, {
                       "mRender": function(data, type, row) {
                           var approver_name = '';
                           if (row.approver_name != null) {
                               approver_name = row.approver_name;
                           } else {
                               approver_name = '--'
                           }
                           return '<td>' +
                               approver_name + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.numberOfUser + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var eye = 'feather icon-eye';
                           var list = '';
                           if (row.status == 0) {
                               eye = 'feather icon-eye-off';
                           }
                           if (row.type == 2 || row.type == 7) {
                               list =
                                   `<a class="ml-2" href="{{ url('book/`+ row.type +`/list/`+row._id+`') }}"> <i class="fa fa-list"> </i></a>`
                           }
                           return `<td>
                            <div class="d-flex">
                                <a  class="ml-2" href="{{ url('book/`+ row.type +`/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>` +
                               list +
                               `<a  class="ml-2" href="{{ url('book/update-status/`+row._id+`') }}"><i class="` +
                               eye +
                               `"></i></a>
                                </td>
                                </div>`
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
                   }, {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
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
           $('#subs-email-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all_subcription_email') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return '<td>' +
                               row.email +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {

                           return '<td>' +
                               row.created_at +
                               '</td>'
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
                               des = row.description.slice(0, 150);
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
                           var a = '';
                           if ("{{ auth()->user()->hasRole('Admin') }}" ||
                               "{{ auth()->user()->hasRole('Super Admin') }}") {
                               a =
                                   `<a  class="ml-2" href="{{ url('category/`+row.type+`/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                   <a  class="ml-2" href="{{ url('category/update-status/`+row._id+`') }}"><i class="` +
                                   eye + `"></i></a>`;
                           }
                           return `<td>
                                ` + a + `

                                </td>`
                       }
                   },
               ],
               "columnDefs": [{
                   'targets': [0, 1, 2, 3],
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

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
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
                           if (row.type == 7) {
                               type = 'Podcast';
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
                           var anchor;
                           if (row.type == 2 || row.type == 7) {
                               anchor =
                                   `<a class="ml-2" target="_blank" href="{{ url('book/`+ row.type +`/list/`+row._id+`') }}"> <i class="fa fa-list"  style="font-size:24px"> </i></a>`;
                           } else {
                               anchor =
                                   `<a  class="ml-2" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                           }
                           return `<td">
                                <a  class="ml-2" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                                <a href="#" class="ml-2"><i class="fa fa-times" onclick="reasonModal('${row._id}')" style="font-size:24px; cursor:pointer"  data-href=""></i></a>` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#grant-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-grants') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },

                   {
                       "mRender": function(data, type, row) {
                           var type = '';
                           if (row.file_type == 1) {
                               type = 'eBook';
                           }
                           if (row.file_type == 2) {
                               type = 'Audio Book';
                           }
                           if (row.file_type == 3) {
                               type = 'Research Paper';
                           }
                           if (row.file_type == 7) {
                               type = 'Podcast';
                           }
                           return '<td>' +
                               type +
                               '</td>'
                       }
                   },
                   {
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
                           var anchor;
                           if (row.file_type == 2 || row.file_type == 7) {
                               anchor =
                                   `<a class="ml-2" target="_blank" href="{{ url('book/`+ row.file_type +`/list/`+row._id+`') }}"> <i class="fa fa-list"  style="font-size:24px"> </i></a>`;
                           } else {
                               anchor =
                                   `<a  class="ml-2" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                           }
                           return `<td">
                                <a  class="ml-2" href="{{ url('grant/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                                <a href="#" class="ml-2"><i class="fa fa-times" onclick="reasonModalForGrant('${row._id}')" style="font-size:24px; cursor:pointer"  data-href=""></i></a>` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#book-mistake-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-mistakes') ?>'
               },
               "columns": [{
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
                           var book = '--';
                           if (row.book != null) {
                               book = row.book.title;
                           }
                           return '<td>' +
                               book + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var page = '';
                           if (row.page_no != null) {
                               page = row.page_no;
                           } else {
                               page = '--'
                           }
                           return '<td>' +
                               page + '</td>'
                       }
                   },
                   {
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

                           anchor =
                               `<a  class="ml-2"  href="{{ url('mistake/understood/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>`;

                           return `<td>` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#rejected-grant-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-grants-rejected') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },

                   {
                       "mRender": function(data, type, row) {
                           var type = '';
                           if (row.file_type == 1) {
                               type = 'eBook';
                           }
                           if (row.file_type == 2) {
                               type = 'Audio Book';
                           }
                           if (row.file_type == 3) {
                               type = 'Research Paper';
                           }
                           if (row.file_type == 7) {
                               type = 'Podcast';
                           }
                           return '<td>' +
                               type +
                               '</td>'
                       }
                   },
                   {
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
                   }, {
                       "mRender": function(data, type, row) {
                           var approver_name = '';
                           if (row.approver_name != null) {
                               approver_name = row.approver_name;
                           } else {
                               approver_name = '--'
                           }
                           return '<td>' +
                               approver_name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var reason = '';
                           if (row.reason != null) {
                               reason = row.reason;
                           } else {
                               reason = '--'
                           }
                           return '<td>' +
                               reason + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var anchor;
                           if (row.file_type == 2 || row.file_type == 7) {
                               anchor =
                                   `<a class="ml-2" target="_blank" href="{{ url('book/`+ row.file_type +`/list/`+row._id+`') }}"> <i class="fa fa-list"  style="font-size:24px"> </i></a>`;
                           } else {
                               anchor =
                                   `<a  class="ml-2" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                           }
                           return `<td">
                                <a  class="ml-2" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#approved-grant-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-grants-approved') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },

                   {
                       "mRender": function(data, type, row) {
                           var type = '';
                           if (row.file_type == 1) {
                               type = 'eBook';
                           }
                           if (row.file_type == 2) {
                               type = 'Audio Book';
                           }
                           if (row.file_type == 3) {
                               type = 'Research Paper';
                           }
                           if (row.file_type == 7) {
                               type = 'Podcast';
                           }
                           return '<td>' +
                               type +
                               '</td>'
                       }
                   },
                   {
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
                           var approver_name = '';
                           if (row.approver_name != null) {
                               approver_name = row.approver_name;
                           } else {
                               approver_name = '--'
                           }
                           return '<td>' +
                               approver_name + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var anchor;
                           if (row.file_type == 2 || row.file_type == 7) {
                               anchor =
                                   `<a class="ml-2" target="_blank" href="{{ url('book/`+ row.file_type +`/list/`+row._id+`') }}"> <i class="fa fa-list"  style="font-size:24px"> </i></a>`;
                           } else {
                               anchor =
                                   `<a  class="ml-2" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                           }
                           return `<td">
                            ` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#book-review-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-review-book') ?>'
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
                   },

                   {
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
                           var reviewed_by = '';
                           if (row.reviewer_name != null) {
                               reviewed_by = row.reviewer_name;
                           } else {
                               reviewed_by = '--'
                           }
                           return '<td>' +
                               reviewed_by + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var review = '';
                           if (row.review_description != null) {
                               review = row.review_description;
                           } else {
                               review = '--'
                           }
                           return '<td>' +
                               review + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var rating = '';
                           if (row.rating != null) {
                               rating = row.rating;
                           } else {
                               rating = '--'
                           }
                           return '<td>' +
                               rating + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var anchor;


                           anchor =
                               `<a  class="ml-2"  href="{{ url('review/`+row._id+`') }}"><i class="fa fa-comments-o"  style="font-size:24px"></i></a><a  class="ml-2" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                           return `<td">
                            ` +
                               anchor +
                               `</td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#admin-rejected-book-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-admin-rejected-book') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.author + '</td>'
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
                           if (row.type == 7) {
                               type = 'Podcast';
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
                           var reason = '';
                           if (row.reason != null) {
                               reason = row.reason;
                           } else {
                               reason = '--'
                           }
                           return '<td>' +
                               reason + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var a = '';
                           if ("{{ auth()->user()->hasRole('Admin') }}" ||
                               "{{ auth()->user()->hasRole('Super Admin') }}") {
                               a =
                                   `<a  class="ml-2" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>`;
                           }
                           return `<td>
                                    ${a}
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{
                   'targets': [0, 1, 2, 3, 4, 5, 6, 7],
                   "orderable": false
               }],
               "order": false
           });
           $('#rejected-book-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-rejected-book') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.author + '</td>'
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
                           if (row.type == 7) {
                               type = 'Podcast';
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
                           var reason = '';
                           if (row.reason != null) {
                               reason = row.reason;
                           } else {
                               reason = '--'
                           }
                           return '<td>' +
                               reason + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var a = '';
                           if ("{{ auth()->user()->hasRole('Admin') }}" ||
                               "{{ auth()->user()->hasRole('Super Admin') }}") {
                               a =
                                   `<a  class="ml-2" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>`;
                           }
                           return `<td>
                                    ${a}
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{
                   'targets': [0, 1, 2, 3, 4, 5, 6, 7],
                   "orderable": false
               }],
               "order": false
           });
           $('#approved-book-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-approved-book') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.author + '</td>'
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
                           if (row.type == 7) {
                               type = 'Podcast';
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
                           var reason = '';
                           if (row.reason != null) {
                               reason = row.reason;
                           } else {
                               reason = '--'
                           }
                           return '<td>' +
                               reason + '</td>'
                       }
                   }

               ],
               "columnDefs": [{
                   'targets': [0, 1, 2, 3, 4, 5, 6],
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

                           return `<td><img class="td-img" src=
                               ${row.image}
                               /></td>`
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var user_name = "";
                           if (row.user_name != null) {
                               user_name = row.user_name;
                           } else {
                               user_name = '--';
                           }
                           return '<td>' +
                               user_name +
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
           $('#support-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-support') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var des = "";
                           if (row.description != null) {
                               des = row.description;
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var name = "";
                           if (row.user != null) {
                               name = row.user.name;
                           } else {
                               name = '--';
                           }
                           return '<td>' +
                               name +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var status = "Waiting";
                           if (row.status == 1) {
                               status = "Sent";
                           } else if (row.status == 2) {
                               status = 'Closed';
                           }
                           return '<td>' +
                               status +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                            <a  class="ml-2" href="{{ url('support/details/`+row._id+`') }}"><i class="fa  fa-info-circle" style="font-size:24px"></i></a>
                            <a  class="ml-2" href="{{ url('support/approve/`+row._id+`') }}"><i class="fa  fa-check" style="font-size:24px"></i></a>
                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#activity-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-activities') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {

                           var sentence = `${row.user_name} Has ${row.key} (${row.title})`;
                           return '<td>' +
                               sentence +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           var route = `${row.revert_link}`;
                           return `<td>
                             <a  class="ml-2" href="{{ url('${route}` +row.content_id+`/${row._id}') }}"><i class="fa fa-undo"></i></a>

                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#glossory-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-glossary') ?>'
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
                                <a  class="ml-2" href="{{ url('glossary/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>

                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#coupon-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-coupon') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.title + '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           var des = '';
                           if (row.description != null) {
                               des = row.description.slice(0, 150);
                           } else {
                               des = '--';
                           }
                           return '<td>' +
                               des +
                               '</td>'
                       }
                   }, {
                       "mRender": function(data, type, row) {
                           return '<td>' +
                               row.percentage + '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {

                           return `<td>
                                <a  class="ml-2" href="{{ url('coupon/delete/`+row._id+`') }}"><i class="fa fa-trash"></i></a>

                                </td>`
                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
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
               //    $('.summernote').summernote({
               //        height: 300,
               //        codemirror: {
               //            theme: 'default'
               //        },
               //        toolbar: [
               //            // [groupName, [list of button]]
               //            ['style', ['bold', 'italic', 'underline', 'clear']],
               //            ['font', ['strikethrough', 'superscript', 'subscript']],
               //            ['fontsize', ['fontsize', 'fontname']],
               //            ['color', ['color']],
               //            ['para', ['ul', 'ol', 'paragraph']],
               //            ['height', ['height']]
               //        ]
               //    });
           });
           $('#add-ayat').on('click', function() {
               $('#add-ayat-div').css('display', 'block')
               $('.card-height ').css('height', '600px')
               $('#no-ayat-added-div').css('display', 'none')
           });
           $('#disable-btn-submit').on('submit', function() {
               $('#submit-btn').prop('disabled', 'true');
           });

           $('#app-user-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-app-user') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           name = '--';
                           if (row.name != undefined) {
                               name = row.name
                           }
                           return '<td>' +
                               name + '</td>'
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
                   }, {
                       "mRender": function(data, type, row) {
                           var status = '';
                           if (row.status == 0) {
                               status = 'Not Subscribed';
                           } else {
                               status = 'Subscribed';

                           }
                           return '<td>' +
                               status +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return `<td>
                                <a  class="ml-2" href="{{ url('app-user/books_reading_details/`+row._id+`') }}"><i class="fa fa-info-circle" style="font-size:24px"></i></a>
                               </td>`;

                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
           $('#institue-users-table').DataTable({
               "processing": true,
               "serverSide": true,
               "deferRender": true,
               "language": {
                   "searchPlaceholder": "Search here"
               },
               "ajax": {
                   url: '<?= url('all-institute-users') ?>'
               },
               "columns": [{
                       "mRender": function(data, type, row) {
                           name = '--';
                           if (row.name != undefined) {
                               name = row.name
                           }
                           return '<td>' +
                               name + '</td>'
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
                   }, {
                       "mRender": function(data, type, row) {
                           var status = '';
                           if (row.status == 0) {
                               status = 'Not Subscribed';
                           } else {
                               status = 'Subscribed';

                           }
                           return '<td>' +
                               status +
                               '</td>'
                       }
                   },
                   {
                       "mRender": function(data, type, row) {
                           return `<td>
                                <a  class="ml-2" href="{{ url('app-user/books_reading_details/`+row._id+`') }}"><i class="fa fa-info-circle" style="font-size:24px"></i></a>
                                <a  class="ml-2" href="{{ url('institute/user/delete/`+row._id+`') }}"><i class="fa fa-trash" style="font-size:24px"></i></a>
                               </td>`;

                       }
                   },
               ],
               "columnDefs": [{

                   "orderable": false
               }],
               "order": false
           });
       });

       function fileSelect(e, l) {
           console.log(e.target.files[0].name);
           $('#label-' + l).text(e.target.files[0].name);
       }


       // Ayat Translation
       function deleteTranslation(transId, authLang, key, type) {
           $.ajax({
               type: "GET",
               url: "{{ url('ayat/translation/delete') }}",
               data: {
                   authLang: authLang,
                   transId: transId,
                   type: type
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('#non-edit-para-des-' + key).html('');
                   $('#trans-input-' + key).html('');

               },
           });

           $('#translation-delete-span-' + key).css('display', 'block');
           setTimeout(() => {
               $('#translation-delete-span-' + key).css('display', 'none');

           }, 3000);
       }

       function editable(key) {
           $('#non-editble-translation-' + key).css('display', 'none');
           $('#editble-' + key).css('display', 'block');
       }

       function saveTranslation(authorLang, key) {
           var lang = $('#lang-select-' + key).val();
           var translation = $('#trans-input-' + key).val();
           var ayatId = $('#ayat-id-' + key).val();
           var transId = $('#trans-id-' + key).val();
           var type = $('#type-' + key).val();
           console.log(ayatId + '----------------->' + key);
           $.ajax({
               type: "POST",
               url: "{{ url('ayat/translation/update') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   ayatId: ayatId,
                   transId: transId,
                   lang: lang,
                   author_lang: authorLang,
                   translation: translation,
                   type: type
               },
               dataType: "json",
               success: function(response) {
                   $('#translation-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#translation-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   //    console.log(response);
                   //    $('#non-edit-lang-select-' + key).html(response.lang_title);
                   $('#trans-input-' + key).val(response.translation);
                   $('#non-edit-para-des-' + key).html(response.translation);
                   $('#editble-' + key).css('display', 'none');
                   $('#non-editble-translation-' + key).css('display', 'block');
               }
           });
       }

       function addTranslation(ayatId) {
           $('#no-translation-div').css('display', 'none');
           var opt = null;
           $.ajax({
               type: "GET",
               url: "{{ url('languages') }}",
               dataType: "json",
               success: function(response) {
                   response.forEach(function(e) {
                       //    opt = response;
                       opt += `<option value="${e._id}">${e.title}</option>`;
                   })
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
                                <select class="select2 form-control" name="langs[]" required id="new-lang-select-${lang}">
                                    <option value="" selected>Please Select Language</option>
                                    ${opt}
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Translation</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" required name="translations[]" id="new-description-${lang}"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>

                </div>
                `;

                   $('.append-inputs').append(html);
                   $('.summernote').summernote({
                       height: 150,
                       codemirror: {
                           theme: 'default'
                       },
                       toolbar: [
                           // [groupName, [list of button]]
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                           ['font', ['strikethrough', 'superscript', 'subscript']],
                           ['fontsize', ['fontsize', 'fontname']],
                           ['color', ['color']],
                           ['para', ['ul', 'ol', 'paragraph']],
                           ['height', ['height']]
                       ]
                   });
                   $('#new-lang-select-' + lang).select2({
                       tags: true
                   });
               },
           });
           console.log(opt);

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
               type: "POST",
               url: "{{ url('ayat/translation/save') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   ayatId: ayatId,
                   lang: lang,
                   translation: translation,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('.translation-div-' + key).remove();
                   var opt = '';
                   response.lang.forEach(function(e) {
                       //    opt = response;
                       var selected = '';
                       if (response.ayat.lang == e._id) {
                           selected = 'selected';
                       }
                       opt += `<option value="${e._id}"  ${selected}>${e.title}</option>`;
                   })
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
                                                                        onclick="saveTranslation('${response.ayat.ayat_id}','${response.ayat._id}','${key }')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTranslation('${response.ayat.ayat_id}','${response.ayat._id}','${key }')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-${key}">

                                                                <p>Language :
                                                                    <b id="non-edit-lang-select-${ key }">${response.ayat.lang_title }
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-${ key }"
                                                                        style="margin-left:10px!important">
                                                                         ${response.ayat.translation}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-${ key }"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select style="width:100%" class="select2 form-control" required name="langs[]"
                                                                        id="lang-select-${ key }"

                                                                        value =  ${ response.ayat.lang_title }
                                                                        >
                                                                        <option value="" >Please Select Language</option>
                                                                        ${opt}
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" required id="trans-input-${key}" name="translations[]">${ response.ayat.translation }</textarea>
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
                   $('.summernote').summernote({
                       height: 150,
                       codemirror: {
                           theme: 'default'
                       },
                       toolbar: [
                           // [groupName, [list of button]]
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                           ['font', ['strikethrough', 'superscript', 'subscript']],
                           ['fontsize', ['fontsize', 'fontname']],
                           ['color', ['color']],
                           ['para', ['ul', 'ol', 'paragraph']],
                           ['height', ['height']]
                       ]
                   });
                   $('#lang-select-' + key).select2({
                       tags: true
                   });
                   $('#lang-select-' + key).val(response.ayat.lang)
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
               type: "post",
               url: "{{ url('ayat/tafseer/update') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
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
                   $('#tafseer-non-edit-lang-select-' + key).html(response.lang_title);
                   $('#tafseer-trans-input-' + key).val(response.tafseer);
                   $('#tafseer-non-edit-para-des-' + key).html(response.tafseer);
                   $('#tafseer-editble-' + key).css('display', 'none');
                   $('#non-editble-tafseer-' + key).css('display', 'block');
               }
           });
       }

       function addTafseer(ayatId) {
           $('.no-tafseer-div').css('display', 'none');
           var opt = '';
           $.ajax({
               type: "GET",
               url: "{{ url('languages') }}",
               dataType: "json",
               success: function(response) {
                   response.forEach(function(e) {
                       //    opt = response;
                       opt += `<option value="${e._id}">${e.title}</option>`;
                   })
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
                                <select class="select2 form-control" name="taf_langs[]" required id="tafseer-new-lang-select-${lang}">
                                    <option value="" selected>Please Select Language</option>
                                   ${opt}
                                </select>
                            </fieldset>
                            </div>
                            <div class="col-12">
                                <label for="">Tafseer</label>
                                <fieldset class="form-group">
                                    <textarea class="summernote" required name="tafseers[]" id="tafseer-new-description-${lang}"></textarea>
                                </fieldset>
                        </div>
                    </div>
                </div>

                </div>
                `;

                   $('.tafseer-append-inputs').append(html);
                   $('.summernote').summernote({
                       height: 150,
                       codemirror: {
                           theme: 'default'
                       },
                       toolbar: [
                           // [groupName, [list of button]]
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                           ['font', ['strikethrough', 'superscript', 'subscript']],
                           ['fontsize', ['fontsize', 'fontname']],
                           ['color', ['color']],
                           ['para', ['ul', 'ol', 'paragraph']],
                           ['height', ['height']]
                       ]
                   });
                   $('#tafseer-new-lang-select-' + lang).select2({
                       tags: true
                   });
               }
           });

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
               type: "post",
               url: "{{ url('ayat/tafseer/save') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   ayatId: ayatId,
                   lang: lang,
                   tafseer: tafseer,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('.tafseer-div-' + key).remove();
                   var opt = '';
                   response.lang.forEach(function(e) {
                       //    opt = response;
                       var selected = '';
                       if (response.ayat.lang == e._id) {
                           selected = 'selected';
                       }
                       opt += `<option value="${e._id}"  ${selected}>${e.title}</option>`;
                   })
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
                                                                        onclick="saveTafseer('${response.ayat.ayat_id}','${response.ayat._id}','${key }')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTafseer('${response.ayat.ayat_id}','${response.ayat._id}','${key }')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-tafseer-${key}">

                                                                <p>Language :
                                                                    <b id="tafseer-non-edit-lang-select-${ key }">${response.ayat.lang_title }
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="tafseer-non-edit-para-des-${ key }"
                                                                        style="margin-left:10px!important">
                                                                         ${response.ayat.tafseer}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="tafseer-editble-${ key }"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select style="width:100%" class="select2 form-control" name="taf_langs[]"
                                                                        id="tafseer-lang-select-${ key }"
                                                                        required>
                                                                        <option value="" selected>Please Select Language</option>

                                                                       ${opt}
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Tafseer</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="tafseer-trans-input-${key}" name="tafseers[]" required>${ response.ayat.tafseer }</textarea>
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
                   $('.summernote').summernote({
                       height: 150,
                       codemirror: {
                           theme: 'default'
                       },
                       toolbar: [
                           // [groupName, [list of button]]
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                           ['font', ['strikethrough', 'superscript', 'subscript']],
                           ['fontsize', ['fontsize', 'fontname']],
                           ['color', ['color']],
                           ['para', ['ul', 'ol', 'paragraph']],
                           ['height', ['height']]
                       ]
                   });
                   $('#tafseer-lang-select-' + key).val(response.ayat.lang)
                   $('#tafseer-lang-select-' + key).select2({
                       tags: true
                   });

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
                                                                class="fa fa-check">Reference
                                                                Attached</i></span>
                                                    </h4>
                                                </div>
                                                <div class="col-4 d-flex">

                                                    <h4
                                                        onclick="saveReference('${ayatId}','${lang}')">
                                                        <span class="badge badge-success ml-1"><i
                                                                class="fa fa-save">&nbspSave</i></span>
                                                    </h4>
                                                    <h4
                                                        onclick="deleteNewReference('${lang}')">
                                                        <span class="badge badge-danger ml-1"><i
                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                    </h4>
                                                </div>
                                         </div>
                            <p>Type</p>
                            <fieldset class="form-group">
                                <select class="selct2 form-control reference-select" onchange="getFilesAjax('${lang}' )" name="reference_type[]" id="reference-new-lang-select-${lang}" required>
                                    <option value="" selected>Please Select Reference</option>
                                    <option value="1">eBook</option>
                                    <option value="2">Audio</option>
                                    <option value="3">Paper</option>
                                </select>
                            </fieldset>
                                <label for="">File</label>
                                <fieldset class="form-group">
                                    <select class="selct2 form-control " name="file[]" id="file-new-lang-select-${lang}" required>
                                    <option value="" selected>Please Select File</option>

                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>

                </div> `;

           $('.reference-append-inputs').append(html);
           $('.summernote').summernote();
           $('#file-new-lang-select-' + lang).select2({
               tags: true
           });
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

       function deleteNewReference(key) {
           // alert(key);
           $('.reference-div-' + key).remove();
       }
       //Hadith Translations
       function addHadithTranslation(ayatId) {
           var lang = $('#lang-select-' + key).val();
           var translation = $('#trans-input-' + key).val();
           var ayatId = $('#ayat-id-' + key).val();
           var transId = $('#trans-id-' + key).val();
           var type = $('#type-' + key).val();
           console.log(ayatId + '----------------->' + key);
           $.ajax({
               type: "POST",
               url: "{{ url('hadith/translation/update') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   ayatId: ayatId,
                   transId: transId,
                   lang: lang,
                   author_lang: authorLang,
                   translation: translation,
                   type: type
               },
               dataType: "json",
               success: function(response) {
                   $('#translation-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#translation-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   //    console.log(response);
                   //    $('#non-edit-lang-select-' + key).html(response.lang_title);
                   $('#trans-input-' + key).val(response.translation);
                   $('#non-edit-para-des-' + key).html(response.translation);
                   $('#editble-' + key).css('display', 'none');
                   $('#non-editble-translation-' + key).css('display', 'block');
               }
           });

       }

       function saveNewHadithTranslation(hadithId, key) {
           var lang = $('#new-lang-select-' + key).val();
           var translation = $('#new-description-' + key).val();
           $.ajax({
               type: "POST",
               url: "{{ url('hadith/translation/save') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   hadithId: hadithId,
                   lang: lang,
                   translation: translation,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('.translation-div-' + key).remove();
                   var opt = '';
                   response.lang.forEach(function(e) {
                       //    opt = response;
                       var selected = '';
                       if (response.hadees.lang == e._id) {
                           selected = 'selected';
                       }
                       opt += `<option value="${e._id}"  ${selected}>${e.title}</option>`;
                   })
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
                                                                        onclick="saveHadithTranslation('${response.hadees.hadees_id}','${response.hadees._id}','${key }')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteHadithTranslation('${response.hadees.hadees_id}','${response.hadees._id}','${key }')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-${key}">

                                                                <p>Language :
                                                                    <b id="non-edit-lang-select-${ key }">${response.hadees.lang_title }
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-${ key }"
                                                                        style="margin-left:10px!important">
                                                                         ${response.hadees.translation}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-${ key }"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select style="width:100%" class="select2 form-control" required name="langs[]"
                                                                        id="lang-select-${ key }"

                                                                        value =  ${ response.hadees.lang_title }
                                                                        >
                                                                        <option value="" >Please Select Language</option>
                                                                        ${opt}
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" required id="trans-input-${key}" name="translations[]">${ response.hadees.translation }</textarea>
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
                   $('.hadith-append-inputs').append(html);
                   $('.summernote').summernote({
                       height: 150,
                       codemirror: {
                           theme: 'default'
                       },
                       toolbar: [
                           // [groupName, [list of button]]
                           ['style', ['bold', 'italic', 'underline', 'clear']],
                           ['font', ['strikethrough', 'superscript', 'subscript']],
                           ['fontsize', ['fontsize', 'fontname']],
                           ['color', ['color']],
                           ['para', ['ul', 'ol', 'paragraph']],
                           ['height', ['height']]
                       ]
                   });
                   $('#lang-select-' + key).select2({
                       tags: true
                   });
                   $('#lang-select-' + key).val(response.hadees.lang)
               }
           });
       }

       function deleteHadithTranslation(transId, authLang, key, type) {
           $.ajax({
               type: "GET",
               url: "{{ url('hadith/translation/delete') }}",
               data: {
                   authLang: authLang,
                   transId: transId,
                   type: type
               },
               dataType: "json",
               success: function(response) {
                   console.log(response);
                   $('#non-edit-para-des-' + key).html('');
                   $('#trans-input-' + key).html('');
               },
           });

       }

       function saveHadithTranslation(authorLang, key) {
           var lang = $('#lang-select-' + key).val();
           var translation = $('#trans-input-' + key).val();
           var hadith_id = $('#ayat-id-' + key).val();
           var transId = $('#trans-id-' + key).val();
           var type = $('#type-' + key).val();
           console.log(hadith_id + '----------------->' + key);
           $.ajax({
               type: "POST",
               url: "{{ url('hadith/translation/update') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   hadith_id: hadith_id,
                   transId: transId,
                   lang: lang,
                   author_lang: authorLang,
                   translation: translation,
                   type: type
               },
               dataType: "json",
               success: function(response) {
                   $('#translation-saved-span-' + key).css('display', 'block');
                   setTimeout(() => {
                       $('#translation-saved-span-' + key).css('display', 'none');

                   }, 3000);
                   //    console.log(response);
                   //    $('#non-edit-lang-select-' + key).html(response.lang_title);
                   $('#trans-input-' + key).val(response.translation);
                   $('#non-edit-para-des-' + key).html(response.translation);
                   $('#editble-' + key).css('display', 'none');
                   $('#non-editble-translation-' + key).css('display', 'block');
               }
           });
       }
       $('.multiple-select').select2({
           tags: true,
           tokenSeparators: [',', ' ']
       });

       $('.multiple-select').on('select2:selecting', function(e) {
           var value = e.params.args.data.id;
           // if (value && value.trim() !== '') {
           //     var option = new Option(value, true);
           //     $(this).append(option).trigger('change');
           // }
           $(this).val($(this).val()).trigger('change');
       });

       function reasonModal(key) {
           $('#book_id').val(key);
           var newUrl = "{{ url('book/reject/') }}" + '/' + key;
           $('#reason_form').attr('action', newUrl);

           $('#reason').modal('show');
       }

       function reasonModalForGrant(key) {
           $('#book_id').val(key);
           var newUrl = "{{ url('grant/reject/') }}" + '/' + key;
           $('#reason_form').attr('action', newUrl);

           $('#reason').modal('show');
       }

       function priceRadioFunction(val) {
           if (val == 1) {
               $('#price').prop("disabled", false);
               $('#sample-file').prop("disabled", false);
               console.log($('#price').val());
           } else {
               $('#price').prop("disabled", true);
               $('#sample-file').prop("disabled", true);
               console.log($('#price').val());
           }
       }

       $('#save_chapter').on('click', function() {
           var title = $('#modal_title').val();
           var hadith_book = $('#hadith_book').val();

           $.ajax({
               type: "POST",
               url: "{{ url('hadith/add_chapter') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   title: title,
                   hadith_book: hadith_book,
               },
               dataType: "json",
               success: function(response) {
                   console.log(response)
                   var option = `<option value="` + response._id + `">` + response.title + `</option>`;
                   $('#chapter_select').append(option);
                   $('#author-lang').modal('hide');
               }
           });
       });
       $('#countries').on('change', function() {

           var countries = $('#countries').val();
           var book_id = $('#book_for_sale_id').val();
           $.ajax({
               url: "{{ url('/cities') }}",
               method: "GET",
               data: {
                   'countries': countries,
                   'book_id': book_id
               },
               success: function(result) {
                   console.log(result);
                   var html = '';

                   if (result.cities.length > 0) {

                       result.cities.forEach(element => {
                           html += `<option value="${element}">${element} </option>`;
                       });
                       $('#cities').html(html);
                   } else {
                       $('#cities').html(html);
                   }
                   if (result.oldCities.length > 0) {
                       result.oldCities.forEach(element => {
                           html += `<option selected value="${element}">${element} </option>`;
                       });
                       $('#cities').append(html);
                   }
                   if (result.cities.length == 0) {
                       $('#cities').html('');
                   }
               }
           });
       });
       $('.file_type').on('click', function() {
           var type = $('.file_type:checked').val();
           if (type == 3) {
               $('.translation-lang-author').css('display', 'none');
           } else if (type == 2) {
            $('.translation-lang-author').css('display', 'block');
           } else if (type == 3) {
            $('.translation-lang-author').css('display', 'block');
           } else if (type == 4) {
            $('.translation-lang-author').css('display', 'block');
           }
       });
       //    $("document").ready(function() {
       //        setTimeout(function() {
       //            $("#countries").trigger('change');
       //        }, 10);
       //    });
       // Wait for the DOM to be fully loaded
       document.addEventListener("DOMContentLoaded", function() {
           // console.log('>>>>>>>>>>>');
           // Function to add/remove classes based on viewport width
           function handleViewportChange() {
               var body = document.body;

               if (window.innerWidth <= 1199.98) {
                   // Add the class "vertical-menu-modern" for screens up to 1199.98px wide
                   body.classList.remove("vertical-menu-modern");
                   body.classList.add("menu-expanded");
                   // Remove the class "vertical-overlay-menu" for screens up to 1199.98px wide
                   body.classList.remove("vertical-overlay-menu");
               } else {
                   // If viewport width is greater than 1199.98px, remove "vertical-menu-modern"
                   // and add "vertical-overlay-menu"
                   body.classList.remove("vertical-overlay-menu");
                   body.classList.add("vertical-menu-modern");
               }
           }

           // Initial call to handleViewportChange to set classes on page load
           handleViewportChange();

           // Listen for window resize events to update classes when the viewport width changes
           window.addEventListener("resize", handleViewportChange);
       });
   </script>

 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>

 <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/extensions/tether.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/extensions/shepherd.min.js') }}"></script>

 <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
 <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/datatables/datatable.js') }}"></script>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

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

 <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/pages/app-chat.js') }}"></script>

 <script src="{{ asset('app-assets/js/scripts/ui/data-list-view.js') }}"></script>

 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

 <script>
     //  $("#author_edit").select2({
     //      'tags': true
     //  });
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
             //  $('.dropdown-toggle').dropdown();
         });

         $('#ayat-table').DataTable({
             "processing": true,
             "stateSave": true,
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
             "stateSave": true,
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
                             des = row.description.slice(0, 50);
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
             "stateSave": true,
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
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-author') ?>',
                 data: {
                     type: $('#author-type').val()
                 }
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.name + '</td>'
                     }
                 },
                 //  {
                 //      "mRender": function(data, type, row) {
                 //          var des = '';
                 //          if (row.description != null) {
                 //              des = row.description;
                 //          }
                 //          return '<td>' +
                 //              des +
                 //              '</td>'
                 //      }
                 //  },
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
             "stateSave": true,
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
                         var opt1 = '';
                         var opt2 = '';
                         var opt3 = '';
                         if (row.status == 1) {
                             opt1 = 'selected';
                         } else if (row.status == 2) {
                             opt2 = 'selected';
                         } else if (row.status == 3) {
                             opt3 = 'selected';
                         }
                         return `<td>
                                    <div class="form-group">
                                        <select class="form-control" id="` + row.orderNumber +
                             `" onchange="orderOnChange(` + row.orderNumber + `)">
                                            <option ` + opt1 + ` value="1">Pending</option>
                                            <option ` + opt2 + ` value="2">Shipped</option>
                                            <option ` + opt3 + ` value="3">Completed</option>
                                        </select>
                                    </div>
                                   </td>`;
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
             "stateSave": true,
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

                 "orderable": false,
                 "defaultContent": "-",
                 "targets": "_all"
             }],
             "order": false
         });

         var ebooktable = $('#ebook-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },

             "ajax": {
                 url: '<?= url('all-book') ?>',
                 data: {
                     'type': $('#ajax-table-type').val(),
                 },
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

                 //  {
                 //      "mRender": function(data, type, row) {
                 //          var des = '';
                 //          if (row.description != null) {
                 //              des = row.description.slice(0, 50);
                 //          } else {
                 //              des = '--';
                 //          }
                 //          return '<td>' +
                 //              des +
                 //              '</td>'
                 //      }
                 //  },
                 {
                     "mRender": function(data, type, row) {
                         var category = '';
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--'
                         }
                         return '<td>' +
                             category + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var author = '';
                         if (row.author != null) {
                             author = row.author.name;
                         } else {
                             author = '--'
                         }
                         return '<td>' +
                             author + '</td>'
                     }
                 },
                 //  {
                 //      "mRender": function(data, type, row) {
                 //          var type = '';
                 //          if (row.type == 1) {
                 //              type = 'eBook';
                 //          }
                 //          if (row.type == 2) {
                 //              type = 'Audio Book';
                 //          }
                 //          if (row.type == 3) {
                 //              type = 'Research Paper';
                 //          }
                 //          if (row.type == 7) {
                 //              type = 'Podcast';
                 //          }
                 //          return '<td>' +
                 //              type +
                 //              '</td>'
                 //      }
                 //  },
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
                         var ptype = '';
                         if (row.p_type == "0") {
                             ptype = "Freemium";
                         } else {
                             ptype = "Premium";
                         }
                         return '<td>' +
                             ptype + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var user_name = '';
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
                         } else {
                             approver_name = '--'
                         }
                         return '<td>' +
                             approver_name + '</td>'
                     }
                 },
                 //    {
                 //        "mRender": function(data, type, row) {
                 //            return '<td>' +
                 //                row.numberOfUser + '</td>'
                 //        }
                 //    },
                 {
                     "mRender": function(data, type, row) {
                         var eye = 'feather icon-eye';
                         var list = '';
                         var edit = '';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         edit =
                             ` <a  class="ml-2" href="{{ url('book/`+ row.type +`/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>`;
                         if (row.type == 2) {
                             list =
                                 `<a class="ml-2" href="{{ url('book/`+ row.type +`/list/`+row._id+`') }}"> <i class="fa fa-list"> </i></a>`;

                         }
                         if (row.type == 7) {
                             list =
                                 `<a class="ml-2" href="{{ url('podcast/edit/`+row._id+`') }}"> <i class="fa fa-list"> </i></a>`;
                             edit = ``;
                         }
                         return `<td>
                            <div class="d-flex">
                               ` + edit +
                             list +
                             `<a  class="ml-2" href="{{ url('book/update-status/`+row._id+`') }}"><i class="` +
                             eye +
                             `"></i></a>

                                </div></td>`
                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         var category;
         var price;
         var aproval;
         var uncategorized = '';
         var author = '';
         $('#ajax-table-category').on('change', function() {
             // Get the selected category value
             price = $('#ajax-table-price').val() == null ? '' : $('#ajax-table-price').val();
             category = $(this).val() == null ? '' : $(this).val();
             aproval = $('#ajax-table-approval').val() == null ? '' : $('#ajax-table-approval').val();
             if ($('#ajax-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-table-author').val() == null ? '' : $('#ajax-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             ebooktable.ajax.url('<?= url('all-book') ?>?category=' + category + '&price=' + price +
                     '&aproval=' + aproval + '&uncategorized=' + uncategorized + '&author=' + author)
                 .load();
         });
         $('#ajax-table-price').on('change', function() {
             // Get the selected category value
             price = $(this).val() == null ? '' : $(this).val();
             category = $('#ajax-table-category').val() == null ? '' : $('#ajax-table-category').val();
             aproval = $('#ajax-table-approval').val() == null ? '' : $('#ajax-table-approval').val();
             author = $('#ajax-table-author').val() == null ? '' : $('#ajax-table-author').val();
             if ($('#ajax-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             ebooktable.ajax.url('<?= url('all-book') ?>?category=' + category + '&price=' + price +
                     '&aproval=' + aproval + '&uncategorized=' + uncategorized + '&author=' + author)
                 .load();
         });
         $('#ajax-table-approval').on('change', function() {
             // Get the selected category value
             price = $('#ajax-table-price').val() == null ? '' : $('#ajax-table-price').val();
             category = $('#ajax-table-category').val() == null ? '' : $('#ajax-table-category').val();
             aproval = $(this).val() == null ? '' : $(this).val();
             author = $('#ajax-table-author').val() == null ? '' : $('#ajax-table-author').val();
             if ($('#ajax-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             ebooktable.ajax.url('<?= url('all-book') ?>?category=' + category + '&price=' + price +
                     '&aproval=' + aproval + '&uncategorized=' + uncategorized + '&author=' + author)
                 .load();
         });
         $('#ajax-table-author').on('change', function() {
             // Get the selected category value
             price = $('#ajax-table-price').val() == null ? '' : $('#ajax-table-price').val();
             category = $('#ajax-table-category').val() == null ? '' : $('#ajax-table-category').val();
             author = $(this).val() == null ? '' : $(this).val();
             if ($('#ajax-uncategorized').is(':checked')) {
                 uncategorized = true
             }

             // Update the DataTable's AJAX URL with the selected category value
             ebooktable.ajax.url('<?= url('all-book') ?>?category=' + category + '&price=' + price +
                     '&aproval=' + aproval + '&uncategorized=' + uncategorized + '&author=' + author)
                 .load();
         });
         $('#ajax-uncategorized').on('change', function() {
             if ($(this).is(':checked')) {
                 // Get the selected category value
                 $('#ajax-table-category').prop('disabled', true);
                 console.log($(this).val());
                 price = $('#ajax-table-price').val() == null ? '' : $('#ajax-table-price').val();
                 category = '';
                 aproval = $('#ajax-table-approval').val() == null ? '' : $('#ajax-table-approval')
                     .val();
                 author = $('#ajax-table-author').val() == null ? '' : $('#ajax-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 ebooktable.ajax.url('<?= url('all-book') ?>?price=' + price +
                         '&aproval=' + aproval + '&uncategorized=' + true + '&author=' + author)
                     .load();
             } else {
                 $('#ajax-table-category').prop('disabled', false);
                 price = $('#ajax-table-price').val() == null ? '' : $('#ajax-table-price').val();
                 category = $('#ajax-table-category').val() == null ? '' : $('#ajax-table-category')
                     .val();
                 aproval = $('#ajax-table-approval').val() == null ? '' : $('#ajax-table-approval')
                     .val();
                 author = $('#ajax-table-author').val() == null ? '' : $('#ajax-table-author').val();

                 // Update the DataTable's AJAX URL with the selected category value
                 ebooktable.ajax.url('<?= url('all-book') ?>?category=' + category + '&price=' + price +
                         '&aproval=' + aproval + '&author=' + author)
                     .load();
             }
         });

         $('#hadees-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                             des = row.description.slice(0, 50);
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
             "stateSave": true,
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
                         if (row.phone == null) {
                             row.phone = '--';
                         }
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
                         } else if (row.type == 3) {
                             type = 'Institute';
                         } else {
                             type = 'Super Admin';
                         }
                         return '<td>' +
                             type + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var a = "";
                         if ("{{ auth()->user()->email }}" == row.email ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {

                             a = `<a href="#" class="reset-password ml-2" data-user-id="` + row
                                 ._id +
                                 `"><i class="fa fa-key"></i></a>`;
                         }

                         return `<td>

                                <a  class="ml-2" href="{{ url('user/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
                                <a  class="ml-2" href="{{ url('user/delete/`+row._id+`') }}"><i class="fa fa-trash"></i></a> ` +
                             a + `
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
             "stateSave": true,
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
             "stateSave": true,
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
                         var eye = 'feather icon-eye';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         var a = '';
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-2" href="{{ url('category/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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
                 'targets': [0, 1, 2],
                 "orderable": false
             }],
             "order": false
         });
         $('#inactive-category-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-inactive-category') ?>'
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
                         var eye = 'feather icon-eye';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         var a = '';
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-2" href="{{ url('category/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a>
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
                 'targets': [0, 1, 2],
                 "orderable": false
             }],
             "order": false
         });
         var pendinBookTable = $('#pending-book-table').DataTable({

             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-pending-book') ?>',
                 "data": function(d) {
                     d.type = $('#content-type').val();
                 }
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
                         var category = '';
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--'
                         }
                         return '<td>' +
                             category + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var author = '';
                         if (row.author != null) {
                             author = row.author.name;
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
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         var a = '';
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-1" href="{{ url('book/`+ row.type +`/edit/`+row._id+`?pending_for_approval=true') }}"><i class="fa fa-pencil" style="font-size:20px"></i></a>`;
                         }
                         if (row.type == 2) {
                             anchor =
                                 `<a class="ml-1" target="_blank" href="{{ url('book/`+ row.type +`/list/`+row._id+`?pending_for_approval=true') }}"> <i class="fa fa-list"  style="font-size:24px"> </i></a>`;
                         } else {
                             anchor =
                                 `<a  class="ml-1" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
                         }
                         return `<td class="d-flex">
                                <a  class="ml-1" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>` +
                             a +
                             `
                                <a href="#" class="ml-1"><i class="fa fa-times" onclick="reasonModal('${row._id}' ,1)" style="font-size:24px; cursor:pointer"  data-href=""></i></a>` +
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



         var pendingCoursesTable = $('#pending-courses-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-pending-courses') ?>'
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
                             des = row.description.slice(0, 50);
                         } else {
                             des = '--';
                         }
                         return '<td>' +
                             des +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var category = "";
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--';
                         }
                         return '<td>' +
                             category +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = "";
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-2" href="{{ url('course/edit/`+row._id+`?pending_for_approval=true') }}"><i class=" fa fa-list" style="font-size:24px"> </i></a>
                                   `;
                         }
                         return `<td><a  class="ml-1" href="{{ url('course/approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                            <a href="#" class="ml-1"><i class="fa fa-times" onclick="reasonModal('${row._id}' , 2)" style="font-size:24px; cursor:pointer"  data-href=""></i></a>` +
                             a +
                             `</td>`
                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         var category;
         var price;
         var uncategorized = '';
         var author = '';
         var contentType = '';

         $('#ajax-pending-content-type-table').on('change', function() {
             // Get the selected category value
             price = $('#ajax-pending-table-price').val() == null ? '' : $('#ajax-pending-table-price')
                 .val();
             category = $('#ajax-pending-table-category').val() == null ? '' : $(
                 '#ajax-pending-table-category').val();
             contentType = $(this).val() == null ? '' : $(this).val();

             if ($('#ajax-pending-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-pending-table-author').val() == null ? '' : $(
                 '#ajax-pending-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
             pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-pending-table-category').on('change', function() {
             // Get the selected category value
             price = $('#ajax-pending-table-price').val() == null ? '' : $('#ajax-pending-table-price')
                 .val();
             category = $(this).val() == null ? '' : $(this).val();
             contentType = $('#ajax-pending-content-type-table').val() == null ? '' : $(
                 '#ajax-pending-table-approval').val();

             if ($('#ajax-pending-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-pending-table-author').val() == null ? '' : $(
                 '#ajax-pending-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
             pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-pending-table-price').on('change', function() {
             // Get the selected category value
             price = $(this).val() == null ? '' : $(this).val();
             category = $('#ajax-pending-table-category').val() == null ? '' : $(
                 '#ajax-pending-table-category').val();
             contentType = $('#ajax-pending-content-type-table').val() == null ? '' : $(
                 '#ajax-pending-table-approval').val();

             author = $('#ajax-pending-table-author').val() == null ? '' : $(
                 '#ajax-pending-table-author').val();
             if ($('#ajax-pending-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
             pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });

         $('#ajax-pending-table-author').on('change', function() {
             // Get the selected category value
             price = $('#ajax-pending-table-price').val() == null ? '' : $('#ajax-pending-table-price')
                 .val();
             contentType = $('#ajax-pending-content-type-table').val() == null ? '' : $(
                 '#ajax-pending-table-approval').val();
             category = $('#ajax-pending-table-category').val() == null ? '' : $(
                 '#ajax-pending-table-category').val();
             author = $(this).val() == null ? '' : $(this).val();
             if ($('#ajax-pending-uncategorized').is(':checked')) {
                 uncategorized = true
             }

             // Update the DataTable's AJAX URL with the selected category value
             pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
             pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-pending-uncategorized').on('change', function() {
             if ($(this).is(':checked')) {
                 // Get the selected category value
                 $('#ajax-pending-table-category').prop('disabled', true);
                 console.log($(this).val());
                 price = $('#ajax-pending-table-price').val() == null ? '' : $(
                     '#ajax-pending-table-price').val();
                 category = '';
                 contentType = $('#ajax-pending-content-type-table').val() == null ? '' : $(
                     '#ajax-pending-table-approval').val();

                 author = $('#ajax-pending-table-author').val() == null ? '' : $(
                     '#ajax-pending-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + true + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
                 pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + true + '&author=' + author +
                         '&contentType=' + contentType)
                     .load();
             } else {
                 $('#ajax-pending-table-category').prop('disabled', false);
                 price = $('#ajax-pending-table-price').val() == null ? '' : $(
                     '#ajax-pending-table-price').val();
                 category = $('#ajax-pending-table-category').val() == null ? '' : $(
                         '#ajax-pending-table-category')
                     .val();
                 contentType = $('#ajax-pending-content-type-table').val() == null ? '' : $(
                     '#ajax-pending-table-approval').val();

                 author = $('#ajax-pending-table-author').val() == null ? '' : $(
                     '#ajax-pending-table-author').val();

                 // Update the DataTable's AJAX URL with the selected category value
                 pendinBookTable.ajax.url('<?= url('all-pending-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + false + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
                 pendingCoursesTable.ajax.url('<?= url('all-pending-courses') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + false + '&author=' + author +
                         '&contentType=' + contentType)
                     .load();
             }
         });
         $('#rejected-by-you-courses-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-rejected-by-you-courses') ?>'
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
                             des = row.description.slice(0, 50);
                         } else {
                             des = '--';
                         }
                         return '<td>' +
                             des +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var category = "";
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--';
                         }
                         return '<td>' +
                             category +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = "";
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
                         var eye = 'feather icon-eye';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-2" href="{{ url('course/edit/`+row._id+`') }}"><i class=" fa fa-list" > </i></a>
                                   `;
                         }
                         return `<td><a  class="ml-1" href="{{ url('course/approve/`+row._id+`') }}"><i class="fa fa-check" ></i></a>
                           ` +
                             a +
                             `</td>`
                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         $('#rejected-courses-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-rejected-courses') ?>'
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
                             des = row.description.slice(0, 50);
                         } else {
                             des = '--';
                         }
                         return '<td>' +
                             des +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var category = "";
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--';
                         }
                         return '<td>' +
                             category +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = "";
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-1" href="{{ url('course/edit/`+row._id+`') }}"><i class=" fa fa-list" > </i></a>
                                   `;
                         }
                         return `<td><a  class="ml-1" href="{{ url('course/approve/`+row._id+`') }}"><i class="fa fa-check" ></i>` +
                             a +
                             `</td>`
                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         $('#approved-by-you-courses-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-approved-by-you-courses') ?>'
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
                             des = row.description.slice(0, 50);
                         } else {
                             des = '--';
                         }
                         return '<td>' +
                             des +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var category = "";
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--';
                         }
                         return '<td>' +
                             category +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = "";
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--';
                         }
                         return '<td>' +
                             user_name +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
                         } else {
                             approver_name = '--'
                         }
                         return '<td>' +
                             approver_name + '</td>'
                     }
                 },

                 {
                     "mRender": function(data, type, row) {
                         var eye = 'feather icon-eye';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-2" href="{{ url('course/edit/`+row._id+`') }}"><i class=" fa fa-list" > </i></a> <a><i class="fa fa-times ml-1"  onclick="reasonModal('${row._id}' , 2)"  cursor:pointer"  data-href=""></i></a>
                                   `;
                         }
                         return `<td>
                           ` +
                             a +
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
             "stateSave": true,
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
                         return '<td>' +
                             row.title + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var des = '';
                         if (row.description != null) {
                             des = row.description.slice(0, 50);
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
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         if (row.fileType == 2 || row.fileType == 7) {
                             anchor =
                                 `<audio controls><source src="` + row.file + `"></audio>`;
                         } else {
                             anchor =
                                 `<a  class="ml-2" target="_blank" href="{{ url('grant/book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
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
             "stateSave": true,
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
                         if (row.user != null) {
                             user_name = row.user.name;
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
         $('#comments-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-comments') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         var comment = '--';
                         if (row.comment != null) {
                             comment = row.comment;
                         }
                         return '<td>' +
                             comment + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var rating = '--';
                         if (row.rating != null) {
                             rating = row.rating;
                         }
                         return '<td>' +
                             rating + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = '';
                         if (row.author != null) {
                             user_name = row.author;
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
                             `<a  class="ml-2"  href="{{ url('comment/approved/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                               <a  class="ml-2"  href="{{ url('comment/reject/`+row._id+`') }}"><i class="fa fa-times" style="font-size:24px"></i></a>`;

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
         $('#reflection-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-reflections') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         var comment = '--';
                         if (row.comment != null) {
                             comment = row.comment;
                         }
                         return '<td>' +
                             comment + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = '';
                         if (row.author != null) {
                             user_name = row.author;
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
                             `<a  class="ml-2"  href="{{ url('comment/approved/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                               <a  class="ml-2"  href="{{ url('comment/reject/`+row._id+`') }}"><i class="fa fa-times" style="font-size:24px"></i></a>`;

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
             "stateSave": true,
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
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
                         if (row.fileType == 2 || row.fileType == 7) {

                             anchor =
                                 `<audio controls><source src="` + row.file + `"></audio>`;
                         } else {
                             anchor =
                                 `<a  class="ml-2" target="_blank" href="{{ url('grant/book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
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
             "stateSave": true,
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
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
                         if (row.fileType == 2 || row.fileType == 7) {
                             anchor =
                                 `<audio controls><source src="` + row.file + `"></audio>`;
                         } else {
                             anchor =
                                 `<a  class="ml-2" target="_blank" href="{{ url('grant/book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
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
             "stateSave": true,
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
                         if (row.user != null) {
                             user_name = row.user.name;
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
                         if (row.reviewer != null) {
                             reviewed_by = row.reviewer.name;
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
                         if (row.fileType == 2 || row.fileType == 7) {
                             anchor =
                                 `<a  class="ml-2"  href="{{ url('review/`+row._id+`') }}"><i class="fa fa-comments-o"  style="font-size:24px"></i></a><audio controls><source src="` +
                                 row.file + `"></audio>`;
                         } else {
                             anchor =
                                 `<a  class="ml-2"  href="{{ url('review/`+row._id+`') }}"><i class="fa fa-comments-o"  style="font-size:24px"></i></a><a  class="ml-2" target="_blank" href="{{ url('review/book/view/`+row._id+`') }}"><i class="fa fa-eye" style="font-size:24px"></i></a>`;
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

         //epub additional review
         $('#book-addition-review-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-addition-review-book') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         var title = '';
                         if (row.bookTitle != null) {
                             title = row.bookTitle;
                         } else {
                             title = '--';
                         }
                         return '<td>' +
                             title + '</td>'
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
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var association = '';
                         if (row.association != null) {
                             association = row.association;
                         } else {
                             association = '--'
                         }
                         return '<td>' +
                             association + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var status = '';

                         if (row.status == 1) {
                             status = 'Approved';
                         } else if (row.status == 2) {
                             status = 'Rejected'
                         } else {
                             status = 'Pending'
                         }
                         return '<td>' +
                             status + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {

                         anchor =
                             `<a  class="ml-2"  href="{{ url('addition_review_approve/`+row._id+`') }}"><i class="fa fa-check" style="font-size:24px"></i></a>
                               <a  class="ml-2"  href="{{ url('addition_review_reject/`+row._id+`') }}"><i class="fa fa-times" style="font-size:24px"></i></a>`;

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
         var rejectedContent = $('#admin-rejected-book-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                         var category = '';
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--'
                         }
                         return '<td>' +
                             category + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var author = '';
                         if (row.author != null) {
                             author = row.author.name;
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
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
                         var a = '';
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-1" href="{{ url('book/`+ row.type +`/edit/`+row._id+`?rejected_by_you=true') }}"><i class="fa fa-pencil" ></i></a>`;
                         }
                         if (row.type == 2) {
                             anchor =
                                 `<a class="ml-1" target="_blank" href="{{ url('book/`+ row.type +`/list/`+row._id+`?rejected_by_you=true') }}"> <i class="fa fa-list"  > </i></a>`;
                         } else if (row.type == 7) {
                             anchor =
                                 `<a class="ml-1" href="{{ url('podcast/edit/`+row._id+`') }}"> <i class="fa fa-list"> </i></a>`;

                         } else {
                             anchor =
                                 `<a  class="ml-1" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" ></i></a>`;
                         }
                         return `<td class="d-flex">
                                <a  class="ml-1" href="{{ url('book/approve/`+row._id+`') }}"><i class="fa fa-check" ></i></a>` +
                             a +
                             `
                                ` +
                             anchor +
                             `</td>`
                     }
                 },
             ],
             "columnDefs": [{
                 'targets': [0, 1, 2, 3, 4, 5, 6, 7],
                 "orderable": false
             }],
             "order": false
         });

         var category;
         var price;
         var uncategorized = '';
         var author = '';
         var contentType = '';

         $('#ajax-rejected-content-type-table').on('change', function() {
             // Get the selected category value
             price = $('#ajax-rejected-table-price').val() == null ? '' : $('#ajax-rejected-table-price')
                 .val();
             category = $('#ajax-rejected-table-category').val() == null ? '' : $(
                 '#ajax-rejected-table-category').val();
             contentType = $(this).val() == null ? '' : $(this).val();

             if ($('#ajax-rejected-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-rejected-table-author').val() == null ? '' : $(
                 '#ajax-rejected-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-rejected-table-category').on('change', function() {
             // Get the selected category value
             price = $('#ajax-rejected-table-price').val() == null ? '' : $('#ajax-rejected-table-price')
                 .val();
             category = $(this).val() == null ? '' : $(this).val();
             contentType = $('#ajax-rejected-content-type-table').val() == null ? '' : $(
                 '#ajax-rejected-table-approval').val();

             if ($('#ajax-rejected-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-rejected-table-author').val() == null ? '' : $(
                 '#ajax-rejected-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-rejected-table-price').on('change', function() {
             // Get the selected category value
             price = $(this).val() == null ? '' : $(this).val();
             category = $('#ajax-rejected-table-category').val() == null ? '' : $(
                 '#ajax-rejected-table-category').val();
             contentType = $('#ajax-rejected-content-type-table').val() == null ? '' : $(
                 '#ajax-rejected-table-approval').val();

             author = $('#ajax-rejected-table-author').val() == null ? '' : $(
                 '#ajax-rejected-table-author').val();
             if ($('#ajax-rejected-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });

         $('#ajax-rejected-table-author').on('change', function() {
             // Get the selected category value
             price = $('#ajax-rejected-table-price').val() == null ? '' : $('#ajax-rejected-table-price')
                 .val();
             contentType = $('#ajax-rejected-content-type-table').val() == null ? '' : $(
                 '#ajax-rejected-table-approval').val();
             category = $('#ajax-rejected-table-category').val() == null ? '' : $(
                 '#ajax-rejected-table-category').val();
             author = $(this).val() == null ? '' : $(this).val();
             if ($('#ajax-rejected-uncategorized').is(':checked')) {
                 uncategorized = true
             }

             // Update the DataTable's AJAX URL with the selected category value
             rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-rejected-uncategorized').on('change', function() {
             if ($(this).is(':checked')) {
                 // Get the selected category value
                 $('#ajax-rejected-table-category').prop('disabled', true);
                 console.log($(this).val());
                 price = $('#ajax-rejected-table-price').val() == null ? '' : $(
                     '#ajax-rejected-table-price').val();
                 category = '';
                 contentType = $('#ajax-rejected-content-type-table').val() == null ? '' : $(
                     '#ajax-rejected-table-approval').val();

                 author = $('#ajax-rejected-table-author').val() == null ? '' : $(
                     '#ajax-rejected-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + true + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
             } else {
                 $('#ajax-rejected-table-category').prop('disabled', false);
                 price = $('#ajax-rejected-table-price').val() == null ? '' : $(
                     '#ajax-rejected-table-price').val();
                 category = $('#ajax-rejected-table-category').val() == null ? '' : $(
                         '#ajax-rejected-table-category')
                     .val();
                 contentType = $('#ajax-rejected-content-type-table').val() == null ? '' : $(
                     '#ajax-rejected-table-approval').val();

                 author = $('#ajax-rejected-table-author').val() == null ? '' : $(
                     '#ajax-rejected-table-author').val();

                 // Update the DataTable's AJAX URL with the selected category value
                 rejectedContent.ajax.url('<?= url('all-admin-rejected-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + false + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
             }
         });
         $('#rejected-book-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                             des = row.description.slice(0, 50);
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
                         var category = '';
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--'
                         }
                         return '<td>' +
                             category + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var author = '';
                         if (row.author != null) {
                             author = row.author.name;
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
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
         var adminApprovedContentTable = $('#approved-book-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                         var category = '';
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--'
                         }
                         return '<td>' +
                             category + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var author = '';
                         if (row.author != null) {
                             author = row.author.name;
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
                         if (row.user != null) {
                             user_name = row.user.name;
                         } else {
                             user_name = '--'
                         }
                         return '<td>' +
                             user_name + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var approver_name = '';
                         if (row.approver != null) {
                             approver_name = row.approver.name;
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
                         var a = '';
                         if ("{{ auth()->user()->hasRole('Admin') }}" ||
                             "{{ auth()->user()->hasRole('Super Admin') }}") {
                             a =
                                 `<a  class="ml-1" href="{{ url('book/`+ row.type +`/edit/`+row._id+`?approved=true') }}"><i class="fa fa-pencil" ></i></a>`;
                         }
                         if (row.type == 2) {
                             anchor =
                                 `<a class="ml-1" target="_blank" href="{{ url('book/`+ row.type +`/list/`+row._id+`?approved=true') }}"> <i class="fa fa-list"  > </i></a>`;
                         } else if (row.type == 7) {
                             anchor =
                                 `<a class="ml-1" href="{{ url('podcast/edit/`+row._id+`') }}"> <i class="fa fa-list"> </i></a>`;

                         } else {
                             anchor =
                                 `<a  class="ml-1" target="_blank" href="{{ url('book/view/`+row._id+`') }}"><i class="fa fa-eye" ></i></a>`;
                         }
                         return `<td class="d-flex" width:"150px !important;">  ` + anchor +
                             a +

                             `<a href="#" class="ml-1"><i class="fa fa-times" onclick="reasonModal('${row._id}' ,1)"  cursor:pointer"  data-href=""></i></a>
                              </td>`
                     }
                 },

             ],
             "columnDefs": [{
                 'targets': [0, 1, 2, 3, 4, 5, 6],
                 "orderable": false
             }],
             "order": false
         });
         var category;
         var price;
         var uncategorized = '';
         var author = '';
         var contentType = '';

         $('#ajax-approved-content-type-table').on('change', function() {
             // Get the selected category value
             price = $('#ajax-approved-table-price').val() == null ? '' : $('#ajax-approved-table-price')
                 .val();
             category = $('#ajax-approved-table-category').val() == null ? '' : $(
                 '#ajax-approved-table-category').val();
             contentType = $(this).val() == null ? '' : $(this).val();

             if ($('#ajax-approved-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-approved-table-author').val() == null ? '' : $(
                 '#ajax-approved-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             adminApprovedContentTable.ajax.url('<?= url('all-approved-book') ?>?category=' +
                     category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-approved-table-category').on('change', function() {
             // Get the selected category value
             price = $('#ajax-approved-table-price').val() == null ? '' : $('#ajax-approved-table-price')
                 .val();
             category = $(this).val() == null ? '' : $(this).val();
             contentType = $('#ajax-approved-content-type-table').val() == null ? '' : $(
                 '#ajax-approved-table-approval').val();

             if ($('#ajax-approved-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             author = $('#ajax-approved-table-author').val() == null ? '' : $(
                 '#ajax-approved-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             adminApprovedContentTable.ajax.url('<?= url('all-approved-book') ?>?category=' +
                     category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-approved-table-price').on('change', function() {
             // Get the selected category value
             price = $(this).val() == null ? '' : $(this).val();
             category = $('#ajax-approved-table-category').val() == null ? '' : $(
                 '#ajax-approved-table-category').val();
             contentType = $('#ajax-approved-content-type-table').val() == null ? '' : $(
                 '#ajax-approved-table-approval').val();

             author = $('#ajax-approved-table-author').val() == null ? '' : $(
                 '#ajax-approved-table-author').val();
             if ($('#ajax-approved-uncategorized').is(':checked')) {
                 uncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             adminApprovedContentTable.ajax.url('<?= url('all-approved-book') ?>?category=' +
                     category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });

         $('#ajax-approved-table-author').on('change', function() {
             // Get the selected category value
             price = $('#ajax-approved-table-price').val() == null ? '' : $('#ajax-approved-table-price')
                 .val();
             contentType = $('#ajax-approved-content-type-table').val() == null ? '' : $(
                 '#ajax-approved-table-approval').val();
             category = $('#ajax-approved-table-category').val() == null ? '' : $(
                 '#ajax-approved-table-category').val();
             author = $(this).val() == null ? '' : $(this).val();
             if ($('#ajax-approved-uncategorized').is(':checked')) {
                 uncategorized = true
             }

             // Update the DataTable's AJAX URL with the selected category value
             adminApprovedContentTable.ajax.url('<?= url('all-approved-book') ?>?category=' +
                     category +
                     '&price=' + price +
                     '&uncategorized=' + uncategorized + '&author=' + author +
                     '&contentType=' + contentType)
                 .load();
         });
         $('#ajax-approved-uncategorized').on('change', function() {
             if ($(this).is(':checked')) {
                 // Get the selected category value
                 $('#ajax-approved-table-category').prop('disabled', true);
                 console.log($(this).val());
                 price = $('#ajax-approved-table-price').val() == null ? '' : $(
                     '#ajax-approved-table-price').val();
                 category = '';
                 contentType = $('#ajax-approved-content-type-table').val() == null ? '' : $(
                     '#ajax-approved-table-approval').val();

                 author = $('#ajax-approved-table-author').val() == null ? '' : $(
                     '#ajax-approved-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 adminApprovedContentTable.ajax.url(
                         '<?= url('all-approved-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + true + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
             } else {
                 $('#ajax-approved-table-category').prop('disabled', false);
                 price = $('#ajax-approved-table-price').val() == null ? '' : $(
                     '#ajax-approved-table-price').val();
                 category = $('#ajax-approved-table-category').val() == null ? '' : $(
                         '#ajax-approved-table-category')
                     .val();
                 contentType = $('#ajax-approved-content-type-table').val() == null ? '' : $(
                     '#ajax-approved-table-approval').val();

                 author = $('#ajax-approved-table-author').val() == null ? '' : $(
                     '#ajax-approved-table-author').val();

                 // Update the DataTable's AJAX URL with the selected category value
                 adminApprovedContentTable.ajax.url(
                         '<?= url('all-approved-book') ?>?category=' + category +
                         '&price=' + price +
                         '&uncategorized=' + false + '&author=' +
                         author +
                         '&contentType=' + contentType)
                     .load();
             }
         });

         var courseTable = $('#courses-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                             des = row.description.slice(0, 50);
                         } else {
                             des = '--';
                         }
                         return '<td>' +
                             des +
                             '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var category = "";
                         if (row.category != null) {
                             category = row.category.title;
                         } else {
                             category = '--';
                         }
                         return '<td>' +
                             category +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var user_name = "";
                         if (row.user != null) {
                             user_name = row.user.name;
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
                 },
                 {
                     "mRender": function(data, type, row) {
                         var eye = 'feather icon-eye';
                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }
                         return `<td>
                                <a  class="ml-2" href="{{ url('course/edit/`+row._id+`') }}"><i class=" fa fa-list"></i></a>
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
         var courseCategory;
         var coursePrice;
         var courseAproval;
         var courseUncategorized = '';
         var courseAuthor = '';
         $('#course-ajax-table-category').on('change', function() {
             // Get the selected category value
             coursePrice = $('#course-ajax-table-price').val() == null ? '' : $(
                 '#course-ajax-table-price').val();
             courseCategory = $(this).val() == null ? '' : $(this).val();
             courseAproval = $('#course-ajax-table-approval').val() == null ? '' : $(
                 '#course-ajax-table-approval').val();
             courseAuthor = $('#course-ajax-table-author').val() == null ? '' : $(
                 '#course-ajax-table-author').val();
             if ($('#course-ajax-uncategorized').is(':checked')) {
                 courseUncategorized = true
             }
             // Update the DataTable's AJAX URL with the selected category value
             courseTable.ajax.url('<?= url('all-courses') ?>?category=' + courseCategory + '&price=' +
                     coursePrice +
                     '&aproval=' + courseAproval + '&uncategorized=' + courseUncategorized + '&author=' +
                     courseAuthor
                 )
                 .load();
         });

         $('#course-ajax-table-approval').on('change', function() {
             // Get the selected category value
             coursePrice = $('#course-ajax-table-price').val() == null ? '' : $(
                 '#course-ajax-table-price').val();
             courseCategory = $('#course-ajax-table-category').val() == null ? '' : $(
                 '#course-ajax-table-category').val();
             courseAproval = $(this).val() == null ? '' : $(this).val();
             if ($('#course-ajax-uncategorized').is(':checked')) {
                 courseUncategorized = true
             }
             courseAuthor = $('#course-ajax-table-author').val() == null ? '' : $(
                 '#course-ajax-table-author').val();
             // Update the DataTable's AJAX URL with the selected category value
             courseTable.ajax.url('<?= url('all-courses') ?>?category=' + courseCategory + '&price=' +
                     coursePrice +
                     '&aproval=' + courseAproval + '&uncategorized=' + courseUncategorized + '&author=' +
                     courseAuthor
                 )
                 .load();
         });
         $('#course-ajax-table-author').on('change', function() {
             // Get the selected category value
             coursePrice = $('#course-ajax-table-price').val() == null ? '' : $(
                 '#course-ajax-table-price').val();
             courseCategory = $('#course-ajax-table-category').val() == null ? '' : $(
                 '#course-ajax-table-category').val();
             courseAuthor = $(this).val() == null ? '' : $(this).val();
             if ($('#course-ajax-uncategorized').is(':checked')) {
                 courseUncategorized = true
             }
             courseAproval = $('#course-ajax-table-approval').val() == null ? '' : $(
                 '#course-ajax-table-approval').val();

             // Update the DataTable's AJAX URL with the selected category value
             courseTable.ajax.url('<?= url('all-courses') ?>?category=' + courseCategory + '&price=' +
                     coursePrice +
                     '&aproval=' + courseAproval + '&uncategorized=' + courseUncategorized + '&author=' +
                     courseAuthor
                 )
                 .load();
         });
         $('#course-ajax-uncategorized').on('change', function() {
             if ($(this).is(':checked')) {
                 // Get the selected category value
                 $('#course-ajax-table-category').prop('disabled', true);
                 console.log($(this).val());
                 coursePrice = $('#course-ajax-table-price').val() == null ? '' : $(
                     '#course-ajax-table-price').val();
                 courseCategory = '';
                 courseAproval = $('#course-ajax-table-approval').val() == null ? '' : $(
                         '#course-ajax-table-approval')
                     .val();
                 courseAuthor = $('#course-ajax-table-author').val() == null ? '' : $(
                     '#course-ajax-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 courseTable.ajax.url('<?= url('all-courses') ?>?category=' + courseCategory +
                         '&price=' +
                         coursePrice +
                         '&aproval=' + courseAproval + '&uncategorized=' + true + '&author=' +
                         courseAuthor
                     )
                     .load();
             } else {
                 $('#course-ajax-table-category').prop('disabled', false);
                 coursePrice = $('#course-ajax-table-price').val() == null ? '' : $(
                     '#course-ajax-table-price').val();
                 courseCategory = $('#course-ajax-table-category').val() == null ? '' : $(
                         '#course-ajax-table-category')
                     .val();
                 courseAproval = $('#course-ajax-table-approval').val() == null ? '' : $(
                         '#course-ajax-table-approval')
                     .val();
                 courseAuthor = $('#course-ajax-table-author').val() == null ? '' : $(
                     '#course-ajax-table-author').val();
                 // Update the DataTable's AJAX URL with the selected category value
                 courseTable.ajax.url('<?= url('all-courses') ?>?category=' + courseCategory +
                         '&price=' +
                         coursePrice +
                         '&aproval=' + courseAproval + '&author=' +
                         courseAuthor
                     )
                     .load();
             }
         });
         $('#support-table').DataTable({
             "processing": true,
             "stateSave": true,
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
             "stateSave": true,
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

                         var sentence = `${row.user.name} Has ${row.key} (${row.title})`;
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
             "stateSave": true,
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
         $('#app-versions-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('app/all-versions') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {

                         return '<td>' +
                             row.app_version + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.andriod + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.ios + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             new Date(row.created_at).toDateString() + '</td>'
                     }
                 }
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });

         $('#notification-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-notification') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.heading + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.notification + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         // Create a new Date object from the timestamp string
                         const dateObject = new Date(row.created_at);

                         // Get the date in the desired format (YYYY-MM-DD)
                         const formattedDate = dateObject.toISOString().split('T')[0];
                         return '<td>' +
                             formattedDate + '</td>'
                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         $('#popup-table').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all-popup') ?>'
             },
             "columns": [{
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.title + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.text + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var device = 'Mobile App';
                         if (row.device == 2) {
                             device = 'Web App';
                         }
                         return '<td>' +
                             device + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var plan = 'Freemium';
                         if (row.plan == 2) {
                             plan = 'Individual';
                         } else if (row.plan == 3) {
                             plan = 'Family';

                         } else if (row.plan == 4) {
                             plan = 'Big Family';
                         }
                         return '<td>' +
                             plan + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var start = row.start;
                         if (row.start == undefined) {
                             start = '--';

                         }
                         return '<td>' +
                             start + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var interval = row.interval;
                         if (row.interval == undefined) {
                             interval = '--';

                         }
                         return '<td>' +
                             interval; + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         var eye = 'feather icon-eye';

                         if (row.status == 0) {
                             eye = 'feather icon-eye-off';
                         }

                         return `<td>
                                <a  class="ml-2" href="{{ url('popup/edit/`+row._id+`') }}"><i class="feather icon-edit-2"></i></a> <a  class="ml-2" href="{{ url('popup/update-status/`+row._id+`') }}"><i class="` +
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

         var clipboard = new ClipboardJS('.copy-btn');
         // Listen for success event
         clipboard.on('success', function(e) {
             // Change tooltip text to "Copied"
             e.trigger.setAttribute('title', 'Copied');
             // Reinitialize Bootstrap tooltip
             //  $(e.trigger).tooltip('show');
             // After 3 seconds, revert the tooltip text back to "Copy URL"
             setTimeout(function() {
                 e.trigger.setAttribute('title', 'Copy URL');
                 $(e.trigger).tooltip('hide');
             }, 1000); // Change the delay time to 3000 milliseconds (3 seconds)
         });
         $('.copy-btn').tooltip();

         $('#coupon-table').DataTable({

             "processing": true,
             "stateSave": true,
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
                         return '<td>' +
                             row.p_code + '</td>'
                     }
                 }, {
                     "mRender": function(data, type, row) {
                         return '<td>' +
                             row.percentage + '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         let copyIcon =
                             `<a class="ml-2 copy-btn" data-toggle="tooltip" data-placement="top" data-clipboard-text="https://app.trueilm.com/sing-up?p_code=${row.p_code}" title="Copy URL"><i class="fa fa-copy" ></i></a>`
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
             $('.spinner-border').css('display', 'block');
             $('.submit-text').css('display', 'none');
         });
         $('.disable-btn-submit').on('submit', function() {
             // alert('imran');
             $('.submit-btn').prop('disabled', 'true');
             $('.spinner-border').css('display', 'block');
             $('.submit-text').css('display', 'none');
         });
         var appUserTable = $('#app-user-table').DataTable({
             "processing": true,
             "stateSave": true,
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
                         phone = '--';
                         if (row.phone != undefined) {
                             phone = row.phone
                         }
                         return '<td>' +
                             phone + '</td>'

                     }
                 }, {
                     "mRender": function(data, type, row) {
                         var status = row.status;
                         //  if (row.status == 0) {
                         //      status = 'Not Subscribed';
                         //  } else {
                         //      status = 'Subscribed';

                         //  }
                         return '<td>' +
                             status +
                             '</td>'
                     }
                 },
                 {
                     "mRender": function(data, type, row) {
                         return `<td>
                                <a  class="ml-2" href="{{ url('app-user/books_reading_details/`+row._id+`') }}"><i class="fa fa-info-circle" style="font-size:24px"></i></a>
                                <a  class="ml-2" href="{{ url('app-user/profile/`+row._id+`') }}"><i class="fa fa-user" style="font-size:24px"></i></a>
                               </td>`;

                     }
                 },
             ],
             "columnDefs": [{

                 "orderable": false
             }],
             "order": false
         });
         $('#user-ajax-table-unsubscribed').on('change', function() {
             if ($(this).is(':checked')) {
                 $('#user-ajax-table-plan-type').prop('disabled', true);

                 appUserTable.ajax.url('<?= url('all-app-user') ?>?unsubscribed=' + true)
                     .load();
             } else {
                 $('#user-ajax-table-plan-type').prop('disabled', false);

                 appUserTable.ajax.url('<?= url('all-app-user') ?>?unsubscribed=')
                     .load();
             }

         });
         $('#user-ajax-table-plan-type').on('change', function() {
             planType = $(this).val() == null ? '' : $(this).val();

             appUserTable.ajax.url('<?= url('all-app-user') ?>?planType=' + planType)
                 .load();

         });
         $('#cancel-subsciption').DataTable({
             "processing": true,
             "stateSave": true,
             "serverSide": true,
             "deferRender": true,
             "language": {
                 "searchPlaceholder": "Search here"
             },
             "ajax": {
                 url: '<?= url('all/cancel_subscriptions') ?>'
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
                             'Cancelled' +
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
             "stateSave": true,
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
                 //  {
                 //      "mRender": function(data, type, row) {
                 //          return '<td>' +
                 //              row.phone + '</td>'
                 //      }
                 //  },
                 //  {
                 //      "mRender": function(data, type, row) {
                 //          var status = '';
                 //          if (row.status == 0) {
                 //              status = 'Not Subscribed';
                 //          } else {
                 //              status = 'Subscribed';

                 //          }
                 //          return '<td>' +
                 //              status +
                 //              '</td>'
                 //      }
                 //  },
                 //  <a  class="ml-2" href="{{ url('app-user/books_reading_details/`+row._id+`') }}"><i class="fa fa-info-circle" style="font-size:24px"></i></a>
                 {
                     "mRender": function(data, type, row) {
                         return `<td>
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
     $('#series-table').DataTable({
         "processing": true,
         "stateSave": true,
         "serverSide": true,
         "deferRender": true,
         "language": {
             "searchPlaceholder": "Search here"
         },
         "ajax": {
             url: '<?= url('all-series') ?>'
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
                         des = row.description.slice(0, 50);
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
                         (row.courses).length + '</td>'
                 }
             },
             {
                 "mRender": function(data, type, row) {
                     var eye = 'feather icon-eye';
                     if (row.status == 0) {
                         eye = 'feather icon-eye-off';
                     }
                     return `<td>
                                <a  class="ml-2" href="{{ url('series/edit/`+row._id+`') }}"><i class="fa fa-pencil"></i></a>
                                <a  class="ml-2" href="{{ url('series/update-status/`+row._id+`') }}"><i class="` +
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
         window.location.reload();
     }

     function editable(key) {

         $('#edit-button-' + key).css('display', 'none');
         $('#save-button-' + key).css('display', 'block');
         $('#revelation-save-button-' + key).css('display', 'none');
         $('#revelation-edit-button-' + key).css('display', 'block');

         $('#revelation-delete-button-' + key).css('display', 'none');
         $('#delete-button-' + key).css('display', 'block');
         $('#non-editble-translation-' + key).css('display', 'none');
         $('#non-edit-para-des-' + key).css('display', 'none');
         $('#editble-' + key).css('display', 'block');
         $('#bold-revelation-' + key).css('display', 'none');
         $('#revelation-editble-' + key).css('display', 'none');
         $('#notes-save-button-' + key).css('display', 'none');
         $('#notes-delete-button-' + key).css('display', 'none');
         $('#notes-edit-button-' + key).css('display', 'block');
         $('#bold-notes-' + key).css('display', 'none');
         $('#notes-editble-' + key).css('display', 'none');

     }


     function editableRevelation(key) {
         $('#revelation-edit-button-' + key).css('display', 'none');
         $('#edit-button-' + key).css('display', 'block');
         $('#save-button-' + key).css('display', 'none');
         $('#delete-button-' + key).css('display', 'none');
         $('#revelation-save-button-' + key).css('display', 'block');
         $('#revelation-delete-button-' + key).css('display', 'block');
         $('#non-editble-translation-' + key).css('display', 'none');
         $('#non-edit-para-des-' + key).css('display', 'none');
         $('#editble-' + key).css('display', 'block');
         $('#bold-revelation-' + key).css('display', 'none');
         $('#editble-' + key).css('display', 'none');
         $('#revelation-editble-' + key).css('display', 'block');

     }

     function editableNotes(key) {
         $('#notes-edit-button-' + key).css('display', 'none');
         $('#edit-button-' + key).css('display', 'block');
         $('#save-button-' + key).css('display', 'none');
         $('#delete-button-' + key).css('display', 'none');
         $('#notes-save-button-' + key).css('display', 'block');
         $('#notes-delete-button-' + key).css('display', 'block');
         $('#non-editble-translation-' + key).css('display', 'none');
         $('#non-edit-para-des-' + key).css('display', 'none');
         $('#editble-' + key).css('display', 'block');
         $('#bold-notes-' + key).css('display', 'none');
         $('#editble-' + key).css('display', 'none');
         $('#notes-editble-' + key).css('display', 'block');

     }

     function saveTranslation(authorLang, key, type) {
         window.location.reload();

         $('#spinner-grow-' + key).css('display', 'block');
         $('#textarea-div-' + key).css('display', 'none');
         $('#revelation-editble-' + key).css('display', 'none');
         $('#notes-editble-' + key).css('display', 'none');
         //    alert('ok');
         var lang = $('#lang-select-' + key).val();
         var translation = $('#trans-input-' + key).val();
         var transId = $('#trans-id-' + key).val();
         if (type == 3) {
             translation = $('#notes-trans-input-' + key).val();
             transId = $('#notes-trans-id-' + key).val();
         } else if (type == 4) {
             translation = $('#revelation-trans-input-' + key).val();
             transId = $('#revelation-trans-id-' + key).val();
         }
         var ayatId = $('#ayat-id-' + key).val();
         //    var type = $('#type-' + key).val();
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
                 $('#textarea-div-' + key).css('display', 'block');
                 $('#non-edit-para-des-' + key).css('display', 'none');
                 //    console.log(response);
                 $('#non-edit-lang-select-' + key).html(response.lang_title);
                 $('#trans-input-' + key).val(response.translation);
                 $('#non-edit-para-des-' + key).html(response.translation);
                 $('#non-edit-para-des-' + key).css('display', 'block');
                 $('#editble-' + key).css('display', 'none');
                 $('#spinner-grow-' + key).css('display', 'none');
                 $('#revelation-editble-' + key).css('display', 'none');
                 //    $('#non-editble-translation-' + key).css('display', 'block');
             }

         });
     }

     //    function addTranslation(ayatId) {
     //        $('#no-translation-div').css('display', 'none');
     //        var opt = null;
     //        $.ajax({
     //            type: "GET",
     //            url: "{{ url('languages') }}",
     //            dataType: "json",
     //            success: function(response) {
     //                response.forEach(function(e) {
     //                    //    opt = response;
     //                    opt += `<option value="${e._id}">${e.title}</option>`;
     //                })
     //                var div = $('.lang');
     //                var lang = div.length;
     //                var html;
     //                html = `

    //                     <div class="col-12 lang translation-div-${lang}">

    //                                 <div class="card" >
    //                                 <div class="card-body">
    //                                     <div class="row">
    //                         <div class="col-8 ">
    //                             <h4 id="translation-saved-span-${lang }"
    //                                 style="display:none"> <span
    //                                     class="badge badge-success "><i
    //                                         class="fa fa-check">Translation
    //                                         Saved</i></span></h4>
    //                         </div>
    //                         <div class="col-4 d-flex">

    //                             <h4
    //                                 onclick="saveNewTranslation('${ayatId}','${lang }')">
    //                                 <span class="badge badge-success ml-1"><i
    //                                         class="fa fa-save">&nbspSave</i></span>
    //                             </h4>
    //                             <h4
    //                                 onclick="deleteNewTranslation('${lang }')">
    //                                 <span class="badge badge-danger ml-1"><i
    //                                         class="fa fa-trash">&nbspDelete</i></span>
    //                             </h4>
    //                         </div>
    //                     </div>
    //                         <p>Language</p>
    //                         <fieldset class="form-group">
    //                             <select class="select2 form-control" name="langs[]" required id="new-lang-select-${lang}">
    //                                 <option value="" selected>Please Select Language</option>
    //                                 ${opt}
    //                             </select>
    //                         </fieldset>
    //                         </div>
    //                         <div class="col-12">
    //                             <label for="">Translation</label>
    //                             <fieldset class="form-group">
    //                                 <textarea class="summernote" required name="translations[]" id="new-description-${lang}"></textarea>
    //                             </fieldset>
    //                     </div>
    //                 </div>
    //             </div>

    //             </div>
    //             `;

     //                $('.append-inputs').append(html);
     //                $('.summernote').summernote({
     //                    height: 150,
     //                    codemirror: {
     //                        theme: 'default'
     //                    },
     //                    toolbar: [
     //                        // [groupName, [list of button]]
     //                        ['style', ['bold', 'italic', 'underline', 'clear']],
     //                        ['font', ['strikethrough', 'superscript', 'subscript']],
     //                        ['fontsize', ['fontsize', 'fontname']],
     //                        ['color', ['color']],
     //                        ['para', ['ul', 'ol', 'paragraph']],
     //                        ['height', ['height']]
     //                    ]
     //                });
     //                $('#new-lang-select-' + lang).select2({
     //                    tags: true
     //                });
     //            },
     //        });
     //        console.log(opt);

     //    }

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
         $('#file-new-lang-select-' + key).html('<option value="" selected disabled>Loading...</option>');

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
         //    window.location.reload();

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

     function saveHadithTranslation(authorLang, key, type) {
         window.location.reload();
         $('#spinner-grow-' + key).css('display', 'block');
         var lang = $('#lang-select-' + key).val();
         var translation = $('#trans-input-' + key).val();
         var hadith_id = $('#ayat-id-' + key).val();
         var book_id = $('#book_id').val();
         //    var transId = $('#trans-id-' + key).val();

         $('#textarea-div-' + key).css('display', 'none');
         $('#revelation-editble-' + key).css('display',
             'none');
         $('#notes-editble-' + key).css('display', 'none');
         //    alert('ok');
         var lang = $('#lang-select-' + key).val();
         //    var translation = $('#trans-input-' + key).val();
         var transId = $('#trans-id-' + key).val();
         if (type == 3) {
             translation = $('#notes-trans-input-' + key).val();
             transId = $('#notes-trans-id-' + key).val();
         } else if (type == 4) {
             translation = $('#revelation-trans-input-' + key).val();
             transId = $('#revelation-trans-id-' + key).val();
         }


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
                 type: type,
                 book_id: book_id
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

     function reasonModal(key, type) {

         if (type == 1) {
             $('#book_id').val(key);
             var newUrl = "{{ url('book/reject/') }}" + '/' + key;
             $('#reason_form').attr('action', newUrl);
         } else {
             $('#course_id').val(key);
             var newUrl = "{{ url('course/reject/') }}" + '/' + key;
             $('#reason_form').attr('action', newUrl);
         }


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
             $('.price').css("display", "block");
             $('.sample-file').css("display", "block");
             console.log(val);
         } else {
             $('.price').css("display", 'none');
             $('.sample-file').css("display", 'none');
             console.log(val);

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
                 var option = `<option value="` + response._id + `">` + response.title +
                     `</option>`;
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
                         html +=
                             `<option selected value="${element}">${element} </option>`;
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

     function orderOnChange(orderNo) {
         var status = $('#' + orderNo).val();
         console.log();
         $.ajax({
             type: "GET",
             url: "{{ url('order/change_status') }}",
             data: {
                 orderNo: orderNo,
                 status: status,
             },
             dataType: "json",
             success: function(response) {
                 //    console.log(response);
                 //    location.reload();
                 $('#order_status_changed').css('display', 'block');
                 setTimeout(() => {
                     $('#order_status_changed').css('display', 'none');

                 }, 4000);
             }
         });
     }
     $('#add-podcast-episode').on('click', function() {
         $('#episodes-heading').css('display', 'block')
         var length = $('.episode-custom-file-input').length;
         console.log(length);
         var html;
         html =
             ` <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Title</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="episode_title[]" placeholder=""
                                                                        required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>  <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Host</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="host[]" placeholder=""
                                                                        required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>  <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Guest</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="guest[]" placeholder=""
                                                                        required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Content</label>
                                                            <div class="custom-file">
                                                                <input type="file"  class="custom-file-input  episode-custom-file-input" id="fileinput` +
             length + `" onchange="duration(` + length +
             `)"
                                                                    onchange="" name="podcast_file[]" required
                                                                    multiple>
                                                                    <input type="hidden" name="duration[]" id="input-duration-` +
             length + `" />
                                                                    <span id="duration-info-` + length + `"></span>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    `;
         $('.episode-append-inputs').append(html);
         $('.summernote').summernote();
     });

     function example(lenght) {
         let vid = document.getElementById("episode-custom-file-input" + lenght);
         console.log(vid);
     }
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
     async function calculateDurations(files) {
         var durationPromises = [];

         for (let i = 0; i < files.length; i++) {
             const file = files[i];
             const audio = new Audio();

             durationPromises.push(new Promise((resolve, reject) => {
                 audio.addEventListener('loadedmetadata', function() {
                     var audioDuration = audio.duration;
                     var mFloor = Math.floor(audioDuration / 60);
                     var sFloor = Math.floor(audioDuration % 60);


                     let minutes =
                         String(mFloor).padStart(2, '0');
                     let seconds =
                         String(sFloor).padStart(2, '0');
                     var duration = {
                         minutes,
                         seconds
                     };

                     //    console.log('Audio duration for file ' + i + ':', minutes + ' minutes ' +
                     //        seconds);
                     resolve(duration);
                 });

                 audio.src = URL.createObjectURL(file);
                 audio.load();
             }));
         }

         return Promise.all(durationPromises);
     }

     async function multiduration() {
         var fileInputs = $('.file-input');
         console.log(fileInputs);

         var durationPromises = [];

         fileInputs.each(function(index, fileInput) {
             const files = fileInput.files;

             if (files.length > 0) {
                 durationPromises.push(calculateDurations(files));
             }
         });

         // Wait for all promises to resolve
         var durations = await Promise.all(durationPromises);

         console.log(durations);

         // Flatten the array of arrays to a single array of durations
         durations = durations.flat();

         // Set the array of durations in the hidden input
         $('[name="duration[]"]').val(JSON.stringify(durations));
     }



     function editEpisodeModal(key) {
         var title = $('#title' + key).html();
         var host = $('#host' + key).html();
         var description = $('#description' + key).html();
         var guest = $('#guest' + key).html();
         var epi_id = $('#episode_id' + key).val();
         var sequence = $('#sequence' + key).val();
         $('#modal-episode-guest').val(guest);
         $('#modal-episode-host').val(host);
         $('#modal-episode-title').val(title);
         $('#modal-episode-description').val(description);
         $('#modal-episode-id').val(epi_id);
         $('#modal-episode-sequence').val(sequence);
         $('#edit-episode').modal('show');

     }

     function editLessonModal(key) {
         var title = $('#title' + key).html();
         var description = $('#description' + key).html();
         var epi_id = $('#episode_id' + key).val();
         var les_id = $('#les_id' + key).val();
         var sequence = $('#sequence' + key).val();
         var kwl = $('#kwl' + key).val();
         $('#modal_lesson_description').html(description);
         $('#modal-lesson-title').val(title.trim());
         $('#course_id').val(epi_id);
         $('#les_id').val(les_id);
         $('#edit-episode').modal('show');
         $('#modal-episode-sequence').val(sequence);
         if (kwl == 1) {
             $('#modal-episode-kwl').prop('checked', true);
         }
     }

     function addQuestion() {
         var html;
         var count = $('.question').length
         html = `<div class="card lessonAddQuestionDiv-` + count +
             `">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row append-inputs">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                <div class="col-12">


                                                                            <span> <h6> Question :<i class="fa fa-trash" onclick="removelessondiv(` +
             count + `)"></i></h6></span>


                                                                </div>
                                                                </div>

                                                                <div class="position-relative">
                                                                    <input type="text" id="question"
                                                                        class="form-control" name="question[]" required
                                                                        placeholder="" required>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <h6>Correct Options:</h6>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <h6>Incorrect Options:</h6>
                                                                    </div>

                                                                </div>
                                                                <div class="row col-12 m-0 p-0">
                                                                    <div class="col-6 d-flex m-0 p-0">
                                                                        <div class="col- m-0 p-0">
                                                                            <input type="text" id="question"
                                                                                class="form-control" name="correct-` +
             count +
             `[]"
                                                                                required placeholder="" required>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="text"
                                                                                class="question form-control" name="correct-` +
             count +
             `[]"
                                                                                required placeholder="" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6 m-0 p-0">
                                                                        <div class="col-12  d-flex m-0 p-0">
                                                                            <div class="col-6 ">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count +
             `[]"
                                                                                    required placeholder="" required>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count +
             `[]"
                                                                                    required placeholder="" required>
                                                                            </div>


                                                                        </div>
                                                                        <br>
                                                                        <div class="col-12  d-flex m-0 p-0">
                                                                            <div class="col-6 ">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count +
             `[]"
                                                                                    required placeholder="" required>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count +
             `[]"
                                                                                    required placeholder="" required>
                                                                            </div>


                                                                        </div> <br>

                                                                        <div class="col-12  d-flex m-0 p-0">
                                                                            <div class="col-6">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count +
             `[]"
                                                                                    required placeholder="" required>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" id="question"
                                                                                    class="form-control" name="incorrect-` +
             count + `[]"
                                                                                    required placeholder="" required>
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
                                    </div>`;

         $('.input_append').append(html);
     }

     $('form').on('submit', function() {
         if ($('input:focus').length) {
             return false;
         }
     });

     function removelessondiv(key) {
         $(".lessonAddQuestionDiv-" + key).remove();
     }
     $('#user-table').on('click', '.reset-password', function() {
         var userId = $(this).data('user-id');

         // Open the modal with the form
         $('#resetPasswordModal').modal('show');

         // Attach the user ID to the modal for reference
         $('#resetPasswordModal').data('user-id', userId);
     });

     // Event listener for the form submission
     $('#resetPasswordForm').submit(function(e) {
         var newPassword = $('#newPassword').val();
         var confirmPassword = $('#confirmPassword').val();
         var userId = $('#resetPasswordModal').data('user-id');
         $('#user_id').val(userId);
         if (newPassword == confirmPassword) {

         } else {
             e.preventDefault();
             $('#did-not-match').css('display', 'block')
         }
     });

     //    $('#resetPasswordForm').submit(function(e) {
     //        e.preventDefault();

     //        var userId = $('#resetPasswordModal').data('user-id');
     //        var newPassword = $('#newPassword').val();
     //        var confirmPassword = $('#confirmPassword').val();

     //        if (newPassword == confirmPassword) {
     //            $(this).submit();
     //            $('#resetPasswordModal').modal('hide');
     //        }
     //        // Validate passwords and make an AJAX request
     //        //    $.ajax({
     //        //        url: 'reset-password',
     //        //        method: 'POST',

     //        //        data: {
     //        //            _token: $('meta[name="csrf-token"]').attr('content'),
     //        //            newPassword: newPassword,
     //        //            newPassword_confirmation: confirmPassword, // Laravel expects "_confirmation" for password confirmation
     //        //            userId: userId, // Laravel expects "_confirmation" for password confirmation
     //        //        },
     //        //        success: function(response) {
     //        //            // Handle success, e.g., show a success message
     //        //            console.log(response.message);
     //        //        },
     //        //        error: function(error) {
     //        //            // Handle errors, e.g., display validation errors
     //        //            console.log(error.responseJSON.errors);
     //        //        }
     //        //    });

     //        // Close the modal

     //    });

     function makeInput(key) {
         //    alert('ok');
         $('#name-span-' + key).css('display', 'none');
         $('#name-input-div-' + key).css('display', 'flex');
     }

     function saveFileName(id, key) {
         var name = $('#input-' + key).val();

         $.ajax({
             url: '/update/audio/name',
             method: 'GET',

             data: {
                 content_id: id,
                 name: name
             },
             success: function(response) {
                 $('#name-span-' + key).html(name);
                 $('#name-span-' + key).css('display', 'block');
                 $('#name-input-div-' + key).css('display', 'none');
             },
             error: function(error) {
                 // Handle errors, e.g., display validation errors
                 console.log(error.responseJSON.errors);
             }
         });
     }

     function saveFileNameCourses(id, key) {
         var name = $('#input-' + key).val();
         var sequence = $('#input-seq-' + key).val();

         $.ajax({
             url: '/update/lesson/title',
             method: 'GET',

             data: {
                 content_id: id,
                 name: name,
                 sequence: sequence
             },
             success: function(response) {
                 $('#name-span-' + key).html(name);
                 $('#name-span-' + key).css('display', 'block');
                 $('#name-input-div-' + key).css('display', 'none');
             },
             error: function(error) {
                 // Handle errors, e.g., display validation errors
                 console.log(error.responseJSON.errors);
             }
         });
     }
     $('#languages-table').DataTable({
         "stateSave": true
     });
     $('.datatable').DataTable({
         "stateSave": true,
         'ordering': false
     });

     $('input[name="institute_type"]').on("change", function(event) {
         var type = $('input[name="institute_type"]:checked').val();
         if (type == 2) {
             console.log(type);
             $('#plan_form').css('display', 'block')
             $('#bulk_plan_form').css('display', 'none')
         } else {
             $('#bulk_plan_form').css('display', 'block')
             $('#plan_form').css('display', 'none');

         }
     });



     function showType() {
         var role = $('#role-dropdown').val();
         if (role == 'Institute') {
             console.log(role);
             $('.radio_for_institute_type').css('display', 'block')
             $('#bulk_plan_form').css('display', 'block')
         } else {
             $('.radio_for_institute_type').css('display', 'none');
             $('#bulk_plan_form').css('display', 'none')

         }
     }
     //  $(".select2").select2({
     //      dropdownParent: $("#add-episode")
     //  });
     //  $(".select2").select2({
     //      dropdownParent: $("#edit-episode")
     //  });
     //  $(".select2").select2({
     //      dropdownParent: $("#author-lang")
     //  });
     $('.select2').each(function() {
         $(this).select2({
             dropdownParent: $(this).parent()
         });
     })
 </script>

<!DOCTYPE html>
<html class="loading" data-textdirection="rtl">
<!-- BEGIN: Head-->
@include('includes.css')


<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>True ILM</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- BEGIN: Vendor CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
    <!-- END: Vendor CSS-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/tour/tour.css') }}">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-list-view.css') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-list-view.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-chat.css') }}">
    <!-- END: Page CSS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Text Box Liabraries-->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(function(OneSignal) {
            OneSignal.init({
                appId: "ecc4d9fa-c42f-4e68-8c62-024c4530a5d4",
                notifyButton: {
                    enable: true,
                },
                autoRegister: true,
                allowLocalhostAsSecureOrigin: true
            });

        });
    </script>

</head>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        background-color: black;
        border: none;
        border-right: 1px solid transparent !important;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        color: #999;
        cursor: pointer;
        font-size: 1em;
        font-weight: bold;
        padding: 0;
        position: inherit !important;
    }
</style>

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <h3>True ILM
                        </h3>
                        {{-- <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon feather icon-menu"></i></a></li>
                        </ul> --}}
                        {{-- <ul class="nav navbar-nav bookmark-icons">
                            <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                            <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                            <!--     i.ficon.feather.icon-menu-->
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html"
                                    data-toggle="tooltip" data-placement="top" title="Todo"><i
                                        class="ficon feather icon-check-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html"
                                    data-toggle="tooltip" data-placement="top" title="Chat"><i
                                        class="ficon feather icon-message-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html"
                                    data-toggle="tooltip" data-placement="top" title="Email"><i
                                        class="ficon feather icon-mail"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html"
                                    data-toggle="tooltip" data-placement="top" title="Calendar"><i
                                        class="ficon feather icon-calendar"></i></a></li>
                        </ul> --}}
                        {{-- <ul class="nav navbar-nav">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i
                                        class="ficon feather icon-star warning"></i></a>
                                <div class="bookmark-input search-input">
                                    <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                    <input class="form-control input" type="text" placeholder="Explore Vuexy..."
                                        tabindex="0" data-search="template-list">
                                    <ul class="search-list search-list-bookmark"></ul>
                                </div>
                                <!-- select.bookmark-select-->
                                <!--   option Chat-->
                                <!--   option email-->
                                <!--   option todo-->
                                <!--   option Calendar-->
                            </li>
                        </ul> --}}
                    </div>

                    <ul class="nav navbar-nav float-right">

                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>

                        <li class="dropdown dropdown-user nav-item"><a onclick="logout()"
                                class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"
                                        style="margin-top:10px">
                                    </span><span class="user-status">{{ auth()->user()->name }}
                                    </span></div><span></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="{{ asset('app-assets/images/icons/xls.png') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small
                            class="text-muted">Marketing
                            Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="{{ asset('app-assets/images/icons/jpg.png') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                            Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="{{ asset('app-assets/images/icons/pdf.png') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                            Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="{{ asset('app-assets/images/icons/doc.png') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                            Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img
                            src="{{ asset('app-assets/images/portrait/small/avatar-s-8.jpg') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img
                            src="{{ asset('app-assets/images/portrait/small/avatar-s-1.jpg') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                            Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img
                            src="{{ asset('app-assets/images/portrait/small/avatar-s-14.jpg') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing
                            Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img
                            src="{{ asset('app-assets/images/portrait/small/avatar-s-6.jpg') }}" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web
                            Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a
                class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span
                        class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}">

                        <div>
                            <img src="{{ url('/app-assets/images/logo/true_ilm_logo1.png') }}" alt=""
                                style="
                            margin-left: 50px;
                            margin-top: -9px;
                            height: 5rem;
                            width: 8rem;
                        ">
                        </div>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                            data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content" style="margin-top: 2rem;">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- <li class=" nav-item"><a href="#"><i class="fa fa-cog"></i><span class="menu-title"
                            data-i18n="Dashboard">Configuration</span></a>
                    <ul class="menu-content">

                        <li class="@if (request()->is('admin/section*')) active @endif"><a
                                href="{{ url('admin/sections') }}"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="eCommerce">Sections</span></a>
                        </li>
                    </ul>
                </li> --}}
                {{-- <i class="fa-solid fa-book-quran"></i> --}}

                    <li class=" navigation-header"><span>Al Quran</span>
                    </li>
                    {{-- <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span class="menu-title"
                                data-i18n="Ecommerce">Al-Quran</span></a>
                        <ul class="menu-content"> --}}
                    {{-- <li class="@if (request()->is('al-Quran*') || request()->is('surah/edit*') || request()->is('ayat*')) active @endif "><a
                                    href="{{ url('al-Quran') }}"><i class="fa fa-book" aria-hidden="true"></i>
                                    <span class="menu-item" data-i18n="Analytics">Surahs</span></a>
                            </li> --}}

                    {{-- <li class="@if (request()->is('juz*') || request()->is('juz*') || request()->is('juz*')) active @endif "><a href="{{ url('juz') }}"><i
                                class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">Juz</span></a>
                    </li> --}}
                    @allpermission('translations-author-view,translations-author-create,translations-author-edit')
                    <li class="@if (request()->is('authors') && request()->input('type') == '') active @endif "><a href="{{ url('authors') }}"><i
                                class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Translations Author</span></a>
                    </li>
                    @endallpermission



                    @allpermission('surah-translations-view')
                    <li class="@if (request()->is('all_surah_translations/1') ||
                            request()->is('surah_translations/1*') ||
                            request()->is('surah/translations/1*')) active @endif "><a
                            href="{{ url('all_surah_translations/1') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Surah Translations</span></a> </li>
                    
                    @endallpermission
                    <li class="@if (request()->is('all_surah_translations/2') ||
                            request()->is('surah_translations/2*') ||
                            request()->is('surah/translations/2*')) active @endif "><a
                            href="{{ url('all_surah_translations/2') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Surah Tafseers</span></a> </li>
                    @allpermission('language-view,language-create,language-edit')

                    
                            <li class="@if (request()->is('language*')) active @endif "><a href="{{ url('/language') }}"><i
                                class="fa fa-language"></i>
                            <span class="menu-item" data-i18n="Analytics">Language</span></a>
                            </li>
                    @endallpermission
                    {{-- <li class="@if (request()->is('all_surah_translations/6') || request()->is('surah_translations/6*') || request()->is('surah/translations/6*')) active @endif "><a
                                    href="{{ url('all_surah_translations/6') }}"><i class="fa fa-list"></i>
                                    <span class="menu-item" data-i18n="Analytics">Surah Recitations</span></a> </li> --}}
                    {{-- <li class="@if (request()->is('all_surah_recitations') || request()->is('all_surah_recitations*') || request()->is('surah/all_surah_recitations*')) active @endif "><a
                                    href="{{ url('all_surah_recitations') }}"><i class="fa fa-list"></i>
                                    <span class="menu-item" data-i18n="Analytics">Surah Recitations</span></a> </li> --}}
                    {{-- </ul>
                    </li> --}}
                    <hr>
                    <li class=" navigation-header"><span>Hadith</span>
                    </li>
                    <i class="far fa-typewriter"></i>

                    {{-- <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span class="menu-title"
                                data-i18n="Ecommerce">Hadith</span></a> --}}
                    {{-- <ul class="menu-content"> --}}
                    @allpermission('hadith-translations-view')

                    <li class="@if (request()->is('hadith/books/3*') || request()->is('hadith/books/3') || request()->is('hadith/books/combination/3*')) active @endif "><a
                            href="{{ url('hadith/books/3') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Hadith Translations</span></a>

                    @endallpermission
                    @allpermission('hadith-Tafseer-view')
                    <li class="@if (request()->is('hadith/4*') || request()->is('hadith/books/4') || request()->is('hadith/books/combination/4*')) active @endif "><a
                            href="{{ url('hadith/books/4') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Hadith Tafseer</span></a>
                        {{-- </ul> --}}
                    </li>
                    @endallpermission
                    <hr>
               
                    <li class=" navigation-header"><span>Content</span>
                    </li>

                    @allpermission('category-view,category-create')
                    <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span class="menu-title"
                                data-i18n="Ecommerce">Category</span></a>
                        <ul class="menu-content">
                            <li class="@if (request()->is('categories') || request()->is('category/*')) active @endif ml-2"><a
                                    href="{{ url('categories') }}"><i class="fa fa-list-alt"></i>
                                    <span class="menu-item" data-i18n="Analytics">Category</span></a>
                            </li>
                            <li class="@if (request()->is('categories/inactive')) active @endif ml-2"><a
                                    href="{{ url('categories/inactive') }}"><i class="fa fa-list-alt"></i>
                                    <span class="menu-item" data-i18n="Analytics">Inactive Category</span></a>
                            </li>


                            {{-- <li class="@if (request()->is('books/1*') || request()->is('book/1*') || request()->is('book/during_period/1')) active @endif ml-2"><a
                                    href="{{ url('books/1') }}"><i class="fa fa-book"></i>
                                    <span class="menu-item" data-i18n="Analytics">eBooks</span></a>
                            </li> --}}

                        </ul>
                    </li>
                    @endallpermission
                    @allpermission('eBook-view,eBook-create,eBook-edit')

                    <li class="@if (request()->is('books/1*') || request()->is('book/1*') || request()->is('book/during_period/1')) active @endif "><a href="{{ url('books/1') }}"><i
                                class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">eBooks</span></a>
                    </li>
                    @endallpermission
                    @allpermission('audio-book-view,audio-book-create,audio-book-edit')

                    <li class="@if (request()->is('books/2') || request()->is('book/2*') || request()->is('book/during_period/2*')) active @endif "><a href="{{ url('books/2') }}"><i
                                class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Audio Books</span></a>
                    </li>
                    @endallpermission
                    @allpermission('papers-view,papers-create,papers-edit')

                    <li class="@if (request()->is('books/3*') || request()->is('book/3*') || request()->is('book/during_period/3*')) active @endif "><a href="{{ url('books/3') }}"><i
                                class="fa fa-file"></i>
                            <span class="menu-item" data-i18n="Analytics">Papers</span></a>
                    </li>
                    @endallpermission


                    @allpermission('podcast-view,podcast-create,podcast-edit')

                    <li class="@if (request()->is('books/7*') || request()->is('book/7*') || request()->is('book/during_period/7*')) active @endif "><a href="{{ url('books/7') }}"><i
                                class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">Podcast</span></a>
                    </li>
                    @endallpermission
                    {{-- <li class="@if (request()->is('course*') || request()->is('lesson/quiz*')) active @endif  "><a
                            href="{{ url('/courses') }}"><i class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">Courses</span></a>
                    </li> --}}
                    @allpermission('course-view,course-series-view')
                    <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span class="menu-title"
                                data-i18n="Ecommerce">Courses</span></a>
                        <ul class="menu-content">
                            @allpermission('course-view')
                            <li class="@if (request()->is('course/*') || request()->is('courses*') || request()->is('lesson/quiz*')) active @endif  "><a
                                    href="{{ url('/courses') }}"><i class="fa fa-list"></i>
                                    <span class="menu-item" data-i18n="Analytics">Courses</span></a>
                            </li>
                            @endallpermission
                            @allpermission('course-series-view')
                            <li class="@if (request()->is('series*')) active @endif "><a
                                    href="{{ url('series') }}"><i class="fa fa-list-alt"></i>
                                    <span class="menu-item" data-i18n="Analytics">Course Series</span></a>
                            </li>
                            @endallpermission


                            {{-- <li class="@if (request()->is('books/1*') || request()->is('book/1*') || request()->is('book/during_period/1')) active @endif ml-2"><a
                            href="{{ url('books/1') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">eBooks</span></a>
                            </li> --}}

                        </ul>
                    </li>
                    @endallpermission

                    @allpermission('publisher-view,publisher-create,publisher-edit')
                    <li class="@if (request()->is('publisher*')) active @endif"><a href="{{ url('publisher') }}"><i
                                class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Publishers</span></a>
                    </li>
                    @endallpermission
                    @allpermission('author-view,author-create,author-edit')
                    <li class="@if (request()->input('type') == 1 && request()->is('authors')) active @endif"><a
                            href="{{ url('authors?type=1') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Author</span></a>
                    </li>
                    @endallpermission
                    @allpermission('app-section-view,app-section-create,app-section-edit')
                    <li class="@if (request()->is('app-section')) active @endif"><a
                            href="{{ url('app-section') }}"><i class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">App Section</span></a>
                    </li>
                    @endallpermission
                    
                    {{-- <li class="@if (request()->is('book/rejected')) active @endif"><a
                            href="{{ url('book/rejected') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Rejected</span></a>
                    </li> --}}
                

                    <li class=" navigation-header"><span>User Management</span>
                    </li>
                    {{-- <li class=" nav-item"><a href="#"><i class="fa fa-list"></i><span class="menu-title"
                                    data-i18n="Ecommerce">User Management</span></a> --}}
                    {{-- <ul class="menu-content"> --}}

                    @allpermission('view-admin-user')
                    <li class="@if (request()->is('user*')) active @endif "><a
                            href="{{ url('user-management') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Admin Users</span></a>
                    </li>
                    @endallpermission

                    <li class="@if (request()->is('roles')  || request()->is('permission')) active @endif "><a
                            href="{{ url('roles') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Role</span></a>
                    </li>
                    @allpermission('app-user-view')
                    <li class="@if (request()->is('app-users*')) active @endif "><a
                            href="{{ url('app-users') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">App Users</span></a>
                    </li>
                    @endallpermission
                    @allpermission('affiliate-users')
                    <li class="@if (request()->is('affiliate*')) active @endif "><a
                            href="{{ url('/affiliate ') }}"><i class="fa fa-id-card"></i>
                            <span class="menu-item" data-i18n="Analytics">Affiliate </span></a>
                    </li>
                    @endallpermission
                    
                    @allpermission('family')
                    <li class="@if (request()->is('family*')) active @endif "><a href="{{ url('/family ') }}"><i
                                class="fa fa-users"></i>
                            <span class="menu-item" data-i18n="Analytics">Family </span></a>
                    </li>
                    @endallpermission
                    @allpermission('view-cancel-subscription')
                    <li class="@if (request()->is('cancel_subscriptions')) active @endif "><a
                            href="{{ url('cancel_subscriptions') }}"><i class="fa fa-times"></i>
                            <span class="menu-item" data-i18n="Analytics">Cancel Subscription</span></a>
                    </li>
                    @endallpermission
                    {{-- </ul>
                        </li> --}}
                    {{-- <li class="@if (request()->is('user*')) active @endif "><a
                        href="{{ url('user-management') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">User Management</span></a>
                    </li> --}}
                    {{-- <li class="@if (request()->is('book/pending-*')) active @endif "><a
                            href="{{ url('book/pending-for-approval') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Content for Approval</span></a>
                    </li> --}}
                    <hr>
                    <li class=" navigation-header"><span>Content for Approval</span>
                    </li>
                    {{-- <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span
                                    class="menu-title" data-i18n="Ecommerce">Content for Approval</span></a> --}}
                    {{-- <ul class="menu-content"> --}}

                    {{-- <li class="@if (request()->is('book/pending-*')) active @endif "><a
                            href="{{ url('book/pending-for-approval') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Pending for Approval</span></a>
                    </li> --}}

                    @allpermission('pending-eBook,pending-audio-book,pending-papers,pending-podcast,rejected-content,approved-content')
                    <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span class="menu-title"
                                data-i18n="Ecommerce">Pending for Approval</span></a>
                        <ul class="menu-content">
                        @allpermission('pending-eBook')

                            <li class="@if (request()->is('book/pending-for-approval/1')) active @endif ml-2"><a
                                    href="{{ url('book/pending-for-approval/1') }}"><i class="ffa fa-book"></i>
                                    <span class="menu-item" data-i18n="Analytics">Ebook</span></a>
                            </li>
                        @endallpermission    
                        @allpermission('pending-audio-book')                            
                            <li class="@if (request()->is('book/pending-for-approval/2')) active @endif ml-2"><a
                                    href="{{ url('book/pending-for-approval/2') }}"><i class="fa fa-book"></i>
                                    <span class="menu-item" data-i18n="Analytics">Audio Book</span></a>
                            </li>
                        @endallpermission
                        @allpermission('pending-papers')
                            <li class="@if (request()->is('book/pending-for-approval/3')) active @endif ml-2"><a
                                    href="{{ url('book/pending-for-approval/3') }}"><i class="fa fa-file"></i>
                                    <span class="menu-item" data-i18n="Analytics">Papers</span></a>
                            </li>
                        @endallpermission 
                        @allpermission('pending-podcast')
                            <li class="@if (request()->is('book/pending-for-approval/7')) active @endif ml-2"><a
                                    href="{{ url('book/pending-for-approval/7') }}"><i class="fa fa-list"></i>
                                    <span class="menu-item" data-i18n="Analytics">Podcast</span></a>
                            </li>
                        @endallpermission
                        
                        @allpermission( 'pending-course')
                            <li class="@if (request()->is('book/pending-for-approval/6')) active @endif ml-2"><a
                                    href="{{ url('book/pending-for-approval/6') }}"><i class="fa fa-list"></i>
                                    <span class="menu-item" data-i18n="Analytics">Courses</span></a>
                            </li>
                        @endallpermission 

                            {{-- <li class="@if (request()->is('books/1*') || request()->is('book/1*') || request()->is('book/during_period/1')) active @endif ml-2"><a
                            href="{{ url('books/1') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">eBooks</span></a>
                    </li> --}}

                        </ul>
                    </li>
                    @endallpermission
                    @allpermission('rejected-content')
                    <li class="@if (request()->is('book/rejected_by_you')) active @endif "><a
                            href="{{ url('book/rejected_by_you') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Rejected Content</span></a>
                    </li>
                    @endallpermission
                    @allpermission('approved-content')
                    <li class="@if (request()->is('book/approved*')) active @endif "><a
                            href="{{ url('book/approved') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Approved Content</span></a>
                    </li>
                    @endallpermission

                    {{-- </ul>
                        </li> --}}

                    <hr>
                    <li class=" navigation-header"><span>Reviews</span>
                    </li>
                    <li class="@if (request()->is('review*')) active @endif "><a href="{{ url('/review') }}"><i
                                class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Review Book</span></a>
                    </li>
                    <li class="@if (request()->is('reflections*')) active @endif "><a
                            href="{{ url('/reflections') }}"><i class="fa fa-comment-o"></i>
                            <span class="menu-item" data-i18n="Analytics">Reflections</span></a>
                    </li>
                    <li class="@if (request()->is('mistake*')) active @endif "><a
                            href="{{ url('/mistakes') }}"><i class="fa fa-exclamation-triangle"></i>
                            <span class="menu-item" data-i18n="Analytics">Book Mistakes</span></a>
                    </li>
                    <li class=" navigation-header"><span>Grant</span>
                    </li>
                    @allpermission('grant')
                    <li class="@if (request()->is('*grant')) active @endif "><a href="{{ url('/grant') }}"><i
                                class="fa fa-question"></i>
                            <span class="menu-item" data-i18n="Analytics">Pending Grant</span></a>
                    </li>
                    @endallpermission
                    @allpermission( 'approved-grant')
                    <li class="@if (request()->is('grant/approved*')) active @endif "><a
                            href="{{ url('/grant/approved') }}"><i class="fa fa-question"></i>
                            <span class="menu-item" data-i18n="Analytics">Approved Grant</span></a>
                    </li>
                    @endallpermission
                    @allpermission('rejected-grant')
                    <li class="@if (request()->is('grant/rejected*')) active @endif "><a
                            href="{{ url('/grant/rejected') }}"><i class="fa fa-question"></i>
                            <span class="menu-item" data-i18n="Analytics">Rejected Grant</span></a>
                    </li>
                    @endallpermission

                    <hr>

                    
                    @allpermission( 'notifications-view')
                    <li class="@if (request()->is('notification*')) active @endif "><a
                            href="{{ url('/notification') }}"><i class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">Notification</span></a>
                    </li>
                    @endallpermission
                    @allpermission('books-for-sale')

                    <li class="@if (request()->is('*for_sale*')) active @endif "><a
                            href="{{ url('/books_for_sale') }}"><i class="fa fa-book"></i>
                            <span class="menu-item" data-i18n="Analytics">Books For Sale</span></a>
                    </li>
                    @endallpermission
                    
                    @allpermission('email-subscriptions')
                    <li class="@if (request()->is('subscription_email*')) active @endif "><a
                            href="{{ url('/subscription_email') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Email Subscriptions</span></a>
                    </li>
                    @endallpermission
                    @allpermission('glossory-view')

                    <li class="@if (request()->is('glossary*')) active @endif "><a
                            href="{{ url('/glossary') }}"><i class="fa fa-list"></i>
                            <span class="menu-item" data-i18n="Analytics">Glossary</span></a>
                    </li>
                    @endallpermission
                    
                    @allpermission('support-view')
                    <li class="@if (request()->is('support*')) active @endif "><a href="{{ url('/support') }}"><i
                                class="fa fa-question"></i>
                            <span class="menu-item" data-i18n="Analytics">Support</span></a>
                    </li>
                    @endallpermission
                   
                    @allpermission('coupon-view')
                    <li class="@if (request()->is('coupon*')) active @endif "><a href="{{ url('/coupon') }}"><i
                                class="fa fa-percent"></i>
                            <span class="menu-item" data-i18n="Analytics">Coupon</span></a>
                    </li>
                    @endallpermission
                    @allpermission('order-view')
                    <li class="@if (request()->is('order*')) active @endif "><a href="{{ url('/order') }}"><i
                                class="fa fa-line-chart"></i>
                            <span class="menu-item" data-i18n="Analytics">Order</span></a>
                    </li>
                    @endallpermission

                    {{--
                        <li class="@if (request()->is('addition_review')) active @endif "><a
                                href="{{ url('/addition_review') }}"><i class="fa fa-book"></i>
                                <span class="menu-item" data-i18n="Analytics">Book Addition Review</span></a>
                        </li> --}}

                    {{-- @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Publisher'))
                        <li class=" nav-item"><a href="#"><i class="fa fa-list-alt"></i><span
                                    class="menu-title" data-i18n="Ecommerce">Content Management</span></a>
                            <ul class="menu-content">

                            </ul>
                        </li>
                    @endif --}}
                    
                    @allpermission('app-versions-view')
                        <li class="@if (request()->is('version*')) active @endif "><a
                                href="{{ url('app/versions') }}"><i class="fa fa-list-alt"></i>
                                <span class="menu-item" data-i18n="Analytics">App Versions</span></a>
                        </li>
                    @endallpermission
                    @allpermission('activities_view')
                        <li class="@if (request()->is('activities*')) active @endif mb-2"><a
                                href="{{ url('activities') }}"><i class="fa fa-tasks"></i>
                                <span class="menu-item" data-i18n="Analytics">Activities</span></a>
                        </li>
                    @endallpermission   
                   
                

                @if (auth()->user()->hasRole('Institute'))
                    <li class="@if (request()->is('institute*') || request()->is('app-user*')) active @endif "><a
                            href="{{ url('institute/users') }}"><i class="fa fa-user"></i>
                            <span class="menu-item" data-i18n="Analytics">Users</span></a>
                    </li>
                @endif
                <br>
                {{-- <li class="@if (request()->is('admin/page_creation*')) active @endif"><a href="{{ url('admin/page_creation') }}"><i
                    class="fa fa-list-alt" aria-hidden="true"></i> <span class="menu-item"
                    data-i18n="eCommerce">Create Pages</span></a>
                </li> --}}

                {{-- <li class=" navigation-header"><span>Apps</span>
                </li>
                <li class=" nav-item"><a href="app-email.html"><i class="feather icon-mail"></i><span
                            class="menu-title" data-i18n="Email">Email</span></a>
                </li>
                <li class=" nav-item"><a href="app-chat.html"><i class="feather icon-message-square"></i><span
                            class="menu-title" data-i18n="Chat">Chat</span></a>
                </li>
                <li class=" nav-item"><a href="app-todo.html"><i class="feather icon-check-square"></i><span
                            class="menu-title" data-i18n="Todo">Todo</span></a>
                </li>
                <li class=" nav-item"><a href="app-calender.html"><i class="feather icon-calendar"></i><span
                            class="menu-title" data-i18n="Calender">Calender</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-shopping-cart"></i><span
                            class="menu-title" data-i18n="Ecommerce">Ecommerce</span></a>
                    <ul class="menu-content">
                        <li><a href="app-ecommerce-shop.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Shop">Shop</span></a>
                        </li>
                        <li><a href="app-ecommerce-details.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Details">Details</span></a>
                        </li>
                        <li><a href="app-ecommerce-wishlist.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Wish List">Wish List</span></a>
                        </li>
                        <li><a href="app-ecommerce-checkout.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Checkout">Checkout</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title"
                            data-i18n="User">User</span></a>
                    <ul class="menu-content">
                        <li><a href="app-user-list.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="List">List</span></a>
                        </li>
                        <li><a href="app-user-view.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="View">View</span></a>
                        </li>
                        <li><a href="app-user-edit.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Edit">Edit</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>UI Elements</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-list"></i><span class="menu-title"
                            data-i18n="Data List">Data List</span><span
                            class="badge badge badge-primary badge-pill float-right mr-2">New</span></a>
                    <ul class="menu-content">
                        <li><a href="data-list-view.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="List View">List View</span></a>
                        </li>
                        <li><a href="data-thumb-view.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Thumb View">Thumb View</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-layout"></i><span class="menu-title"
                            data-i18n="Content">Content</span></a>
                    <ul class="menu-content">
                        <li><a href="content-grid.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Grid">Grid</span></a>
                        </li>
                        <li><a href="content-typography.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Typography">Typography</span></a>
                        </li>
                        <li><a href="content-text-utilities.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Text Utilities">Text Utilities</span></a>
                        </li>
                        <li><a href="content-syntax-highlighter.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Syntax Highlighter">Syntax Highlighter</span></a>
                        </li>
                        <li><a href="content-helper-classes.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Helper Classes">Helper Classes</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="colors.html"><i class="feather icon-droplet"></i><span
                            class="menu-title" data-i18n="Colors">Colors</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-eye"></i><span class="menu-title"
                            data-i18n="Icons">Icons</span></a>
                    <ul class="menu-content">
                        <li><a href="icons-feather.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Feather">Feather</span></a>
                        </li>
                        <li><a href="icons-font-awesome.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Font Awesome">Font Awesome</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-credit-card"></i><span
                            class="menu-title" data-i18n="Card">Card</span></a>
                    <ul class="menu-content">
                        <li><a href="card-basic.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Basic">Basic</span></a>
                        </li>
                        <li><a href="card-advance.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Advance">Advance</span></a>
                        </li>
                        <li><a href="card-statistics.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Statistics">Statistics</span></a>
                        </li>
                        <li><a href="card-analytics.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Analytics">Analytics</span></a>
                        </li>
                        <li><a href="card-actions.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Card Actions">Card Actions</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span
                            class="menu-title" data-i18n="Components">Components</span></a>
                    <ul class="menu-content">
                        <li><a href="component-alerts.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Alerts">Alerts</span></a>
                        </li>
                        <li><a href="component-buttons-basic.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Buttons">Buttons</span></a>
                        </li>
                        <li><a href="component-breadcrumbs.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Breadcrumbs">Breadcrumbs</span></a>
                        </li>
                        <li><a href="component-carousel.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Carousel">Carousel</span></a>
                        </li>
                        <li><a href="component-collapse.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Collapse">Collapse</span></a>
                        </li>
                        <li><a href="component-dropdowns.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Dropdowns">Dropdowns</span></a>
                        </li>
                        <li><a href="component-list-group.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="List Group">List Group</span></a>
                        </li>
                        <li><a href="component-modals.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Modals">Modals</span></a>
                        </li>
                        <li><a href="component-pagination.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Pagination">Pagination</span></a>
                        </li>
                        <li><a href="component-navs-component.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Navs Component">Navs Component</span></a>
                        </li>
                        <li><a href="component-navbar.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Navbar">Navbar</span></a>
                        </li>
                        <li><a href="component-tabs-component.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Tabs Component">Tabs Component</span></a>
                        </li>
                        <li><a href="component-pills-component.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Pills Component">Pills Component</span></a>
                        </li>
                        <li><a href="component-tooltips.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Tooltips">Tooltips</span></a>
                        </li>
                        <li><a href="component-popovers.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Popovers">Popovers</span></a>
                        </li>
                        <li><a href="component-badges.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Badges">Badges</span></a>
                        </li>
                        <li><a href="component-pill-badges.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Pill Badges">Pill Badges</span></a>
                        </li>
                        <li><a href="component-progress.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Progress">Progress</span></a>
                        </li>
                        <li><a href="component-media-objects.html"><i class="feather icon-circle"></i><span
                                    class="menu-item">Media Objects</span></a>
                        </li>
                        <li><a href="component-spinner.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Spinner">Spinner</span></a>
                        </li>
                        <li><a href="component-bs-toast.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Toasts">Toasts</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-box"></i><span class="menu-title"
                            data-i18n="Extra Components">Extra Components</span></a>
                    <ul class="menu-content">
                        <li><a href="ex-component-avatar.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Avatar">Avatar</span></a>
                        </li>
                        <li><a href="ex-component-chips.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Chips">Chips</span></a>
                        </li>
                        <li><a href="ex-component-divider.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Divider">Divider</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>Forms &amp; Tables</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-copy"></i><span class="menu-title"
                            data-i18n="Form Elements">Form Elements</span></a>
                    <ul class="menu-content">
                        <li><a href="form-select.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Select">Select</span></a>
                        </li>
                        <li><a href="form-switch.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Switch">Switch</span></a>
                        </li>
                        <li><a href="form-checkbox.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Checkbox">Checkbox</span></a>
                        </li>
                        <li><a href="form-radio.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Radio">Radio</span></a>
                        </li>
                        <li><a href="form-inputs.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Input">Input</span></a>
                        </li>
                        <li><a href="form-input-groups.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Input Groups">Input Groups</span></a>
                        </li>
                        <li><a href="form-number-input.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Number Input">Number Input</span></a>
                        </li>
                        <li><a href="form-textarea.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Textarea">Textarea</span></a>
                        </li>
                        <li><a href="form-date-time-picker.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Date &amp; Time Picker">Date &amp; Time
                                    Picker</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="form-layout.html"><i class="feather icon-box"></i><span
                            class="menu-title" data-i18n="Form Layout">Form Layout</span></a>
                </li>
                <li class=" nav-item"><a href="form-wizard.html"><i class="feather icon-package"></i><span
                            class="menu-title" data-i18n="Form Wizard">Form Wizard</span></a>
                </li>
                <li class=" nav-item"><a href="form-validation.html"><i class="feather icon-check-circle"></i><span
                            class="menu-title" data-i18n="Form Validation">Form Validation</span></a>
                </li>
                <li class=" nav-item"><a href="table.html"><i class="feather icon-server"></i><span
                            class="menu-title" data-i18n="Table">Table</span></a>
                </li>
                <li class=" nav-item"><a href="table-datatable.html"><i class="feather icon-grid"></i><span
                            class="menu-title" data-i18n="Datatable">Datatable</span></a>
                </li>
                <li class=" nav-item"><a href="table-ag-grid.html"><i class="feather icon-grid"></i><span
                            class="menu-title" data-i18n="ag-grid">agGrid Table</span><span
                            class="badge badge badge-primary badge-pill float-right mr-2">New</span></a>
                </li>
                <li class=" navigation-header"><span>pages</span>
                </li>
                <li class=" nav-item"><a href="page-user-profile.html"><i class="feather icon-user"></i><span
                            class="menu-title" data-i18n="Profile">Profile</span></a>
                </li>
                <li class=" nav-item"><a href="page-account-settings.html"><i class="feather icon-settings"></i><span
                            class="menu-title" data-i18n="Account Settings">Account Settings</span></a>
                </li>
                <li class=" nav-item"><a href="page-faq.html"><i class="feather icon-help-circle"></i><span
                            class="menu-title" data-i18n="FAQ">FAQ</span></a>
                </li>
                <li class=" nav-item"><a href="page-knowledge-base.html"><i class="feather icon-info"></i><span
                            class="menu-title" data-i18n="Knowledge Base">Knowledge Base</span></a>
                </li>
                <li class=" nav-item"><a href="page-search.html"><i class="feather icon-search"></i><span
                            class="menu-title" data-i18n="Search">Search</span></a>
                </li>
                <li class=" nav-item"><a href="page-invoice.html"><i class="feather icon-file"></i><span
                            class="menu-title" data-i18n="Invoice">Invoice</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-zap"></i><span class="menu-title"
                            data-i18n="Starter kit">Starter kit</span></a>
                    <ul class="menu-content">
                        <li><a
                                href="{{ asset('starter-kit/ltr/vertical-menu-template/sk-layout-2-columns.html') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="2 columns">2
                                    columns</span></a>
                        </li>
                        <li><a
                                href="{{ asset('starter-kit/ltr/vertical-menu-template/sk-layout-fixed-navbar.html') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Fixed navbar">Fixed navbar</span></a>
                        </li>
                        <li><a
                                href="{{ asset('starter-kit/ltr/vertical-menu-template/sk-layout-floating-navbar.html') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Floating navbar">Floating navbar</span></a>
                        </li>
                        <li><a href="{{ asset('starter-kit/ltr/vertical-menu-template/sk-layout-fixed.html') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Fixed layout">Fixed layout</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-unlock"></i><span class="menu-title"
                            data-i18n="Authentication">Authentication</span></a>
                    <ul class="menu-content">
                        <li><a href="auth-login.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Login">Login</span></a>
                        </li>
                     {{--   <li><a href="auth-register.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Register">Register</span></a>
                        </li>
                        <li><a href="auth-forgot-password.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Forgot Password">Forgot Password</span></a>
                        </li>
                        <li><a href="auth-reset-password.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Reset Password">Reset Password</span></a>
                        </li>
                        <li><a href="auth-lock-screen.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Lock Screen">Lock Screen</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-file-text"></i><span
                            class="menu-title" data-i18n="Miscellaneous">Miscellaneous</span></a>
                    <ul class="menu-content">
                        <li><a href="page-coming-soon.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Coming Soon">Coming Soon</span></a>
                        </li>
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Error">Error</span></a>
                            <ul class="menu-content">
                                <li><a href="error-404.html"><i class="feather icon-circle"></i><span
                                            class="menu-item" data-i18n="404">404</span></a>
                                </li>
                                <li><a href="error-500.html"><i class="feather icon-circle"></i><span
                                            class="menu-item" data-i18n="500">500</span></a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="page-not-authorized.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Not Authorized">Not Authorized</span></a>
                        </li>
                        <li><a href="page-maintenance.html"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Maintenance">Maintenance</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>Charts &amp; Maps</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-pie-chart"></i><span
                            class="menu-title" data-i18n="Charts">Charts</span><span
                            class="badge badge badge-pill badge-success float-right mr-2">3</span></a>
                    <ul class="menu-content">
                        <li><a href="chart-apex.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Apex">Apex</span></a>
                        </li>
                        <li><a href="chart-chartjs.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Chartjs">Chartjs</span></a>
                        </li>
                        <li><a href="chart-echarts.html"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Echarts">Echarts</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="maps-google.html"><i class="feather icon-map"></i><span
                            class="menu-title" data-i18n="Google Maps">Google Maps</span></a>
                </li>
                <li class=" navigation-header"><span>Extensions</span>
                </li>
                <li class=" nav-item"><a href="ext-component-sweet-alerts.html"><i
                            class="feather icon-alert-circle"></i><span class="menu-title"
                            data-i18n="Sweet Alert">Sweet Alert</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-toastr.html"><i class="feather icon-zap"></i><span
                            class="menu-title" data-i18n="Toastr">Toastr</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-noui-slider.html"><i
                            class="feather icon-sliders"></i><span class="menu-title" data-i18n="NoUi Slider">NoUi
                            Slider</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-file-uploader.html"><i
                            class="feather icon-upload-cloud"></i><span class="menu-title"
                            data-i18n="File Uploader">File Uploader</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-quill-editor.html"><i
                            class="feather icon-edit"></i><span class="menu-title" data-i18n="Quill Editor">Quill
                            Editor</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-drag-drop.html"><i
                            class="feather icon-droplet"></i><span class="menu-title"
                            data-i18n="Drag &amp; Drop">Drag &amp; Drop</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-tour.html"><i class="feather icon-info"></i><span
                            class="menu-title" data-i18n="Tour">Tour</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-clipboard.html"><i class="feather icon-copy"></i><span
                            class="menu-title" data-i18n="Clipboard">Clipboard</span></a>
                </li>
                <li class=" nav-item"><a href=" ext-component-plyr.html"><i class="feather icon-film"></i><span
                            class="menu-title" data-i18n="Media player">Media player</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-context-menu.html"><i
                            class="feather icon-more-horizontal"></i><span class="menu-title"
                            data-i18n="Context Menu">Context Menu</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-swiper.html"><i
                            class="feather icon-smartphone"></i><span class="menu-title"
                            data-i18n="swiper">swiper</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-i18n.html"><i class="feather icon-globe"></i><span
                            class="menu-title" data-i18n="l18n">l18n</span></a>
                </li>
                <li class=" navigation-header"><span>Others</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-menu"></i><span class="menu-title"
                            data-i18n="Menu Levels">Menu Levels</span></a>
                    <ul class="menu-content">
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Second Level">Second Level</span></a>
                        </li>
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Second Level">Second Level</span></a>
                            <ul class="menu-content">
                                <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Third Level">Third Level</span></a>
                                </li>
                                <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Third Level">Third Level</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="disabled nav-item"><a href="#"><i class="feather icon-eye-off"></i><span
                            class="menu-title" data-i18n="Disabled Menu">Disabled Menu</span></a>
                </li>
                <li class=" navigation-header"><span>Support</span>
                </li>
                <li class=" nav-item"><a
                        href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation"><i
                            class="feather icon-folder"></i><span class="menu-title"
                            data-i18n="Documentation">Documentation</span></a>
                </li>
                <li class=" nav-item"><a href="https://pixinvent.ticksy.com/"><i
                            class="feather icon-life-buoy"></i><span class="menu-title"
                            data-i18n="Raise Support">Raise Support</span></a>
                </li> --}}
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <script>
        function logout() {
            var css = $('.dropdown-menu').css('display');

            if (css == 'block') {
                $('.dropdown-menu').css('display', 'none');
            } else {
                $('.dropdown-menu').css('display', 'block');
            }

        }
    </script>

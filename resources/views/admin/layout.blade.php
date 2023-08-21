@php
$setting = SiteHelpers::setting();
$notification = SiteHelpers::notification();
$notification2 = SiteHelpers::notification2();
$total_notification = SiteHelpers::total_notification();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->application_name }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('upload/setting/'.$setting->small_icon) }}"/>
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link href="{{ asset('plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/noUiSlider/custom-nouiSlider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/bootstrap-range-Slider/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body class="sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            
            <ul class="navbar-nav theme-brand flex-row ">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        <img src="{{ asset('upload/setting/'.$setting->large_icon) }}" style="width:90%">
                        <!-- <p style="font-size:18px;font-weight:bold;color:white;margin-top: 10px;">{{ $setting->short_application_name }}</p> -->
                    </a>
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg></a>
                </li>
            </ul>

            <ul class="navbar-item flex-row search-ul">
                
            </ul>
            
            <ul class="navbar-item flex-row navbar-dropdown">
               
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                @if (Auth::user()->foto)
							        <img src="{{ asset('upload/foto/' . Auth::user()->foto) }}" class="img-fluid mr-2" alt="avatar">
                                @else
							        <img src="{{ asset('assets/profile-1-20210205190338.jpg') }}" class="img-fluid mr-2" alt="avatar">
                                @endif
                                
                                <div class="media-body">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p>{{ Auth::user()->group->group_name }}</p>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->group_id == 1)
                            <div class="dropdown-item">
                                <a href="{{ url('setting') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> <span>Pengaturan</span>
                                </a>
                            </div>
                        @endif
                        <div class="dropdown-item">
                            <a href="{{ url('edit_profil/'.Crypt::encrypt(Auth::user()->id)) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profil Saya</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ url('logout-sistem') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
					   <form id="logout-form" action="{{ url('logout-sistem') }}" method="POST" style="display: none;">
							@csrf
                        </form>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">
                <div class="profile-info">
                    <figure class="user-cover-image"></figure>
                    <div class="user-info">
				    	@if (Auth::user()->foto)
                            <img src="{{ asset('upload/foto/' . Auth::user()->foto) }}" alt="avatar">
                        @else
                            <img src="{{ asset('assets/profile-1-20210205190338.jpg') }}" alt="avatar">
                        @endif
                        <h6 class="">{{ Auth::user()->name }}</h6>
                        <p class="">{{ Auth::user()->group->group_name }}</p>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    
                    <li class="menu @if(Request::segment(1)=="dashboard") active @endif">
                        <a href="{{ url('dashboard') }}"  @if(Request::segment(1)=="dashboard") aria-expanded="true" @endif class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

                    
                    <li class="menu @if(in_array(Request::segment(1), array('statistic_number_of_employees','statistic_number_of_class'))) active @endif">
                        <a href="#statistik" data-toggle="collapse" @if(in_array(Request::segment(1), array('statistic_number_of_employees','statistic_number_of_class'))) aria-expanded="true" @endif class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                <span>Statistik</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" @if($notification) style="margin-top:-15px" @endif width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if(in_array(Request::segment(1), array('statistic_number_of_employees','statistic_number_of_class'))) show @endif" id="statistik" data-parent="#accordionExample">
                            <li @if(in_array(Request::segment(1), array('statistic_number_of_employees'))) class="active" @endif>
                                <a href="{{ url('statistic_number_of_employees') }}"> Jumlah Pegawai</a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('statistic_number_of_class'))) class="active" @endif>
                                <a href="{{ url('statistic_number_of_class') }}"> Jumlah Pegawai Per <br>Golongan</a>
                            </li>
                        </ul>
                    </li>


                    <li class="menu" @if(Request::segment(1)=="duk") active @endif">
                    <a href="{{ url('duk') }}" @if(Request::segment(1)=="duk") aria-expanded="true" @endif class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                <span>DUK</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu @if(in_array(Request::segment(1), array('parent_unit_promotion','promotion','parent_unit_salary_increase','salary_increase'))) active @endif">
                        <a href="#layanan" data-toggle="collapse" @if(in_array(Request::segment(1), array('parent_unit_promotion','promotion','parent_unit_salary_increase','salary_increase'))) aria-expanded="true" @endif class="dropdown-toggle" @if($notification) style="padding: 9px 10px;" @endif>
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <span>Layanan</span>
                            </div>
                            <div>
                                @if($total_notification)<span class="badge badge-danger" style="margin-top:6px">{{ $total_notification }}</span>@endif
                                <svg xmlns="http://www.w3.org/2000/svg" @if($total_notification) style="margin-top:-15px" @endif width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if(in_array(Request::segment(1), array('parent_unit_promotion','promotion','parent_unit_salary_increase','salary_increase'))) show @endif" id="layanan" data-parent="#accordionExample">
                            <!-- <li>
                                <a href="component_tabs.html"> Pindah Instansi </a>
                            </li> -->
                            <li @if(in_array(Request::segment(1), array('parent_unit_promotion','promotion'))) class="active" @endif>
                                <a href="@if(Auth::user()->group_id == 1) {{ url('parent_unit_promotion') }} @else {{ url('promotion') }} @endif"> Naik Pangkat @if($notification)<span class="badge badge-danger" style="margin-top:-2px">{{ $notification }}</span>@endif</a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('parent_unit_salary_increase','salary_increase'))) class="active" @endif>
                                <a href="@if(Auth::user()->group_id == 1) {{ url('parent_unit_salary_increase') }} @else {{ url('salary_increase') }} @endif"> KGB @if($notification2)<span class="badge badge-danger" style="margin-top:-2px">{{ $notification2 }}</span>@endif</a>
                            </li>
                            <!-- <li>
                                <a href="component_modal.html"> KGB </a>
                            </li>                            
                            <li>
                                <a href="component_cards.html"> Cuti </a>
                            </li>
                            <li>
                                <a href="{{ url('absence_employee') }}">Tugas Luar</a>
                            </li> -->
                        </ul>
                    </li>

                    <li class="menu @if(Request::segment(1)=="employee" || Request::segment(1)=="education" || Request::segment(1)=="class" || Request::segment(1)=="unit") active @endif">
                        <a href="#master" data-toggle="collapse" @if(Request::segment(1)=="employee" || Request::segment(1)=="education" || Request::segment(1)=="class" || Request::segment(1)=="unit") aria-expanded="true" @endif class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <span>Master Data</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if(Request::segment(1)=="employee" || Request::segment(1)=="education" || Request::segment(1)=="class" || Request::segment(1)=="unit") show @endif" id="master" data-parent="#accordionExample">
                            <li @if(Request::segment(1)=="employee") class="active" @endif>
                                <a href="{{ url('employee') }}"> Daftar Pegawai </a>
                            </li>
                            <li @if(Request::segment(1)=="education") class="active" @endif>
                                <a href="{{ url('education') }}"> Pendidikan</a>
                            </li>
                            <li @if(Request::segment(1)=="class") class="active" @endif>
                                <a href="{{ url('class') }}"> Golongan</a>
                            </li>
                            <!-- <li>
                                <a href="{{ url('position') }}"> Jabatan</a>
                            </li> -->
                            <li @if(Request::segment(1)=="unit") class="active" @endif>
                                <a href="{{ url('unit') }}">Unit Organisasi</a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu @if(in_array(Request::segment(1), array('class_employee','class_history','education_employee','education_history','position_employee','position_history','punishment_employee','punishment_history','absence_employee','absence_history','family_employee','family_history','leave_employee','leave_history','training_employee','training_history'))) active @endif">
                        <a href="#riwayat" data-toggle="collapse" @if(in_array(Request::segment(1), array('class_employee','class_history','education_employee','education_history','position_employee','position_history','punishment_employee','punishment_history','absence_employee','absence_history','family_employee','family_history','leave_employee','leave_history','training_employee','training_history'))) aria-expanded="true" @endif class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <span>Riwayat</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if(in_array(Request::segment(1), array('class_employee','class_history','education_employee','education_history','position_employee','position_history','punishment_employee','punishment_history','absence_employee','absence_history','family_employee','family_history','leave_employee','leave_history','training_employee','training_history'))) show @endif" id="riwayat" data-parent="#accordionExample">
                            <li @if(in_array(Request::segment(1), array('class_employee','class_history'))) class="active" @endif>
                                <a href="{{ url('class_employee') }}"> Golongan </a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('education_employee','education_history'))) class="active" @endif>
                                <a href="{{ url('education_employee') }}"> Pendidikan  </a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('position_employee','position_history'))) class="active" @endif>
                                <a href="{{ url('position_employee') }}"> Jabatan </a>
                            </li>
                            <!-- <li @if(in_array(Request::segment(1), array('punishment_employee','punishment_history'))) class="active" @endif>
                                <a href="{{ url('punishment_employee') }}">Hukuman Disiplin</a>
                            </li> -->
                            <li @if(in_array(Request::segment(1), array('absence_employee','absence_history'))) class="active" @endif>
                                <a href="{{ url('absence_employee') }}">Absen</a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('leave_employee','leave_history'))) class="active" @endif>
                                <a href="{{ url('leave_employee') }}">Cuti</a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('family_employee','family_history'))) class="active" @endif>
                                <a href="{{ url('family_employee') }}">Keluarga</a>
                            </li>
                            <li @if(in_array(Request::segment(1), array('training_employee','training_history'))) class="active" @endif>
                                <a href="{{ url('training_employee') }}">Diklat</a>
                            </li>
                        </ul>
                    </li>

                    @if(Auth::user()->group_id == 1)
                        <li class="menu menu-heading">
                            <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>PENGATURAN</span></div>
                        </li>                    

                        <li class="menu @if(Request::segment(1)=="constitution") active @endif">
                            <a href="{{ url('constitution') }}" @if(Request::segment(1)=="constitution") aria-expanded="true" @endif class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                    <span>Undang-undang</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu @if(Request::segment(1)=="log") active @endif">
                            <a href="{{ url('log') }}" @if(Request::segment(1)=="log") aria-expanded="true" @endif class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                    <span>Log Aktifitas</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu @if(Request::segment(1)=="user") active @endif">
                            <a href="{{ url('user') }}" @if(Request::segment(1)=="user") aria-expanded="true" @endif class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <span>User</span>
                                </div>
                            </a>
                        </li>
                    @endif

                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->
        
	    @yield('konten')



    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dash_1.js') }}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    
    <!-- BEGIN THEME GLOBAL STYLE -->
    <script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/custom-select2.js') }}"></script>
    <script src="{{ asset('plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('plugins/noUiSlider/nouislider.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('plugins/noUiSlider/custom-nouiSlider.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-range-Slider/bootstrap-rangeSlider.js') }}"></script>
    <!-- <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script> -->
    <!-- END PAGE LEVEL PLUGINS -->

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{ asset('assets/js/components/notification/custom-snackbar.js') }}"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
    

    <!-- END THEME GLOBAL STYLE -->    
    <script>
        //First upload
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        //Second upload
        var secondUpload = new FileUploadWithPreview('mySecondImage')

        function formatRupiah(objek, separator) {
            a = objek.value;
            b = a.replace(/[^\d]/g, "");
            c = "";
            panjang = b.length;
            j = 0;
            for (i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                    c = b.substr(i - 1, 1) + separator + c;
                } else {
                    c = b.substr(i - 1, 1) + c;
                }
            }
            objek.value = c;
        }

        // Get the Toast button
        var toastButton = document.getElementById("toast-btn");
        // Get the Toast element
        var toastElement = document.getElementsByClassName("toast")[0];

        toastButton.onclick = function() {
            $('.toast').toast('show');
        }

    </script>
    <!-- END PAGE LEVEL PLUGINS -->    

</body>
</html>
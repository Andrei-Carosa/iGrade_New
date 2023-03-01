
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">

		<title>E-Class Record</title>
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

        <style>
        </style>

	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed page-loading">

		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
			<!--begin::Logo-->
			<a href="index.html">
				<img alt="Logo" src="{{ asset('assets/media/logos/logo-letter-9.png') }}" class="max-h-30px" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<div class="topbar-item">
					<div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="">
						<div class="d-flex flex-column text-right pr-3">
							<span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline">Sean</span>
							<span class="text-white font-weight-bolder font-size-sm d-none d-md-inline">UX Designer</span>
						</div>
						<span class="symbol symbol-35">
							<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">S</span>
						</span>
					</div>
				</div>
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->

		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                    <!--begin::Header-->
					<div id="kt_header" class="header flex-column header-fixed shadow">
						<!--begin::Top-->
						<div class="header-top">
							<!--begin::Container-->
							<div class="container-fluid mx-20">
								<!--begin::Left-->
								<div class="d-none d-lg-flex align-items-center mr-3">
									<!--begin::Logo-->
									<a href="index.html" class="mr-20">
										<img alt="Logo" src="{{ asset('assets/media/logos/logo-letter-9.png') }}" class="max-h-35px" />
									</a>
									<!--end::Logo-->
								</div>
								<!--end::Left-->
								<!--begin::Topbar-->
								<div class="topbar">
									<!--begin::User-->
									<div class="dropdown">
										<!--begin::Toggle-->
										<div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
											<div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2">
												<div class="d-flex flex-column text-right pr-3">
													<span class="text-white  font-weight-bold font-size-sm d-none d-md-inline">{{ Auth::user()->emp_info->fullname }}</span>
													<span class="text-white opacity-50 font-weight-bolder font-size-sm d-none d-md-inline">{{ Auth::user()->AccountType }}</span>
												</div>
												<span class="symbol symbol-35">
													<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">S</span>
												</span>
											</div>
										</div>
										<!--end::Toggle-->
										<!--begin::Dropdown-->
										<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
											<!--begin::Header-->
											<div class="d-flex align-items-center p-8 rounded-top">
												<!--begin::Symbol-->
												<div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
													<img src="{{ asset('assets/media/users/300_21.jpg') }}" alt="" />
												</div>
												<!--end::Symbol-->
												<!--begin::Text-->
												<div class="text-dark m-0 flex-grow-1 mr-1 font-size-h5">{{ Auth::user()->emp_info->fullname }}</div>
												<span class="label label-light-success label-inline label-lg font-weight-bold label-inline">{{ __('Faculty') }}</span>
                                                <!--end::Text-->
											</div>
											<div class="separator separator-solid"></div>
											<!--end::Header-->
											<!--begin::Nav-->
											<div class="navi navi-spacer-x-0 pt-5">
												<!--begin::Item-->
												<a href="custom/apps/user/profile-1/personal-information.html" class="navi-item px-8">
													<div class="navi-link">
														<div class="navi-icon mr-2">
															<i class="flaticon2-calendar-3 text-success"></i>
														</div>
														<div class="navi-text">
															<div class="font-weight-bold">My Profile</div>
															<div class="text-muted">Account settings and more
															<span class="label label-light-danger label-inline font-weight-bold">update</span></div>
														</div>
													</div>
												</a>
												<!--end::Item-->
												<!--begin::Item-->
												<a href="custom/apps/user/profile-3.html" class="navi-item px-8">
													<div class="navi-link">
														<div class="navi-icon mr-2">
															<i class="flaticon2-mail text-warning"></i>
														</div>
														<div class="navi-text">
															<div class="font-weight-bold">My Messages</div>
															<div class="text-muted">Inbox and tasks</div>
														</div>
													</div>
												</a>
												<!--end::Item-->
												<!--begin::Item-->
												<a href="custom/apps/user/profile-2.html" class="navi-item px-8">
													<div class="navi-link">
														<div class="navi-icon mr-2">
															<i class="flaticon2-rocket-1 text-danger"></i>
														</div>
														<div class="navi-text">
															<div class="font-weight-bold">My Activities</div>
															<div class="text-muted">Logs and notifications</div>
														</div>
													</div>
												</a>
												<!--end::Item-->
												<!--begin::Item-->
												<a href="custom/apps/userprofile-1/overview.html" class="navi-item px-8">
													<div class="navi-link">
														<div class="navi-icon mr-2">
															<i class="flaticon2-hourglass text-primary"></i>
														</div>
														<div class="navi-text">
															<div class="font-weight-bold">My Tasks</div>
															<div class="text-muted">latest tasks and projects</div>
														</div>
													</div>
												</a>
												<!--end::Item-->
												<!--begin::Footer-->
												<div class="navi-separator mt-3"></div>
												<div class="navi-footer px-8 py-5">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                    <x-dropdown-link :href="route('logout')" class="btn btn-light-danger font-weight-bold"
                                                            onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                    </form>
												</div>
												<!--end::Footer-->
											</div>
											<!--end::Nav-->
										</div>
										<!--end::Dropdown-->
									</div>
									<!--end::User-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Top-->
						<!--begin::Bottom-->
						{{-- <div class="header-bottom shadow-sm">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Header Menu Wrapper-->
								<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
									<!--begin::Header Menu-->
									<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
										<!--begin::Header Nav-->
										<ul class="menu-nav">
											<li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here">
												<a href="javascript:;" class="menu-link menu-toggle">
													<span class="menu-text">My Class</span>
													<span class="menu-desc">View your class</span>
													<i class="menu-arrow"></i>
												</a>
											</li>
											<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">
												<a href="javascript:;" class="menu-link menu-toggle">
													<span class="menu-text">Help</span>
													<span class="menu-desc">Watch tutorial for E-Class Record</span>
													<i class="menu-arrow"></i>
												</a>
											</li>
                                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">
												<a href="javascript:;" class="menu-link menu-toggle">
													<span class="menu-text">Help</span>
													<span class="menu-desc">Watch tutorial for E-Class Record</span>
													<i class="menu-arrow"></i>
												</a>
											</li>
										</ul>
										<!--end::Header Nav-->
									</div>
									<!--end::Header Menu-->
								</div>
								<!--end::Header Menu Wrapper-->
							</div>
							<!--end::Container-->
						</div> --}}
						<!--end::Bottom-->
					</div>
					<!--end::Header-->

					<!--begin::Content-->
                                @yield('content')
						<!--end::Entry-->

					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">2021©</span>
								<a href="http://keenthemes.com/metronic" target="_blank" class="text-dark-75 text-hover-primary">Keenthemes</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Nav-->
							<div class="nav nav-dark order-1 order-md-2">
								<a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pr-3 pl-0">About</a>
								<a href="http://keenthemes.com/metronic" target="_blank" class="nav-link px-3">Team</a>
								<a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
							</div>
							<!--end::Nav-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</div>
		<!--end::Scrolltop-->

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
        var
            KTAppSettings = {
                    "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white":
                    "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800",
                    "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF",
                    "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light":
                    "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121",
                    "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark":
                    "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } },
                    "font-family": "Poppins"
                };
        </script>
        <!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
        </script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/myclass.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>

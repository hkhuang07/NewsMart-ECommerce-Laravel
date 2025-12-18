<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="preload" href="{{ asset('public/images/favicon.ico') }}" as="image" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/list.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/profile.css') }}">

    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @yield('javascript')

</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5>
                <img src="{{ asset('public/images/favicon.ico') }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="navbar-logo"> {{ config('app.name', 'Laravel') }}
				<button class="sidebar-close" id="sidebarClose">
					<i class="fas fa-times"></i>
				</button>
			</h5>
            
        </div>

        <ul class="sidebar-nav">
            <!-- Account Section -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->FullName ?? Auth::user()->name }}
                    <span class="badge-role">{{ getUserRole() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="post" class="d-none">
                    @csrf
                </form>
            </li>
            @endguest

            <!-- Main Navigation -->
            <li>
                <h6 class="sidebar-section-title">Main Navigation</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-newspaper"></i> News Center
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-store"></i> Shopping Center
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-info-circle"></i> About Us
                </a>
            </li>
            @auth
            <!-- Admin Management Section -->
            @if(hasAdminAccess())
            <li>
                <h6 class="sidebar-section-title">Administration</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.role') }}">
                    <i class="fas fa-user-tag"></i> Role Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user') }}">
                    <i class="fas fa-users"></i> User Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.configuration') }}">
                    <i class="fas fa-cog"></i> System Configuration
                </a>
            </li>

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#adminReports">
                    <i class="fas fa-chart-bar"></i> Reports & Analytics
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="adminReports">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-line"></i> System Reports
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-users"></i> User Activity
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-money-bill"></i> Revenue Reports
                    </a>
                </div>
            </li>
            @endif

            <!-- Manager & Admin Shared Management -->
            @if(hasManagerAccess())
            <li>
                <h6 class="sidebar-section-title">System Management</h6>
            </li>

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#categoryManagement">
                    <i class="fas fa-sitemap"></i> Categories & Brands
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="categoryManagement">
                    <a class="nav-link" href="{{ route('frontend.category') }}">
                        <i class="fas fa-list"></i> Product Categories
                    </a>
                    <a class="nav-link" href="{{ route('frontend.brand') }}">
                        <i class="fas fa-copyright"></i> Brands
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#contentManagement">
                    <i class="fas fa-edit"></i> Content Management
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="contentManagement">
                    <a class="nav-link" href="{{ route('admin.topic') }}">
                        <i class="fas fa-tags"></i> Post Topics
                    </a>
                    <a class="nav-link" href="{{ route('admin.post_type') }}">
                        <i class="fas fa-file-alt"></i> Post Types
                    </a>
                    <a class="nav-link" href="{{ route('admin.post') }}">
                        <i class="fas fa-newspaper"></i> Post Moderation
                    </a>
                    <a class="nav-link" href="{{ route('admin.post_status') }}">
                        <i class="fas fa-list"></i> Post Status
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#orderSystemManagement">
                    <i class="fas fa-cogs"></i> Order System
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="orderSystemManagement">
                    <a class="nav-link" href="{{ route('admin.orderstatus') }}">
                        <i class="fas fa-list-check"></i> Order Status
                    </a>
                    <a class="nav-link" href="{{ route('admin.review') }}">
                        <i class="fas fa-star"></i> Reviews Management
                    </a>
                </div>
            </li>
            @endif

            <!-- Product Management (Admin, Manager, Saler) -->
            @if(canManageProducts())
            @if(!isSaler())
            <li>
                <h6 class="sidebar-section-title">Product Management</h6>
            </li>
            @endif

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#productManagement">
                    <i class="fas fa-box"></i> @if(isSaler()) My Products @else Products @endif
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="productManagement">
                    <a class="nav-link" href="{{ route('admin.product') }}">
                        <i class="fas fa-cube"></i> @if(isSaler()) My Product List @else All Products @endif
                    </a>
                    @if(!isSaler())
                    <a class="nav-link" href="#">
                        <i class="fas fa-star"></i> Product Reviews
                    </a>
                    @endif
                </div>
            </li>
            @endif

            <!-- Order Management (Admin, Manager, Saler, Shipper) -->
            @if(canManageOrders())
            @if(isSaler())
            <li>
                <h6 class="sidebar-section-title">Sales Management</h6>
            </li>
            @elseif(isShipper())
            <li>
                <h6 class="sidebar-section-title">Delivery Management</h6>
            </li>
            @elseif(!hasManagerAccess())
            <li>
                <h6 class="sidebar-section-title">Order Management</h6>
            </li>
            @endif

            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#orderManagement">
                    <i class="fas fa-file-invoice"></i>
                    @if(isSaler()) My Orders
                    @elseif(isShipper()) Delivery Orders
                    @else Orders
                    @endif
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="orderManagement">
                    <a class="nav-link" href="{{ route('admin.order') }}">
                        <i class="fas fa-shopping-cart"></i>
                        @if(isSaler()) Sales Orders
                        @elseif(isShipper()) Assigned Orders
                        @else All Orders
                        @endif
                    </a>
                    @if(isShipper())
                    <a class="nav-link" href="#">
                        <i class="fas fa-truck"></i> Available Orders
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-map-marker-alt"></i> Delivery Schedule
                    </a>
                    @endif
                    @if(!isShipper())
                    <a class="nav-link" href="#">
                        <i class="fas fa-list-check"></i> Order Status Updates
                    </a>
                    @endif
                </div>
            </li>
            @endif

            <!-- Reports Section (Admin, Manager, Saler) -->
            @if(canViewReports() && !hasAdminAccess())
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i>
                    @if(isSaler()) Revenue Reports
                    @else Reports & Analytics
                    @endif
                </a>
            </li>
            @endif
            @endauth

            <!-- Settings Section -->
            <li>
                <h6 class="sidebar-section-title">Settings</h6>
            </li>
            <li class="nav-item">
                <button class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-palette"></i> <span id="themeText">Dark</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="lang-toggle" onclick="toggleLanguage()">
                    <i class="fas fa-language"></i> <span id="langText">Vietnamese</span>
                </button>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-question-circle"></i> Help Center
                </a>
            </li>
        </ul>
    </nav>
	<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width:500px">
        <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h4 class="offcanvas-title" id="shoppingCartLabel">Cart ({{ Cart::count() ?? 0 }})</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
        </div>
		@if(Cart::count() > 0)
			<div class="offcanvas-body d-flex flex-column gap-4 pt-2">
				@foreach(Cart::content() as $value)
					<div class="d-flex align-items-center">
						<a class="flex-sm-shrink-0" href="#" style="width:142px">
							<div class="ratio bg-body-tertiary rounded overflow-hidden"	
								style="--cz-aspect-ratio:calc(110 / 142 * 100%)">
								<img src="{{asset('storage/app/private/'. $value->options->image) }}" alt="Thumbnail" />
							</div>
						</a>
						<div class="w-100 min-w-0 ps-3">
							<h5 class="d-flex animate-underline mb-2">
								<a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
							</h5>
							<div class="d-flex align-items-center justify-content-between gap-1">
								<div class="h6 mt-1 mb-0">${{ $value->price }}</div>
								<a href="{{ route('frontend.cart.delete',['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip"
									data-bs-custom-class="tooltip-sm" data-bs-title="Remove">
									<i class="fas fa-trash-alt fs-base"></i>
								</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="offcanvas-header flex-column align-items-start">
				<div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
					<span class="text-light-emphasis">Total:</span>
					<span class="h6 mb-0">${{ Cart::priceTotal() }}</span>
				</div>
				<a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{ route('frontend.cart') }}">Cart</a>
			</div>
		@else
			<div class="offcanvas-body d-flex flex-column gap-4 pt-2">
				<div class="pb-4 mb-3 mx-auto" style="max-width:524px">
					<svg class="d-block mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="100" viewBox="0 0 29.5 30"><path class="text-body-tertiary" d="M17.8 4c.4 0 .8-.3.8-.8v-2c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v2c0 .4.3.8.8.8zm3.2.6c.4.2.8 0 1-.4l.4-.9c.2-.4 0-.8-.4-1s-.8 0-1 .4l-.4.9c-.2.4 0 .9.4 1zm-7.5-.4c.2.4.6.6 1 .4s.6-.6.4-1l-.4-.9c-.2-.4-.6-.6-1-.4s-.6.6-.4 1l.4.9z" fill="currentColor" /><path class="text-body-emphasis" d="M10.7 24.5c-1.5 0-2.8 1.2-2.8 2.8S9.2 30 10.7 30s2.8-1.2 2.8-2.8-1.2-2.7-2.8-2.7zm0 4c-.7 0-1.2-.6-1.2-1.2s.6-1.2 1.2-1.2 1.2.6 1.2 1.2-.5 1.2-1.2 1.2zm11.1-4c-1.5 0-2.8 1.2-2.8 2.8a2.73 2.73 0 0 0 2.8 2.8 2.73 2.73 0 0 0 2.8-2.8c0-1.6-1.3-2.8-2.8-2.8zm0 4c-.7 0-1.2-.6-1.2-1.2s.6-1.2 1.2-1.2 1.2.6 1.2 1.2-.6 1.2-1.2 1.2zM8.7 18h16c.3 0 .6-.2.7-.5l4-10c.2-.5-.2-1-.7-1H9.3c-.4 0-.8.3-.8.8s.4.7.8.7h18.3l-3.4 8.5H9.3L5.5 1C5.4.7 5.1.5 4.8.5h-4c-.5 0-.8.3-.8.7s.3.8.8.8h3.4l3.7 14.6a3.24 3.24 0 0 0-2.3 3.1C5.5 21.5 7 23 8.7 23h16c.4 0 .8-.3.8-.8s-.3-.8-.8-.8h-16a1.79 1.79 0 0 1-1.8-1.8c0-1 .9-1.6 1.8-1.6z" fill="currentColor" /></svg>
				</div>
				<h5 class="mb-2">Your cart is currently empty!</h5>
				<p class="fs-sm mb-4">Explore our many items and add products to your cart..</p>
				<a class="btn btn-dark rounded-pill" href="{{ route('frontend.home') }}">Continue Shopping</a>
			</div>
			
			
		@endif
        
    </div>
    <div class="container-fluid">
        <!-- Horizontal Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <!-- Sidebar Toggle Button -->
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="{{ route('frontend.home') }}">
                    <img src="{{ asset('public/images/newsmart_logo.jpg') }}" alt="u{{ config('app.name', 'Laravel') }} Logo" class="navbar-logo">
                    <!--span class="brand-text">{{ config('app.name', 'Laravel') }}</span-->
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <i class="fas fa-bars"></i>
                </button>

                

                <div class="collapse navbar-collapse" id="navbarMain">
                    <!-- Left Navigation -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.home') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.home') }} ">
                                <i class="fas fa-newspaper"></i> News 
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('frontend.home') }} ">
                                <i class="fas fa-store"></i> Mart
                            </a>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link btn" onclick="toggleTheme()">
                                <i class="fas fa-palette"></i> <span id="themeTextNav">Dark Mode</span>
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link btn" onclick="toggleLanguage()">
                                <i class="fas fa-language"></i> <span id="langTextNav">Vietnamese</span>
                            </button>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-question-circle"></i> 
                            </a>
                        </li>
						 
                    </ul>

                    <!-- Search Form -->
                    <form class="d-flex search-form mx-3">
                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
					<ul class="navbar-nav me-3">
						<button class="nav-link btn position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ Cart::count() ?? 0 }}
                                </span>
                            </button>
					</ul>
					

                    <!-- Right Navigation -->
                    <ul class="navbar-nav ms-auto">
					
                        @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> Log In
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i> Register
                                    </a></li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->FullName ?? Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user"></i> Profile
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-cog"></i> Settings
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Log Out
                                    </a></li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content pt-3" id="mainContent">
            @yield('content')
			@yield('floating-button') 
			
        </main>

        <!-- Footer -->
        <footer>
            <div class="container py-5">
                <!-- Service Introduction Section -->
                <div class="footer-service-intro p-4 mb-5 rounded">
                    <h2 class="mb-4">
                        <i class="fas fa-city me-2"></i>{{ config('app.name', 'Laravel') }}: Integrated Platform for Urban Life
                    </h2>
                    <p class="lead">
                        {{ config('app.name', 'Laravel') }} is an integrated ecosystem that delivers essential services for modern living.
                        Our platform features key functionalities like
                        <span class="highlight">E-commerce</span>,
                        <span class="highlight">News & Content Center</span>,
                        <span class="highlight">Ride-hailing & Delivery</span>,
                        and a comprehensive management system.
                        With a robust multi-role structure
                        (<span class="highlight">User, Admin, Manager, Shipper, Saler</span>),
                        we are committed to providing an optimal, secure, and efficient experience for all users.
                    </p>
                </div>

                <!-- Main Information Sections -->
                <div class="row g-4 mb-5">
                    <!-- Column 1: Customer Service -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-headset me-2"></i>Customer Service
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-question-circle me-2"></i>Help Center
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-blog me-2"></i>{{ config('app.name', 'Laravel') }} Blog
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-shopping-cart me-2"></i>How To Buy
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-store me-2"></i>How To Sell
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-credit-card me-2"></i>Payment
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Shipping
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-undo me-2"></i>Return & Refund
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-phone me-2"></i>Contact Us
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: About & Social -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-info-circle me-2"></i>About {{ config('app.name', 'Laravel') }}
                            </h3>
                            <div class="d-flex flex-column gap-1 mb-4">
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-building me-2"></i>About Us
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-users me-2"></i>Careers
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-file-contract me-2"></i>Company Policy
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-newspaper me-2"></i>Media
                                </a>
                            </div>

                            <h3 class="mb-4">
                                <i class="fas fa-share-alt me-2"></i>Follow Us
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <a href="https://www.facebook.com/hk.huang07"  class="footer-link-item">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </a>
                                <a href="https://www.linkedin.com/in/hkhuang07/" class="footer-link-item">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </a>
                                <a href="https://github.com/hkhuang07/" class="footer-link-item">
                                    <i class="fab fa-github me-2"></i>Github
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-instagram me-2"></i>Instagram
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Payment & Logistics -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-credit-card me-2"></i>Payment
                            </h3>
                            <div class="d-flex flex-column gap-1 mb-4">
                                <div class="footer-info-item">
                                    <i class="fab fa-cc-visa me-2"></i>VISA
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-mobile-alt me-2"></i>MoMo
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-mobile-alt me-2"></i>ZaloPay
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-credit-card me-2"></i>Credit Card
                                </div>
                            </div>

                            <h3 class="mb-4">
                                <i class="fas fa-truck me-2"></i>Logistics
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>SPX
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Viettel Post
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>J&T Express
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Grab Express
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Be
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Vill
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 4: Download App -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column footer-app-section p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-mobile-alt me-2"></i>Download Our App
                            </h3>
                            <div class="mb-4">
                                <div class="footer-qr-placeholder">
                                    <div>
                                        <i class="fas fa-qrcode fa-2x mb-2"></i>
                                        <div class="small">QR Code</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <a href="#" class="footer-app-button">
                                    <i class="fab fa-apple me-2"></i>App Store
                                </a>
                                <a href="#" class="footer-app-button">
                                    <i class="fab fa-google-play me-2"></i>Google Play
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Copyright and Company Info Section -->
                <div class="footer-bottom pt-4 text-center">
                    <div class="footer-bottom-links mb-3">
                        <a href="#" class="me-3">Privacy Policy</a>
                        <a href="#" class="me-3">Terms of Service</a>
                        <a href="#" class="me-3">Shipping Policy</a>
                        <a href="#" class="me-3">Return & Refund Policy</a>
                    </div>

                    <div class="footer-company-info">
                        <p class="mb-2">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} by Development Team. All rights reserved.</p>
                        <p class="mb-2">{{ config('app.name', 'Laravel') }} Technology Company Limited</p>
                        <p class="mb-0">
                            Address: <span class="footer-highlight">Long Xuyen City, An Giang, VietNam</span> |
                            Tax Code: <span class="footer-highlight">8825719470</span> |
                            Email: <span class="footer-highlight">newsmarteam@gmail.com</span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Hidden logout form for navbar -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
	
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');

            function openSidebar() {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
                if (window.innerWidth > 768) {
                    mainContent.classList.add('sidebar-open');
                }
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                mainContent.classList.remove('sidebar-open');
            }

            sidebarToggle.addEventListener('click', openSidebar);
            sidebarClose.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    mainContent.classList.remove('sidebar-open');
                }
            });

            // Sidebar dropdown functionality
            const dropdownButtons = document.querySelectorAll('.sidebar-dropdown');
            dropdownButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('collapsed');
                    const targetId = this.getAttribute('data-bs-target');
                    const target = document.querySelector(targetId);
                    if (target) {
                        target.classList.toggle('show');
                    }
                });
            });
        });

        // Theme toggle functionality
        let isDarkMode = localStorage.getItem('darkMode') === 'true';

        function toggleTheme() {
            isDarkMode = !isDarkMode;
            localStorage.setItem('darkMode', isDarkMode);

            const themeText = document.getElementById('themeText');
            const themeTextNav = document.getElementById('themeTextNav');

            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                if (themeText) themeText.textContent = 'Light Mode';
                if (themeTextNav) themeTextNav.textContent = 'Light';
            } else {
                document.body.classList.remove('dark-mode');
                if (themeText) themeText.textContent = 'Dark Mode';
                if (themeTextNav) themeTextNav.textContent = 'Dark';
            }
        }

        // Language toggle functionality
        let isVietnamese = localStorage.getItem('language') === 'vi';

        function toggleLanguage() {
            isVietnamese = !isVietnamese;
            localStorage.setItem('language', isVietnamese ? 'vi' : 'en');

            const langText = document.getElementById('langText');
            const langTextNav = document.getElementById('langTextNav');

            if (isVietnamese) {
                if (langText) langText.textContent = 'English';
                if (langTextNav) langTextNav.textContent = 'EN';
            } else {
                if (langText) langText.textContent = 'Vietnamese';
                if (langTextNav) langTextNav.textContent = 'VI';
            }
        }

        // Initialize theme and language on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                const themeText = document.getElementById('themeText');
                const themeTextNav = document.getElementById('themeTextNav');
                if (themeText) themeText.textContent = 'Light Mode';
                if (themeTextNav) themeTextNav.textContent = 'Light';
            }

            if (isVietnamese) {
                const langText = document.getElementById('langText');
                const langTextNav = document.getElementById('langTextNav');
                if (langText) langText.textContent = 'English';
                if (langTextNav) langTextNav.textContent = 'English';
            }
        });
		document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.getElementById('brands-scroll-container');
    const scrollLeftBtn = document.getElementById('scroll-left-btn');
    const scrollRightBtn = document.getElementById('scroll-right-btn');
    const scrollAmount = 250; // Số pixel cuộn mỗi lần nhấp

    // Hàm kiểm tra vị trí cuộn để ẩn/hiện mũi tên
    const checkScrollPosition = () => {
        // Nếu đã cuộn hết sang trái
        if (scrollContainer.scrollLeft <= 0) {
            scrollLeftBtn.classList.add('d-none');
        } else {
            scrollLeftBtn.classList.remove('d-none');
        }

        // Nếu đã cuộn hết sang phải
        if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
            scrollRightBtn.classList.add('d-none');
        } else {
            scrollRightBtn.classList.remove('d-none');
        }
    };
    
    // Ban đầu, kiểm tra và ẩn mũi tên trái nếu đang ở đầu
    checkScrollPosition(); 

    // Xử lý cuộn sang phải
    scrollRightBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        // Chờ cuộn xong mới kiểm tra lại vị trí
        setTimeout(checkScrollPosition, 300); 
    });

    // Xử lý cuộn sang trái
    scrollLeftBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        // Chờ cuộn xong mới kiểm tra lại vị trí
        setTimeout(checkScrollPosition, 300);
    });

    // Cập nhật trạng thái mũi tên khi người dùng tự cuộn bằng chuột
    scrollContainer.addEventListener('scroll', checkScrollPosition);
});
    </script>
	
    @yield('scripts')
	
	{{-- Vị trí của các script JS (hoặc @yield('scripts')) --}}
    
    
</html>
</body>

</html>
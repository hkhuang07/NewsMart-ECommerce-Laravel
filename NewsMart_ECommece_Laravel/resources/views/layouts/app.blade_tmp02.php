<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @yield('javascript')

</head>

<body>
    @php
        // Permission helper functions based on actual database structure
        function getUserRole() {
            try {
                if (Auth::user()->role && Auth::user()->role->name)
                return Auth::user()->role->name;
            } catch (Exception $e) {
                //
            }
            return 'User';
        }
        function getCurrentUserName() {
            return Auth::user()->fullname ?? Auth::user()->name ?? 'Unknown';
        }

        function isUserActive() {
            return Auth::user()->isactive ?? false;
        }

        function getUserRoleId() {
            if (!Auth::check()) return null;
            return Auth::user()->roleid ?? null;
        }
        
        function hasRole($roleName) {
            if (!Auth::check()) return false;
            return strtolower(getUserRole()) === strtolower($roleName);
        }
        
        function hasAnyRole($roles) {
            if (!Auth::check()) return false;
            $userRole = strtolower(getUserRole());
            return in_array($userRole, array_map('strtolower', $roles));
        }
        
        // Individual role checking functions
        function isAdmin() {
            return hasRole('Admin');
        }
        
        function isManager() {
            return hasRole('Manager');
        }
        
        function isSaler() {
            return hasRole('Saler');
        }
        
        function isShipper() {
            return hasRole('Shipper');
        }
        
        function isStandardUser() {
            return hasRole('User');
        }
        
        // Combined permission functions based on role hierarchy
        function hasAdminAccess() {
            return isAdmin();
        }
        
        function hasManagerAccess() {
            return hasAnyRole(['Admin', 'Manager']);
        }
        
        function hasSalesAccess() {
            return hasAnyRole(['Admin', 'Manager', 'Saler']);
        }
        
        function hasShippingAccess() {
            return hasAnyRole(['Admin', 'Manager', 'Shipper']);
        }
        
        // Specific permission functions based on role descriptions
        function canManageSystem() {
            // Admin: Highest administrator rights
            return isAdmin();
        }
        
        function canManageProducts() {
            // Admin, Manager: System and product management rights
            // Saler: Sell and manage related orders
            return hasAnyRole(['Admin', 'Manager', 'Saler']);
        }
        
        function canManageOrders() {
            // Admin, Manager, Saler: Order management
            // Shipper: Delivery and update order status rights
            return hasAnyRole(['Admin', 'Manager', 'Saler', 'Shipper']);
        }
        
        function canManageUsers() {
            // Only Admin and Manager can manage users
            return hasAnyRole(['Admin', 'Manager']);
        }
        
        function canViewReports() {
            // Admin, Manager, Saler can view reports
            return hasAnyRole(['Admin', 'Manager', 'Saler']);
        }
        
        function canManageCategories() {
            // Admin and Manager can manage categories
            return hasAnyRole(['Admin', 'Manager']);
        }
        
        function canManageSuppliers() {
            // Admin and Manager can manage suppliers
            return hasAnyRole(['Admin', 'Manager']);
        }
        
        function canUpdateOrderStatus() {
            // Admin, Manager, and Shipper can update order status
            return hasAnyRole(['Admin', 'Manager', 'Shipper']);
        }
        
        function canAccessAdminPanel() {
            // All staff roles can access admin panel (not regular users)
            return hasAnyRole(['Admin', 'Manager', 'Saler', 'Shipper']);
        }
    @endphp

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5><i class="fas fa-user-circle"></i> Navigation</h5>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <ul class="sidebar-nav">
            <!-- Account Section -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <span class="nav-link">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->FullName ?? Auth::user()->name }}
                        <span class="badge-role">{{ getUserRole() }}</span>
                    </span>
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
            <li><h6 class="sidebar-section-title">Main Navigation</h6></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend') }}">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-info-circle"></i> About Us
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

            @auth
            <!-- Admin Management Section -->
            @if(hasAdminAccess())
            <li><h6 class="sidebar-section-title">Administration</h6></li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('role') }}">
                    <i class="fas fa-user-tag"></i> Role Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user') }}">
                    <i class="fas fa-users"></i> User Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('configuration') }}">
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
            <li><h6 class="sidebar-section-title">System Management</h6></li>
            
            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#categoryManagement">
                    <i class="fas fa-sitemap"></i> Categories & Brands
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="categoryManagement">
                    <a class="nav-link" href="{{ route('category') }}">
                        <i class="fas fa-list"></i> Product Categories
                    </a>
                    <a class="nav-link" href="{{ route('brand') }}">
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
                    <a class="nav-link" href="{{ route('topic') }}">
                        <i class="fas fa-tags"></i> Post Topics
                    </a>
                    <a class="nav-link" href="{{ route('posttype') }}">
                        <i class="fas fa-file-alt"></i> Post Types
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-newspaper"></i> Post Moderation
                    </a>
                    <a class="nav-link" href="#">
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
                    <a class="nav-link" href="{{ route('order_statuses') }}">
                        <i class="fas fa-list-check"></i> Order Status
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-star"></i> Reviews Management
                    </a>
                </div>
            </li>
            @endif
            
            <!-- Product Management (Admin, Manager, Saler) -->
            @if(canManageProducts())
            @if(!isSaler())
            <li><h6 class="sidebar-section-title">Product Management</h6></li>
            @endif
            
            <li class="nav-item">
                <button class="sidebar-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#productManagement">
                    <i class="fas fa-box"></i> @if(isSaler()) My Products @else Products @endif
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </button>
                <div class="collapse sidebar-submenu" id="productManagement">
                    <a class="nav-link" href="{{ route('product') }}">
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
            <li><h6 class="sidebar-section-title">Sales Management</h6></li>
            @elseif(isShipper())
            <li><h6 class="sidebar-section-title">Delivery Management</h6></li>
            @elseif(!hasManagerAccess())
            <li><h6 class="sidebar-section-title">Order Management</h6></li>
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
                    <a class="nav-link" href="{{ route('order') }}">
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
            <li><h6 class="sidebar-section-title">Settings</h6></li>
            <li class="nav-item">
                <button class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-palette"></i> <span id="themeText">Dark Mode</span>
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

    <div class="container-fluid">
        <!-- Horizontal Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <!-- Sidebar Toggle Button -->
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Brand -->
                <a class="navbar-brand" href="{{ route('frontend') }}">
                    <i class="fas fa-shopping-cart"></i> {{ config('app.name', 'Laravel') }}
                </a>
                
                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <!-- Left Navigation -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-info-circle"></i> About Us
                            </a>
                        </li>
                        
                        <!-- News Center Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-newspaper"></i> News Center
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-tags"></i> Topics
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-file-alt"></i> Post Types
                                </a></li>
                            </ul>
                        </li>
                        
                        <!-- Shopping Center Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-store"></i> Shopping Center
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('category') }}">
                                    <i class="fas fa-sitemap"></i> Categories
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('brand') }}">
                                    <i class="fas fa-copyright"></i> Brands
                                </a></li>
                            </ul>
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
                                <i class="fas fa-question-circle"></i> Help Center
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
                    
                    <!-- Right Navigation -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="#">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </a>
                        </li>
                        
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
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user"></i> Profile
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-cog"></i> Settings
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
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
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-twitter me-2"></i>Twitter
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
                            Address: <span class="footer-highlight">Ho Chi Minh City, Vietnam</span> | 
                            Tax Code: <span class="footer-highlight">0123456789</span> | 
                            Email: <span class="footer-highlight">contact@{{ strtolower(config('app.name', 'laravel')) }}.com</span>
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
        // Sidebar functionality
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

            // Close sidebar on window resize if mobile
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
                if (themeTextNav) themeTextNav.textContent = 'Light Mode';
            } else {
                document.body.classList.remove('dark-mode');
                if (themeText) themeText.textContent = 'Dark Mode';
                if (themeTextNav) themeTextNav.textContent = 'Dark Mode';
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
                if (langTextNav) langTextNav.textContent = 'English';
            } else {
                if (langText) langText.textContent = 'Vietnamese';
                if (langTextNav) langTextNav.textContent = 'Vietnamese';
            }
        }

        // Initialize theme and language on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                const themeText = document.getElementById('themeText');
                const themeTextNav = document.getElementById('themeTextNav');
                if (themeText) themeText.textContent = 'Light Mode';
                if (themeTextNav) themeTextNav.textContent = 'Light Mode';
            }
            
            if (isVietnamese) {
                const langText = document.getElementById('langText');
                const langTextNav = document.getElementById('langTextNav');
                if (langText) langText.textContent = 'English';
                if (langTextNav) langTextNav.textContent = 'English';
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
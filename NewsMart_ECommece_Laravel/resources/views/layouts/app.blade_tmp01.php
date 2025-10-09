<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @yield('javascript')

</head>
    <body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('frontend') }}">
                    <i class="fa-light fa-cart-shopping"></i> {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category') }}"><i class="fa-light fa-fw fa-sitemap"></i> Danh mục</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('brand') }}"><i class="fa-light fa-fw fa-copyright"></i> Thương hiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product') }}"><i class="fa-light fa-fw fa-box"></i> Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order') }}"><i class="fa-light fa-fw fa-file-invoice"></i> Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orderstatus') }}"><i class="fa-light fa-fw fa-list-check"></i> Trạng thái ĐH</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user') }}"><i class="fa-light fa-fw fa-users"></i> Tài khoản</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-light fa-fw fa-tools"></i> Khác
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
                                <li><a class="dropdown-item" href="{{ route('role') }}"><i class="fa-light fa-fw fa-user-tag"></i> Vai trò</a></li>
                                <li><a class="dropdown-item" href="{{ route('topic') }}"><i class="fa-light fa-fw fa-tags"></i> Chủ đề Bài viết</a></li>
                                <li><a class="dropdown-item" href="{{ route('posttype') }}"><i class="fa-light fa-fw fa-file-alt"></i> Loại Bài viết</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('configuration') }}"><i class="fa-light fa-fw fa-cog"></i> Cấu hình</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa-light fa-fw fa-sign-in-alt"></i> Đăng nhập</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fa-light fa-user-plus"></i> Đăng ký</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#nguoidung" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-light fa-user-circle"></i> {{ Auth::user()->FullName ?? Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa-light fa-fw fa-sign-out-alt"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="pt-3">
            @yield('content')
        </main>
        <hr class="shadow-sm" />
        <footer>Bản quyền &copy; {{ date('Y') }} bởi {{ config('app.name', 'Laravel') }}.</footer>
    </div>
</body>

</html>
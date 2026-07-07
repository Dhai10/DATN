<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Quản Lý Sân Bóng') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .wrapper-inner {
            display: flex;
            flex: 1;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 24px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-logo {
            padding: 0 24px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-logo i {
            font-size: 2rem;
        }
        
        .sidebar-logo span {
            font-size: 1.4rem;
            font-weight: 700;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0 16px;
        }
        
        .sidebar-menu li {
            margin-bottom: 4px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .sidebar-menu a i {
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 24px;
            left: 0;
            right: 0;
            padding: 0 24px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 0;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 18px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        /* Page Content */
        .page-content {
            padding: 32px;
        }
        
        /* Cards */
        .custom-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        
        .custom-card-header {
            padding: 20px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .custom-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
        }
        
        .custom-card-body {
            padding: 24px;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 16px;
        }
        
        .stat-icon.blue { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; }
        .stat-icon.green { background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: white; }
        .stat-icon.orange { background: linear-gradient(135deg, #92400e 0%, #f59e0b 100%); color: white; }
        .stat-icon.cyan { background: linear-gradient(135deg, #0e7490 0%, #06b6d4 100%); color: white; }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .stat-label {
            font-size: 0.95rem;
            color: #64748b;
            font-weight: 500;
        }
        
        /* Table */
        .table-container {
            overflow-x: auto;
        }
        
        .custom-table {
            margin-bottom: 0;
        }
        
        .custom-table thead th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 16px;
        }
        
        .custom-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            color: #334155;
        }
        
        .custom-table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-confirmed { background-color: #d1fae5; color: #065f46; }
        .badge-completed { background-color: #dbeafe; color: #1e40af; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; }
        
        /* Buttons */
        .btn-gradient-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        
        .btn-outline {
            border: 2px solid #e2e8f0;
            color: #1e3a8a;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            background: white;
        }
        
        .btn-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
                z-index: 999;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @auth
            <div class="wrapper-inner">
                <!-- Sidebar -->
                <aside class="sidebar">
                    <div class="sidebar-logo">
                        <i class="fas fa-futbol"></i>
                        <span>Quản Lý Sân Bóng</span>
                    </div>
                    
                    <ul class="sidebar-menu">
                        @if(Auth::user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                            <li><a href="{{ route('admin.users') }}" class="{{ Request::routeIs('admin.users') ? 'active' : '' }}"><i class="fas fa-users"></i> Người Dùng</a></li>
                            <li><a href="{{ route('admin.fields') }}" class="{{ Request::routeIs('admin.fields') ? 'active' : '' }}"><i class="fas fa-layer-group"></i> Sân Bóng</a></li>
                            <li><a href="{{ route('admin.bookings') }}" class="{{ Request::routeIs('admin.bookings') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> Đặt Sân</a></li>
                        @elseif(Auth::user()->isEmployee())
                            <li><a href="{{ route('employee.dashboard') }}" class="{{ Request::routeIs('employee.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                            <li><a href="{{ route('employee.bookings') }}" class="{{ Request::routeIs('employee.bookings') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> Đặt Sân</a></li>
                        @else
                            <li><a href="{{ route('customer.dashboard') }}" class="{{ Request::routeIs('customer.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
                            <li><a href="{{ route('customer.bookings') }}" class="{{ Request::routeIs('customer.bookings') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Lịch Đặt Của Tôi</a></li>
                        @endif
                    </ul>
                    
                    <div class="sidebar-footer">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="d-flex align-items-center gap-3 text-white text-decoration-none opacity-85 hover:opacity-100">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="fw-semibold">Đăng Xuất</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </aside>
                
                <!-- Main Content -->
                <div class="main-content">
                    <!-- Top Navbar -->
                    <nav class="top-navbar">
                        <h2 class="page-title">@yield('page-title', 'Trang Chủ')</h2>
                        <div class="user-dropdown">
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <div class="d-none d-md-block">
                                <div class="fw-semibold text-dark">{{ Auth::user()->name }}</div>
                                <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                            </div>
                        </div>
                    </nav>
                    
                    <!-- Page Content -->
                    <div class="page-content">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show custom-card mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            @yield('content')
            <!-- Footer chỉ hiển thị cho khách hàng hoặc người chưa đăng nhập -->
             
            @guest
                <footer style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: white; padding: 40px 0; margin-top: auto;">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <h5 class="fw-bold mb-3"><i class="fas fa-futbol me-2"></i> Quản lý sân bóng</h5>
                                <p class="opacity-80 mb-3">Hệ thống quản lý đặt sân bóng chuyên nghiệp, nhanh chóng và tiện lợi.</p>
                                <div class="d-flex gap-3">
                                    <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                        <i class="fab fa-facebook-f" style="font-size: 1.2rem;"></i>
                                    </a>
                                    <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                        <i class="fab fa-instagram" style="font-size: 1.2rem;"></i>
                                    </a>
                                    <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                        <i class="fab fa-twitter" style="font-size: 1.2rem;"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <h6 class="fw-semibold mb-3">Liên kết nhanh</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">Trang chủ</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <h6 class="fw-semibold mb-3">Liên hệ</h6>
                                <ul class="list-unstyled opacity-80">
                                    <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> 0123 456 789</li>
                                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@sanbong.com</li>
                                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Hà Nội, Việt Nam</li>
                                </ul>
                            </div>
                        </div>
                        <hr class="opacity-20 my-4">
                        <div class="text-center opacity-70">
                            <small>&copy; {{ date('Y') }} Quản lý sân bóng. All rights reserved.</small>
                        </div>
                    </div>
                </footer>
            @else
                @if(Auth::user()->isCustomer())
                    <footer style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: white; padding: 40px 0; margin-top: auto;">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <h5 class="fw-bold mb-3"><i class="fas fa-futbol me-2"></i> Quản lý sân bóng</h5>
                                    <p class="opacity-80 mb-3">Hệ thống quản lý đặt sân bóng chuyên nghiệp, nhanh chóng và tiện lợi.</p>
                                    <div class="d-flex gap-3">
                                        <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                            <i class="fab fa-facebook-f" style="font-size: 1.2rem;"></i>
                                        </a>
                                        <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                            <i class="fab fa-instagram" style="font-size: 1.2rem;"></i>
                                        </a>
                                        <a href="#" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">
                                            <i class="fab fa-twitter" style="font-size: 1.2rem;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <h6 class="fw-semibold mb-3">Liên kết nhanh</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">Trang chủ</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <h6 class="fw-semibold mb-3">Liên hệ</h6>
                                    <ul class="list-unstyled opacity-80">
                                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> 0123 456 789</li>
                                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@sanbong.com</li>
                                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Hà Nội, Việt Nam</li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="opacity-20 my-4">
                            <div class="text-center opacity-70">
                                <small>&copy; {{ date('Y') }} Quản lý sân bóng. All rights reserved.</small>
                            </div>
                        </div>
                    </footer>
                @endif
            @endguest
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

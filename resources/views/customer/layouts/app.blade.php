<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Trang Chủ') - Quản Lý Sân Bóng</title>
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
        
        .navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white !important;
        }
        
        .user-dropdown .dropdown-toggle {
            color: white !important;
            font-weight: 500;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e40af 100%);
            padding: 60px 0;
            color: white;
        }
        
        .page-content {
            padding: 40px 0;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59,130,246,0.4);
        }
        
        .field-card {
            transition: all 0.3s ease;
        }
        
        .field-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        
        .field-image {
            height: 180px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #64748b;
        }
        
        .badge {
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 500;
        }
        
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #d1fae5; color: #065f46; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <i class="fas fa-futbol me-2"></i> Quản Lý Sân Bóng
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-home me-1"></i> Trang Chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('customer.bookings') ? 'active' : '' }}" href="{{ route('customer.bookings') }}">
                            <i class="fas fa-calendar-check me-1"></i> Lịch Đặt Của Tôi
                        </a>
                    </li>
                </ul>
                <div class="ms-3">
                    <div class="dropdown user-dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: white; padding: 40px 0; margin-top: 60px;">
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
                        <li class="mb-2"><a href="{{ route('customer.dashboard') }}" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">Trang chủ</a></li>
                        <li class="mb-2"><a href="{{ route('customer.bookings') }}" class="text-white opacity-80 hover:opacity-100 text-decoration-none" style="transition: opacity 0.3s;">Lịch sử đặt sân</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

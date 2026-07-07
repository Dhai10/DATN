<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sân Bóng Chuyên Nghiệp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .hero-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 1200px;
            width: 100%;
            overflow: hidden;
        }

        .hero-content {
            padding: 80px 60px;
        }

        .hero-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .hero-image svg {
            max-width: 100%;
            height: auto;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .feature-text {
            color: #334155;
            font-weight: 500;
        }

        .btn-group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 14px 40px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: #f1f5f9;
            color: #1e3a8a;
            padding: 14px 40px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary-custom:hover {
            background: #e0e7ff;
            border-color: #6366f1;
        }

        .stats-section {
            background: #f8fafc;
            padding: 60px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 8px;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            .hero-content {
                padding: 50px 30px;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
                padding: 40px 30px;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .stats-section {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-primary-custom, .btn-secondary-custom {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="hero-card">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Quản Lý Sân Bóng Một Cách Chuyên Nghiệp</h1>
                        <p class="hero-subtitle">Hệ thống quản lý đặt sân bóng hiện đại, giúp bạn quản lý sân, lịch đặt và doanh thu một cách hiệu quả nhất</p>
                        
                        <div class="feature-list">
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-text">Quản lý nhiều sân bóng</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-text">Đặt lịch nhanh chóng</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-text">Theo dõi doanh thu</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-text">Phân quyền người dùng</div>
                            </div>
                        </div>

                        <div class="btn-group">
                            @guest
                                <a href="{{ route('login') }}" class="btn-primary-custom">Đăng Nhập Ngay</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-secondary-custom">Đăng Ký Miễn Phí</a>
                                @endif
                            @else
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn-primary-custom">Vào Trang Admin</a>
                                @elseif(Auth::user()->isEmployee())
                                    <a href="{{ route('employee.dashboard') }}" class="btn-primary-custom">Vào Trang Nhân Viên</a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="btn-primary-custom">Vào Trang Chủ</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-secondary-custom">Đăng Xuất</button>
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <svg width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="20" y="20" width="360" height="360" rx="24" fill="white" fill-opacity="0.1"/>
                            <circle cx="200" cy="200" r="120" stroke="white" stroke-opacity="0.3" stroke-width="4"/>
                            <circle cx="200" cy="200" r="60" stroke="white" stroke-opacity="0.3" stroke-width="4"/>
                            <line x1="200" y1="80" x2="200" y2="320" stroke="white" stroke-opacity="0.3" stroke-width="4"/>
                            <rect x="185" y="185" width="30" height="30" rx="4" fill="white"/>
                            <rect x="120" y="120" width="160" height="160" rx="20" stroke="white" stroke-width="3" fill="none"/>
                            <circle cx="160" cy="160" r="8" fill="white"/>
                            <circle cx="240" cy="160" r="8" fill="white"/>
                            <circle cx="160" cy="240" r="8" fill="white"/>
                            <circle cx="240" cy="240" r="8" fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="stats-section">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Sân Bóng</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Lượt Đặt</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Người Dùng</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99%</div>
                    <div class="stat-label">Hài Lòng</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: white; padding: 40px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-futbol me-2"></i> Quản lý sân bóng</h5>
                    <p class="opacity-80 mb-3">Hệ thống quản lý đặt sân bóng chuyên nghiệp, nhanh chóng và tiện lợi</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

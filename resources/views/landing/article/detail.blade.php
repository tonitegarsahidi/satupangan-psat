<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - PanganAman</title>
    <meta name="description" content="{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 150) }}">

    <!-- Modern CSS Frameworks -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #2E8B57;
            --primary-light: #3fa863;
            --primary-dark: #236846;
            --secondary-color: #FFD700;
            --text-dark: #333333;
            --text-light: #F0F0F0;
            --bg-light: #FAFAFA;
            --bg-white: #FFFFFF;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }
        h5 { font-size: 1.125rem; }

        p {
            margin-bottom: 1rem;
            color: #555;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }


        /* Navigation */
        .navbar {
            background-color: var(--primary-color);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            width: 45px;
            height: 45px;
            margin-right: 12px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: var(--transition);
            padding: 0.5rem 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--secondary-color);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: var(--bg-white);
            min-width: 200px;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-md);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            margin-top: 0.5rem;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1.25rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: rgba(46, 139, 87, 0.1);
            color: var(--primary-color);
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background-color: var(--text-light);
            color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: #E8E8E8;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #FAFAFA 0%, #F0F7F0 100%);
            padding: 140px 0 80px;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="none"/><path d="M0 0L100 100M100 0L0 100" stroke="%23E0E0E0" stroke-width="0.5" opacity="0.3"/></svg>');
            background-size: 40px 40px;
            opacity: 0.3;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        /* Section Styles */
        .section {
            padding: 60px 0;
        }

        /* Article Detail Styles */
        .article-detail {
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .article-featured-image {
            width: 100%;
            /* height: 400px; */
            object-fit: cover;
            border-bottom: 3px solid var(--primary-color);
        }

        .article-content {
            padding: 2rem;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .article-category {
            background-color: var(--primary-color);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .article-date {
            color: #666;
            font-size: 0.875rem;
        }

        .article-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .article-excerpt {
            font-size: 1.125rem;
            color: #555;
            margin-bottom: 2rem;
            font-weight: 500;
            border-left: 4px solid var(--secondary-color);
            padding-left: 1rem;
        }

        .article-body {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
        }

        .article-body h2,
        .article-body h3,
        .article-body h4 {
            color: var(--primary-dark);
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .article-body ul,
        .article-body ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .article-body li {
            margin-bottom: 0.5rem;
        }

        .article-body blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #666;
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .back-button:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 2rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Navigation */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
        }


        /* Responsive Design */
        @media (max-width: 992px) {
            .hero {
                padding: 120px 0 60px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .section {
                padding: 50px 0;
            }

            .article-title {
                font-size: 1.75rem;
            }

            .article-excerpt {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: var(--primary-color);
                flex-direction: column;
                padding: 2rem;
                transition: left 0.3s ease;
            }

            .navbar-menu.active {
                left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .hero {
                padding: 100px 0 50px;
            }

            .hero-content h1 {
                font-size: 1.75rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .article-content {
                padding: 1.5rem;
            }

            .article-title {
                font-size: 1.5rem;
            }

            .article-featured-image {
                height: 250px;
            }
        }
    </style>
</head>

<body>
    @include('components.landing.navbar')

    @include('components.landing.hero', [
        'title' => $article->title,
        'subtitle' => $article->excerpt ?? 'Artikel informatif seputar keamanan pangan'
    ])

    <!-- Main Content -->
    <main class="section">
        <div class="container">
            <!-- Back Button -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <a href="javascript:history.back()" class="back-button">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Full Width Featured Image -->
            @if($article->featured_image)
                <div class="row">
                    <div class="col-12">
                        <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" class="article-featured-image">
                    </div>
                </div>
            @endif

            <!-- Article Content -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <!-- Article Detail -->
                    <div class="article-detail">
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="article-category">{{ ucfirst($article->category) }}</span>
                                <span class="article-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $article->published_at ? $article->published_at->format('l, d F Y \a\t H:i') : 'Draft' }}
                                    @if($article->author)
                                        <span style="margin-left: 1rem;">
                                            <i class="fas fa-user"></i>
                                            {{ $article->author->name }}
                                        </span>
                                    @endif
                                    <span style="margin-left: 1rem;">
                                        <i class="fas fa-eye"></i>
                                        {{ number_format($article->view_count) }} views
                                    </span>
                                </span>
                            </div>

                            <h1 class="article-title">{{ $article->title }}</h1>

                            @if($article->excerpt)
                                <div class="article-excerpt">{{ $article->excerpt }}</div>
                            @endif

                            <div class="article-body">
                                {!! $article->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.landing.footer')

    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const navbarMenu = document.getElementById('navbar-menu');

            if (mobileMenuToggle && navbarMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    navbarMenu.classList.toggle('active');
                    mobileMenuToggle.classList.toggle('active');
                });

                // Close mobile menu when clicking on a link
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        navbarMenu.classList.remove('active');
                        mobileMenuToggle.classList.remove('active');
                    });
                });
            }
        });
    </script>
</body>

</html>

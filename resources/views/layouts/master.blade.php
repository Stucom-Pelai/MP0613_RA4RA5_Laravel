{{-- Author: Maxime Pol Marcet --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Films')</title>

    <!-- Fonts: Inter (SF Pro Alternative) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (Reset & Grid only mainly used) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        :root {
            /* Apple Design System Variables */
            --bg-body: #F5F5F7;
            --bg-card: #FFFFFF;
            --text-primary: #1D1D1F;
            --text-secondary: #86868B;
            --accent-blue: #0066CC;
            --accent-blue-hover: #004499;
            --border-color: #D2D2D7;
            --radius-default: 12px;
            --radius-large: 18px;
            --radius-pill: 980px;
            --shadow-subtle: 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.12);
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--text-primary);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        p {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: var(--accent-blue);
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--accent-blue-hover);
            text-decoration: none;
        }

        /* Layout Blocks */
        header,
        footer {
            background-color: #000;
            /* Keep consistent with banners */
            width: 100%;
        }

        .header-section,
        .footer-section {
            width: 100%;
        }

        .header-title,
        .footer-title {
            background: var(--bg-card);
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .header-title h1,
        .footer-title h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .footer-title {
            border-top: 1px solid var(--border-color);
            border-bottom: none;
        }

        .header-banner,
        .footer-banner {
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            background: #000;
        }

        .header-banner img,
        .footer-banner img {
            width: auto;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .main-content {
            flex: 1;
            padding: 60px 20px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        /* Global Components */
        .btn-apple {
            background-color: var(--accent-blue);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 17px;
            font-weight: 500;
            border-radius: var(--radius-pill);
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
            display: inline-block;
            cursor: pointer;
        }

        .btn-apple:hover {
            background-color: var(--accent-blue-hover);
            transform: scale(1.02);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }

        .card-apple {
            background: var(--bg-card);
            border-radius: var(--radius-large);
            padding: 30px;
            box-shadow: var(--shadow-subtle);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        /* Inputs */
        .form-control {
            border-radius: var(--radius-default);
            border: 1px solid var(--border-color);
            padding: 12px 16px;
            font-size: 17px;
            height: auto;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .mt-4 {
            margin-top: 24px;
        }
    </style>
    @yield('extra-styles')
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-section">
            {{-- Title removed to use full banner image --}}
            <div class="header-banner">
                <img src="{{ asset('img/layout/header.png') }}" alt="Cinema Banner">
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-section">
            {{-- Title and text removed to use full footer image --}}
            <div class="footer-banner">
                <img src="{{ asset('img/layout/footer.png') }}" alt="Footer Banner">
            </div>
            <div class="copyright-text"
                style="background: #f5f5f7; padding: 20px 0; text-align: center; color: #86868b; font-size: 12px; border-top: 1px solid #d2d2d7;">
                Copyright © 2026 Laravel Films by Maxime Pol Marcet. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    @yield('extra-scripts')
</body>

</html>
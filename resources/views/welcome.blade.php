<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AttendancePro | Intelligent Attendance System</title>
    <meta name="description" content="The most advanced attendance management system for modern institutions. Real-time tracking, smart analytics, and seamless management.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --clr-bg: #050815;
            --clr-surface: #0d1225;
            --clr-accent: #3b82f6;
            --clr-accent2: #8b5cf6;
            --clr-accent3: #06b6d4;
            --clr-text: #e2e8f0;
            --clr-muted: #64748b;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--clr-bg);
            color: var(--clr-text);
            overflow-x: hidden;
        }



        /* ── Navbar ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 5%;
            transition: all 0.4s ease;
        }
        nav.scrolled {
            background: rgba(5, 8, 21, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding: 0.9rem 5%;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, var(--clr-accent), var(--clr-accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; box-shadow: 0 0 20px rgba(59,130,246,0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .nav-logo-icon:hover { transform: rotate(10deg); box-shadow: 0 0 30px rgba(59,130,246,0.6); }
        .nav-logo-text { font-size: 1.25rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
        .nav-logo-text span { background: linear-gradient(135deg, var(--clr-accent), var(--clr-accent2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            color: var(--clr-muted); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; position: relative; transition: color 0.3s;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -3px; left: 0; width: 0; height: 2px;
            background: linear-gradient(90deg, var(--clr-accent), var(--clr-accent2));
            border-radius: 2px; transition: width 0.3s ease;
        }
        .nav-links a:hover { color: #fff; }
        .nav-links a:hover::after { width: 100%; }
        .btn-nav {
            padding: 0.6rem 1.5rem; border-radius: 50px;
            background: linear-gradient(135deg, var(--clr-accent), var(--clr-accent2));
            color: #fff; font-weight: 600; font-size: 0.875rem;
            text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 0 20px rgba(59,130,246,0.35);
            transition: all 0.3s ease; display: inline-block;
        }
        .btn-nav:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(59,130,246,0.55); }

        /* ── Hero ── */
        .hero {
            position: relative; z-index: 10;
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 8rem 5% 4rem;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.45rem 1.2rem; border-radius: 50px;
            border: 1px solid rgba(59,130,246,0.35);
            background: rgba(59,130,246,0.08);
            color: #93c5fd; font-size: 0.78rem; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease both;
        }
        .badge-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 8px #3b82f6;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.8); } }

        .hero-title {
            font-size: clamp(2.8rem, 7vw, 6rem);
            font-weight: 900; line-height: 1.05;
            letter-spacing: -0.04em;
            color: #fff; margin-bottom: 1.5rem;
            animation: fadeInUp 0.9s ease 0.2s both;
        }
        .hero-title .gradient-word {
            background: linear-gradient(135deg, #60a5fa, #c084fc, #22d3ee);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shimmer 4s linear infinite;
        }
        @keyframes shimmer { to { background-position: 200% center; } }

        .hero-sub {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--clr-muted); max-width: 640px;
            line-height: 1.7; margin-bottom: 2.5rem;
            animation: fadeInUp 0.9s ease 0.4s both;
        }
        .hero-cta {
            display: flex; gap: 1rem; flex-wrap: wrap;
            justify-content: center; margin-bottom: 4rem;
            animation: fadeInUp 0.9s ease 0.6s both;
        }
        .btn-primary {
            padding: 0.9rem 2.2rem; border-radius: 50px;
            background: linear-gradient(135deg, var(--clr-accent), var(--clr-accent2));
            color: #fff; font-weight: 700; font-size: 1rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
            box-shadow: 0 0 30px rgba(59,130,246,0.4);
            transition: all 0.35s ease; position: relative; overflow: hidden;
        }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 0 50px rgba(59,130,246,0.6); }
        .btn-primary:hover::before { opacity: 1; }

        .btn-secondary {
            padding: 0.9rem 2.2rem; border-radius: 50px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff; font-weight: 600; font-size: 1rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.35s ease; backdrop-filter: blur(10px);
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.25); transform: translateY(-3px); }

        /* ── Stats Bar ── */
        .stats-bar {
            display: flex; gap: 2.5rem; flex-wrap: wrap; justify-content: center;
            animation: fadeInUp 0.9s ease 0.8s both;
        }
        .stat-item { text-align: center; }
        .stat-num {
            font-size: 1.75rem; font-weight: 900; color: #fff;
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .stat-label { font-size: 0.75rem; color: var(--clr-muted); font-weight: 500; margin-top: 0.1rem; }
        .stat-divider { width: 1px; background: rgba(255,255,255,0.1); align-self: stretch; }

        /* ── Dashboard Mockup ── */
        .mockup-wrap {
            position: relative; z-index: 10;
            max-width: 1100px; margin: 0 auto;
            padding: 0 5% 6rem;
            animation: fadeInUp 1s ease 1s both;
        }
        .mockup-glow {
            position: absolute; inset: -60px;
            background: radial-gradient(ellipse at center, rgba(59,130,246,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .mockup-frame {
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(13, 18, 37, 0.8);
            backdrop-filter: blur(20px);
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05);
            transform: perspective(1000px) rotateX(4deg);
            transition: transform 0.6s ease;
        }
        .mockup-frame:hover { transform: perspective(1000px) rotateX(0deg) scale(1.01); }
        .mockup-topbar {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.9rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            background: rgba(255,255,255,0.03);
        }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-r { background: #ff5f57; }
        .dot-y { background: #ffbd2e; }
        .dot-g { background: #28c840; }
        .mockup-url {
            margin-left: 0.75rem; flex: 1;
            background: rgba(255,255,255,0.05); border-radius: 6px;
            padding: 0.25rem 0.75rem; font-size: 0.75rem; color: var(--clr-muted);
            max-width: 300px;
        }
        .mockup-body {
            display: grid; grid-template-columns: 200px 1fr;
            min-height: 380px;
        }
        .mock-sidebar {
            background: rgba(255,255,255,0.02);
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 1.25rem 0.75rem;
            display: flex; flex-direction: column; gap: 0.4rem;
        }
        .mock-sidebar-logo {
            padding: 0.5rem 0.75rem; font-size: 0.85rem; font-weight: 800;
            color: #fff; margin-bottom: 1rem;
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .mock-nav-item {
            padding: 0.55rem 0.75rem; border-radius: 8px; font-size: 0.78rem;
            color: var(--clr-muted); display: flex; align-items: center; gap: 0.5rem;
        }
        .mock-nav-item.active { background: rgba(59,130,246,0.15); color: #93c5fd; }
        .mock-nav-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
        .mock-content { padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; }
        .mock-header { display: flex; align-items: center; justify-content: space-between; }
        .mock-title { font-size: 0.9rem; font-weight: 700; color: #fff; }
        .mock-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.68rem; background: rgba(59,130,246,0.2); color: #93c5fd; font-weight: 600; }
        .mock-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
        .mock-card {
            border-radius: 10px; padding: 0.85rem;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .mc-1 { background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(59,130,246,0.05)); }
        .mc-2 { background: linear-gradient(135deg, rgba(139,92,246,0.15), rgba(139,92,246,0.05)); }
        .mc-3 { background: linear-gradient(135deg, rgba(6,182,212,0.15), rgba(6,182,212,0.05)); }
        .mc-label { font-size: 0.65rem; color: var(--clr-muted); margin-bottom: 0.25rem; }
        .mc-val { font-size: 1.25rem; font-weight: 800; color: #fff; }
        .mock-bar-wrap { background: rgba(255,255,255,0.04); border-radius: 8px; padding: 0.75rem; }
        .mock-bar-label { font-size: 0.65rem; color: var(--clr-muted); margin-bottom: 0.5rem; }
        .mock-bars { display: flex; align-items: flex-end; gap: 4px; height: 50px; }
        .mock-bar {
            flex: 1; border-radius: 3px 3px 0 0;
            background: linear-gradient(to top, var(--clr-accent), var(--clr-accent2));
            animation: barGrow 1s ease both;
            transform-origin: bottom;
        }
        @keyframes barGrow { from { transform: scaleY(0); } to { transform: scaleY(1); } }
        .mock-bar:nth-child(1) { height: 60%; animation-delay: 1.2s; }
        .mock-bar:nth-child(2) { height: 80%; animation-delay: 1.3s; }
        .mock-bar:nth-child(3) { height: 45%; animation-delay: 1.4s; }
        .mock-bar:nth-child(4) { height: 90%; animation-delay: 1.5s; }
        .mock-bar:nth-child(5) { height: 65%; animation-delay: 1.6s; }
        .mock-bar:nth-child(6) { height: 75%; animation-delay: 1.7s; }
        .mock-bar:nth-child(7) { height: 55%; animation-delay: 1.8s; }

        /* ── Section shared ── */
        section { position: relative; z-index: 10; }
        .section-inner { max-width: 1200px; margin: 0 auto; padding: 6rem 5%; }
        .section-label {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase;
            color: #60a5fa; margin-bottom: 1rem;
        }
        .section-title {
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 900; color: #fff; letter-spacing: -0.03em;
            line-height: 1.1; margin-bottom: 1rem;
        }
        .section-sub { font-size: 1.05rem; color: var(--clr-muted); max-width: 540px; line-height: 1.7; }

        /* ── Features ── */
        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem; margin-top: 3.5rem;
        }
        .feature-card {
            border-radius: 20px; padding: 2rem;
            border: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: var(--card-gradient);
            opacity: 0; transition: opacity 0.4s;
        }
        .feature-card:hover { transform: translateY(-8px); background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.12); }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.25rem;
            background: var(--card-gradient);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .feature-name { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 0.6rem; }
        .feature-desc { font-size: 0.9rem; color: var(--clr-muted); line-height: 1.65; }

        /* ── How it works ── */
        .steps-wrap {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem; margin-top: 3.5rem; position: relative;
        }
        .step-card {
            text-align: center; padding: 2rem 1.5rem;
            border-radius: 20px; border: 1px solid rgba(255,255,255,0.06);
            background: rgba(255,255,255,0.02);
            transition: all 0.4s ease;
        }
        .step-card:hover { transform: translateY(-6px); background: rgba(255,255,255,0.04); }
        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-accent), var(--clr-accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; font-weight: 900; color: #fff;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 25px rgba(59,130,246,0.35);
        }
        .step-title { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
        .step-desc { font-size: 0.875rem; color: var(--clr-muted); line-height: 1.6; }

        /* ── Team ── */
        .team-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem; margin-top: 3.5rem;
        }
        .team-card {
            border-radius: 20px; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.03);
            transition: all 0.4s ease; position: relative;
        }
        .team-card:hover { transform: translateY(-8px); border-color: rgba(59,130,246,0.3); box-shadow: 0 20px 50px rgba(0,0,0,0.3), 0 0 0 1px rgba(59,130,246,0.2); }
        .team-avatar {
            width: 100%; aspect-ratio: 1;
            background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(139,92,246,0.2));
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem; overflow: hidden;
        }
        .team-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .team-info { padding: 1.25rem; }
        .team-name { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
        .team-role { font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; }

        /* ── CTA Section ── */
        .cta-section {
            position: relative; z-index: 10;
            padding: 2rem 5% 6rem;
        }
        .cta-box {
            max-width: 900px; margin: 0 auto;
            border-radius: 28px; padding: 4rem;
            text-align: center;
            border: 1px solid rgba(59,130,246,0.2);
            background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(139,92,246,0.08));
            backdrop-filter: blur(20px);
            position: relative; overflow: hidden;
        }
        .cta-glow-1 { position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; border-radius: 50%; background: rgba(59,130,246,0.2); filter: blur(60px); }
        .cta-glow-2 { position: absolute; bottom: -50px; left: -50px; width: 250px; height: 250px; border-radius: 50%; background: rgba(139,92,246,0.2); filter: blur(60px); }
        .cta-title { font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 900; color: #fff; letter-spacing: -0.03em; margin-bottom: 1rem; position: relative; z-index: 1; }
        .cta-sub { font-size: 1rem; color: var(--clr-muted); margin-bottom: 2rem; position: relative; z-index: 1; }
        .cta-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1; }

        /* ── Footer ── */
        footer {
            position: relative; z-index: 10;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 2rem 5%;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
            background: rgba(5,8,21,0.5);
        }
        .footer-logo { font-size: 1rem; font-weight: 800; color: #fff; }
        .footer-logo span { background: linear-gradient(135deg, #60a5fa, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .footer-copy { font-size: 0.8rem; color: var(--clr-muted); }

        /* ── Reveal animations ── */
        .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .mockup-body { grid-template-columns: 1fr; }
            .mock-sidebar { display: none; }
            .mock-cards { grid-template-columns: 1fr 1fr; }
            .cta-box { padding: 2.5rem 1.5rem; }
            nav .nav-links { display: none; }
            .stats-bar { gap: 1.5rem; }
            .stat-divider { display: none; }
        }
    </style>
</head>
<body>
    <x-animated-bg />

    <!-- Navbar -->
    <nav id="navbar">
        <a href="#" class="nav-logo">
            <div class="nav-logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="nav-logo-text">Attendance<span>Pro</span></span>
        </a>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#team">Team</a>
        </div>
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="btn-nav">Sign In &rarr;</a>
        @endif
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-badge">
            <span class="badge-dot"></span>
            Now with AI-powered insights
        </div>
        <h1 class="hero-title">
            Smart Attendance<br>
            <span class="gradient-word">Redefined.</span>
        </h1>
        <p class="hero-sub">
            The most intelligent attendance management platform for modern institutions. Track, analyze, and optimize — all in real time.
        </p>
        <div class="hero-cta">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-primary">
                    Access Portal
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
            <a href="#features" class="btn-secondary">
                Explore Features
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 9l-7 7-7-7"/></svg>
            </a>
        </div>
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-num" data-count="5000">0</div>
                <div class="stat-label">Students Tracked</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-num" data-count="99">0</div>
                <div class="stat-label">% Uptime</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-num" data-count="150">0</div>
                <div class="stat-label">Institutions</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-num" data-count="24">0</div>
                <div class="stat-label">/ 7 Support</div>
            </div>
        </div>
    </section>

    <!-- Dashboard Mockup -->
    <div class="mockup-wrap reveal">
        <div class="mockup-glow"></div>
        <div class="mockup-frame">
            <div class="mockup-topbar">
                <span class="dot dot-r"></span>
                <span class="dot dot-y"></span>
                <span class="dot dot-g"></span>
                <span class="mockup-url">attendancepro.app/dashboard</span>
            </div>
            <div class="mockup-body">
                <div class="mock-sidebar">
                    <div class="mock-sidebar-logo">AttendancePro</div>
                    <div class="mock-nav-item active"><span class="mock-nav-dot"></span>Dashboard</div>
                    <div class="mock-nav-item"><span class="mock-nav-dot"></span>Students</div>
                    <div class="mock-nav-item"><span class="mock-nav-dot"></span>Teachers</div>
                    <div class="mock-nav-item"><span class="mock-nav-dot"></span>Subjects</div>
                    <div class="mock-nav-item"><span class="mock-nav-dot"></span>Reports</div>
                    <div class="mock-nav-item"><span class="mock-nav-dot"></span>Settings</div>
                </div>
                <div class="mock-content">
                    <div class="mock-header">
                        <div class="mock-title">Overview — March 2025</div>
                        <div class="mock-badge">Live</div>
                    </div>
                    <div class="mock-cards">
                        <div class="mock-card mc-1">
                            <div class="mc-label">Present Today</div>
                            <div class="mc-val">1,284</div>
                        </div>
                        <div class="mock-card mc-2">
                            <div class="mc-label">Absent</div>
                            <div class="mc-val">67</div>
                        </div>
                        <div class="mock-card mc-3">
                            <div class="mc-label">Attendance Rate</div>
                            <div class="mc-val">95%</div>
                        </div>
                    </div>
                    <div class="mock-bar-wrap">
                        <div class="mock-bar-label">Weekly Attendance Trend</div>
                        <div class="mock-bars">
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                            <div class="mock-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <section id="features">
        <div class="section-inner">
            <div class="reveal">
                <div class="section-label">⚡ Features</div>
                <h2 class="section-title">Everything your institution<br>needs to thrive</h2>
                <p class="section-sub">Built with cutting-edge technology to give educators and administrators the power to succeed.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal reveal-delay-1" style="--card-gradient: linear-gradient(135deg,#3b82f6,#06b6d4)">
                    <div class="feature-icon">⚡</div>
                    <div class="feature-name">Real-Time Sync</div>
                    <div class="feature-desc">Attendance data propagates instantly across all connected terminals and dashboards without any delay.</div>
                </div>
                <div class="feature-card reveal reveal-delay-2" style="--card-gradient: linear-gradient(135deg,#8b5cf6,#ec4899)">
                    <div class="feature-icon">📊</div>
                    <div class="feature-name">Smart Analytics</div>
                    <div class="feature-desc">AI-driven reports surface trends, risks, and insights automatically so you can act before problems arise.</div>
                </div>
                <div class="feature-card reveal reveal-delay-3" style="--card-gradient: linear-gradient(135deg,#06b6d4,#10b981)">
                    <div class="feature-icon">🔐</div>
                    <div class="feature-name">Secure & Private</div>
                    <div class="feature-desc">Bank-grade encryption and role-based access control keep every student record safe and confidential.</div>
                </div>
                <div class="feature-card reveal reveal-delay-1" style="--card-gradient: linear-gradient(135deg,#f59e0b,#ef4444)">
                    <div class="feature-icon">📱</div>
                    <div class="feature-name">QR Code Scanning</div>
                    <div class="feature-desc">Frictionless check-ins using QR codes — students scan and their attendance is logged automatically.</div>
                </div>
                <div class="feature-card reveal reveal-delay-2" style="--card-gradient: linear-gradient(135deg,#10b981,#3b82f6)">
                    <div class="feature-icon">👥</div>
                    <div class="feature-name">Multi-Role Access</div>
                    <div class="feature-desc">Separate portals for admins, teachers, students, and parents with tailored views and permissions.</div>
                </div>
                <div class="feature-card reveal reveal-delay-3" style="--card-gradient: linear-gradient(135deg,#ec4899,#8b5cf6)">
                    <div class="feature-icon">🔔</div>
                    <div class="feature-name">Instant Alerts</div>
                    <div class="feature-desc">Automated notifications keep parents and administrators informed the moment an absence is recorded.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="how-it-works" style="background: rgba(255,255,255,0.015);">
        <div class="section-inner">
            <div class="reveal" style="text-align:center;">
                <div class="section-label" style="justify-content:center;">🚀 How It Works</div>
                <h2 class="section-title" style="text-align:center;">Up and running in minutes</h2>
                <p class="section-sub" style="margin: 0 auto;">Simple, guided setup gets your institution fully operational without any technical expertise required.</p>
            </div>
            <div class="steps-wrap">
                <div class="step-card reveal reveal-delay-1">
                    <div class="step-num">1</div>
                    <div class="step-title">Create Your Account</div>
                    <div class="step-desc">Admin registers the institution and configures academic structure — courses, sections, subjects.</div>
                </div>
                <div class="step-card reveal reveal-delay-2">
                    <div class="step-num">2</div>
                    <div class="step-title">Add Users</div>
                    <div class="step-desc">Import or add teachers and students. Accounts are auto-created with login credentials sent via email.</div>
                </div>
                <div class="step-card reveal reveal-delay-3">
                    <div class="step-num">3</div>
                    <div class="step-title">Track Attendance</div>
                    <div class="step-desc">Teachers mark attendance manually or students scan QR codes. Data is recorded instantly.</div>
                </div>
                <div class="step-card reveal reveal-delay-4">
                    <div class="step-num">4</div>
                    <div class="step-title">Gain Insights</div>
                    <div class="step-desc">View trends, generate reports, and receive alerts — all automated from a single dashboard.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section id="team">
        <div class="section-inner">
            <div class="reveal" style="text-align:center;">
                <div class="section-label" style="justify-content:center;">👨‍💻 Our Team</div>
                <h2 class="section-title" style="text-align:center;">Built by passionate developers</h2>
                <p class="section-sub" style="margin: 0 auto;">Meet the minds behind AttendancePro — dedicated to transforming institutional management.</p>
            </div>
            <div class="team-grid">
                <div class="team-card reveal reveal-delay-1">
                    <div class="team-avatar">
                        <img src="{{ asset('images/team/joelito.jpg') }}" alt="Joelito Serafin" onerror="this.parentElement.innerHTML='👨‍💻'">
                    </div>
                    <div class="team-info">
                        <div class="team-name">Joelito Serafin</div>
                        <div class="team-role" style="color:#60a5fa">Lead Developer</div>
                    </div>
                </div>
                <div class="team-card reveal reveal-delay-2">
                    <div class="team-avatar">
                        <img src="{{ asset('images/team/maria.png') }}" alt="Maria Santos" onerror="this.parentElement.innerHTML='👩‍🎨'">
                    </div>
                    <div class="team-info">
                        <div class="team-name">Maria Santos</div>
                        <div class="team-role" style="color:#c084fc">UI/UX Designer</div>
                    </div>
                </div>
                <div class="team-card reveal reveal-delay-3">
                    <div class="team-avatar">
                        <img src="{{ asset('images/team/john.png') }}" alt="John Doe" onerror="this.parentElement.innerHTML='👨‍🔧'">
                    </div>
                    <div class="team-info">
                        <div class="team-name">John Doe</div>
                        <div class="team-role" style="color:#22d3ee">Backend Architect</div>
                    </div>
                </div>
                <div class="team-card reveal reveal-delay-4">
                    <div class="team-avatar">
                        <img src="{{ asset('images/team/jane.png') }}" alt="Jane Smith" onerror="this.parentElement.innerHTML='👩‍💼'">
                    </div>
                    <div class="team-info">
                        <div class="team-name">Jane Smith</div>
                        <div class="team-role" style="color:#34d399">Project Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-box reveal">
            <div class="cta-glow-1"></div>
            <div class="cta-glow-2"></div>
            <h2 class="cta-title">Ready to transform your<br>institution's attendance?</h2>
            <p class="cta-sub">Join a growing community of educators who chose precision over paperwork.</p>
            <div class="cta-actions">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn-primary">
                        Get Started Free
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endif
                <a href="#features" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-logo">Attendance<span>Pro</span></div>
        <p class="footer-copy">&copy; {{ date('Y') }} AttendancePro. All rights reserved.</p>
        <div style="display:flex;gap:1rem;">
            <a href="#" style="color:#475569;transition:color 0.3s" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#475569'">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
            </a>
            <a href="#" style="color:#475569;transition:color 0.3s" onmouseover="this.style.color='#c084fc'" onmouseout="this.style.color='#475569'">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.31.974.974 1.248 2.242 1.31 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.31 3.608-.974.974-2.242 1.248-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.31-.974-.974-1.248-2.242-1.31-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.336-2.633 1.31-3.608.974-.974 2.242-1.248 3.608-1.31 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.073 4.948.073s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
        </div>
    </footer>

    <script>


    // ── Navbar scroll ──
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    });

    // ── Counter animation ──
    function animateCounters() {
        document.querySelectorAll('[data-count]').forEach(el => {
            const target = parseInt(el.dataset.count);
            const suffix = target === 99 ? '%' : target === 24 ? '' : '+';
            let current = 0;
            const step = target / 60;
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = Math.floor(current).toLocaleString() + suffix;
                if (current >= target) clearInterval(timer);
            }, 25);
        });
    }
    setTimeout(animateCounters, 800);

    // ── Scroll Reveal ──
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));


    </script>
</body>
</html>

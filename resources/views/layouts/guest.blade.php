<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AttendancePro') }} — Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Outfit', sans-serif; }

        /* ── Dark Polygon Background ──────────────────────────── */
        .auth-bg {
            min-height: 100vh;
            background: radial-gradient(ellipse at 70% 10%, #1a3a3a 0%, #0d1f2d 40%, #1a0a2e 100%);
            position: relative;
            overflow: hidden;
        }

        /* animated dots */
        .auth-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(32,178,170,0.18) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0,206,209,0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(75,0,130,0.12) 0%, transparent 60%);
            pointer-events: none;
        }

        /* ── Polygon SVG layer ───────────────────────────────── */
        .poly-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            opacity: 0.55;
        }

        /* ── Login card ──────────────────────────────────────── */
        .login-card {
            background: linear-gradient(145deg, rgba(32,90,80,0.55) 0%, rgba(10,30,50,0.75) 100%);
            backdrop-filter: blur(20px) saturate(160%);
            border: 1px solid rgba(32,178,170,0.25);
            border-radius: 16px;
            box-shadow:
                0 0 0 1px rgba(0,206,209,0.08),
                0 30px 60px -20px rgba(0,0,0,0.7),
                inset 0 1px 0 rgba(255,255,255,0.06);
        }

        /* ── Input styling ───────────────────────────────────── */
        .auth-input {
            width: 100%;
            background: rgba(0, 30, 40, 0.6);
            border: 1px solid rgba(32,178,170,0.3);
            border-radius: 8px;
            padding: 12px 16px 12px 44px;
            color: #e2e8f0;
            font-size: 14px;
            outline: none;
            transition: all 0.25s;
        }
        .auth-input::placeholder { color: rgba(148,163,184,0.6); }
        .auth-input:focus {
            border-color: rgba(32,178,170,0.7);
            box-shadow: 0 0 0 3px rgba(32,178,170,0.15);
            background: rgba(0, 40, 50, 0.7);
        }
        .auth-input-wrap { position: relative; }
        .auth-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(32,178,170,0.7);
            pointer-events: none;
        }

        /* ── Login button ────────────────────────────────────── */
        .login-btn {
            width: 100%;
            padding: 13px;
            background: #ffffff;
            color: #1a2332;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s;
        }
        .login-btn:hover {
            background: #e2e8f0;
            box-shadow: 0 4px 20px rgba(255,255,255,0.15);
            transform: translateY(-1px);
        }
        .login-btn:active { transform: translateY(0); }

        /* ── Title ───────────────────────────────────────────── */
        .login-title {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(32,178,170,0.9);
            text-align: center;
            margin-bottom: 28px;
        }

        /* ── Label ───────────────────────────────────────────── */
        .auth-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(148,163,184,0.8);
            margin-bottom: 6px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* ── Checkbox ────────────────────────────────────────── */
        input[type="checkbox"] {
            accent-color: #20b2aa;
        }

        /* ── Divider ─────────────────────────────────────────── */
        .divider {
            border: none;
            border-top: 1px solid rgba(32,178,170,0.2);
            margin: 20px 0;
        }

        /* ── Floating shapes (like the reference image) ──────── */
        @keyframes floatShape { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }
        .shape { animation: floatShape 6s ease-in-out infinite; }
        .shape-2 { animation-delay: 2s; animation-duration: 8s; }
        .shape-3 { animation-delay: 4s; animation-duration: 7s; }
    </style>
</head>
<body style="margin:0;padding:0;">

<div class="auth-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;">

    <!-- Animated Particle Background -->
    <x-animated-bg />

    <!-- Login Card -->
    <div class="login-card" style="position:relative;z-index:10;width:100%;max-width:380px;padding:40px 36px;">

        <p class="login-title">Member Login</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{ $slot }}

    </div>
</div>

</body>
</html>

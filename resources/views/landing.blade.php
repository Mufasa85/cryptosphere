<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptoSphere — Fastest Way to Follow Crypto Markets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #050B12;
            --bg-secondary: #07131B;
            --bg-tertiary: #0B1E2B;
            --card-bg: #0D1823;
            --border: #142634;
            --neon-green: #3DFF7A;
            --neon-soft: #A6FF5B;
            --glow-green: #00C45A;
            --text-primary: #E9F2F7;
            --text-secondary: #AEBBC6;
            --accent-blue: #49A7FF;
            --accent-purple: #8C7CFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            width: 92%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--neon-green);
            color: var(--bg-primary);
            box-shadow: 0 0 25px var(--glow-green);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 40px var(--glow-green);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            border-color: var(--neon-green);
            color: var(--neon-green);
        }

        .neon {
            color: var(--neon-green);
            text-shadow: 0 0 15px var(--glow-green);
        }

        .glass {
            background: rgba(13, 24, 35, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid var(--border);
            background: rgba(61, 255, 122, 0.08);
            color: var(--neon-green);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--neon-green);
            box-shadow: 0 0 10px var(--glow-green);
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
        }

        .text-secondary {
            color: var(--text-secondary);
        }

        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 16px 0;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--text-primary);
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--neon-green), var(--glow-green));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px var(--glow-green);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: 0.95rem;
            color: var(--text-secondary);
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--neon-green);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger span {
            width: 26px;
            height: 2px;
            background: var(--text-primary);
            border-radius: 2px;
        }

        /* Hero */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 120px;
            padding-bottom: 80px;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(0, 196, 90, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero h1 {
            font-size: clamp(2.6rem, 5vw, 4.5rem);
            font-weight: 700;
            margin-bottom: 24px;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 480px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-visual {
            position: relative;
            animation: float 6s ease-in-out infinite;
            display: flex;
            justify-content: center;
        }

        .hero-visual svg {
            width: 100%;
            max-width: 500px;
            filter: drop-shadow(0 25px 60px rgba(0, 0, 0, 0.6));
        }

        /* Sections */
        .section {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: clamp(2rem, 3vw, 2.8rem);
            margin-bottom: 12px;
        }

        .section-header p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Crypto Cards */
        .crypto-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .crypto-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.35s ease;
        }

        .crypto-card:hover {
            transform: translateY(-10px);
            border-color: var(--glow-green);
            box-shadow: 0 0 30px rgba(0, 196, 90, 0.15);
        }

        .crypto-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .crypto-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-tertiary);
        }

        .crypto-name {
            font-weight: 600;
        }

        .crypto-symbol {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .crypto-price {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .crypto-change {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .crypto-change.up {
            color: var(--neon-green);
        }

        .crypto-change.down {
            color: #FF6B6B;
        }

        .mini-chart {
            width: 100%;
            height: 50px;
            margin-bottom: 16px;
        }

        .crypto-card .btn {
            width: 100%;
            padding: 10px;
        }

        /* Calculator */
        .calc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .calc-info h2 {
            font-size: clamp(2rem, 3vw, 2.8rem);
            margin-bottom: 20px;
        }

        .calc-info p {
            color: var(--text-secondary);
            margin-bottom: 28px;
        }

        .converter-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
        }

        .converter-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .converter-field {
            flex: 1;
        }

        .converter-field label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .converter-field input,
        .converter-field select {
            width: 100%;
            padding: 14px 16px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 1rem;
        }

        .swap-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--neon-green);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 20px var(--glow-green);
            flex-shrink: 0;
        }

        .converter-result {
            text-align: center;
            padding: 24px;
            border-radius: 16px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            margin-top: 10px;
        }

        .converter-result .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--neon-green);
        }

        .converter-result .label {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Deposit */
        .deposit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .deposit-info h2 {
            font-size: clamp(2rem, 3vw, 2.8rem);
            margin-bottom: 20px;
        }

        .deposit-info p {
            color: var(--text-secondary);
            margin-bottom: 28px;
        }

        .deposit-list {
            margin-bottom: 32px;
        }

        .deposit-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            color: var(--text-secondary);
        }

        .deposit-list li::before {
            content: '✔';
            color: var(--neon-green);
            font-weight: 700;
        }

        .deposit-visual {
            display: flex;
            justify-content: center;
            animation: float 7s ease-in-out infinite;
        }

        .deposit-visual svg {
            width: 100%;
            max-width: 420px;
            filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.5));
        }

        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            transition: all 0.35s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 0 30px rgba(0, 196, 90, 0.12);
            border-color: rgba(0, 196, 90, 0.5);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(61, 255, 122, 0.15), rgba(0, 196, 90, 0.05));
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--neon-green);
        }

        .feature-card h3 {
            font-size: 1.15rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Partners */
        .partners {
            padding: 60px 0;
            overflow: hidden;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .partners-track {
            display: flex;
            gap: 80px;
            width: max-content;
            animation: scroll 24s linear infinite;
        }

        .partner-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-secondary);
            opacity: 0.6;
            transition: opacity 0.3s;
            white-space: nowrap;
        }

        .partner-logo:hover {
            opacity: 1;
            color: var(--neon-green);
        }

        /* CTA */
        .cta-section {
            border-radius: 32px;
            background: radial-gradient(circle at top left, rgba(0, 196, 90, 0.25), var(--bg-primary) 55%);
            border: 1px solid var(--border);
            padding: 80px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(61, 255, 122, 0.08) 0%, transparent 50%);
            animation: glowPulse 6s ease-in-out infinite;
            z-index: -1;
        }

        .cta-section h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            margin-bottom: 16px;
        }

        .cta-section p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 32px;
        }

        .cta-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Footer */
        .footer {
            padding: 80px 0 40px;
            border-top: 1px solid var(--border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 2fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-brand p {
            color: var(--text-secondary);
            margin: 16px 0;
            font-size: 0.95rem;
        }

        .footer-links h4 {
            font-size: 1rem;
            margin-bottom: 20px;
            color: var(--text-primary);
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--text-secondary);
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--neon-green);
        }

        .newsletter h4 {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 12px 16px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: inherit;
        }

        .newsletter-form button {
            padding: 12px 20px;
            background: var(--neon-green);
            border: none;
            border-radius: 10px;
            color: var(--bg-primary);
            font-weight: 600;
            cursor: pointer;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Reveal animation */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Keyframes */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glowPulse {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .crypto-grid,
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                flex-direction: column;
                background: var(--bg-secondary);
                padding: 24px;
                gap: 20px;
                transform: translateY(-150%);
                transition: transform 0.35s ease;
                border-bottom: 1px solid var(--border);
            }

            .nav-links.active {
                transform: translateY(0);
            }

            .hamburger {
                display: flex;
            }

            .nav-actions .btn-secondary {
                display: none;
            }

            .hero-grid,
            .calc-grid,
            .deposit-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding-top: 100px;
            }

            .hero h1 {
                font-size: 2.6rem;
            }

            .hero-visual {
                order: -1;
            }

            .crypto-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }

            .calc-info,
            .deposit-info {
                text-align: center;
            }

            .deposit-visual {
                order: -1;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .cta-section {
                padding: 50px 24px;
            }

            .converter-row {
                flex-direction: column;
            }

            .swap-btn {
                transform: rotate(90deg);
            }
        }
    </style>
</head>
<body>
    <canvas id="particles-canvas"></canvas>

    <nav class="navbar glass">
        <div class="container nav-container">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L3 7L12 12L21 7L12 2Z" fill="#050B12"/>
                        <path d="M3 17L12 22L21 17" stroke="#050B12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 12L12 17L21 12" stroke="#050B12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                CryptoSphere
            </a>

            <ul class="nav-links" id="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#markets">Markets</a></li>
                <li><a href="#exchange">Exchange</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                <a href="#" class="btn btn-primary">Connect Wallet</a>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <div class="badge">
                    <span class="badge-dot"></span>
                    #1 Crypto Trading Platform
                </div>
                <h1>
                    FASTEST WAY<br>
                    TO FOLLOW<br>
                    <span class="neon">CRYPTO</span> MARKETS
                </h1>
                <p>
                    Trade, invest and manage digital assets through a secure next-generation platform.
                </p>
                <div class="hero-actions">
                    <a href="#markets" class="btn btn-primary">Explore Market</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Get Started</a>
                </div>
            </div>

            <div class="hero-visual reveal">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="metalGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#F3D28A"/>
                            <stop offset="40%" style="stop-color:#C8A24B"/>
                            <stop offset="100%" style="stop-color:#6B4E12"/>
                        </linearGradient>
                        <linearGradient id="ethGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#F3D28A"/>
                            <stop offset="50%" style="stop-color:#C8A24B"/>
                            <stop offset="100%" style="stop-color:#6B4E12"/>
                        </linearGradient>
                        <filter id="glow">
                            <feGaussianBlur stdDeviation="8" result="coloredBlur"/>
                            <feMerge>
                                <feMergeNode in="coloredBlur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <g transform="translate(250,250)">
                        <ellipse cx="0" cy="140" rx="140" ry="25" fill="rgba(0,0,0,0.4)" filter="url(#glow)"/>
                        <path d="M-70 90 Q-110 50 -90 0 Q-70 -60 0 -80 Q70 -60 90 0 Q110 50 70 90 Q0 130 -70 90" fill="url(#metalGrad)" stroke="#F3D28A" stroke-width="2"/>
                        <path d="M-50 70 Q-70 40 -50 10 Q-30 -30 0 -40 Q30 -30 50 10 Q70 40 50 70 Q0 100 -50 70" fill="rgba(255,255,255,0.1)"/>
                        <path d="M0 20 L0 60" stroke="#6B4E12" stroke-width="3" stroke-linecap="round"/>
                    </g>
                    <g transform="translate(250,180)" filter="url(#glow)">
                        <polygon points="0,-70 55,0 0,90 -55,0" fill="url(#ethGrad)" stroke="#F3D28A" stroke-width="2"/>
                        <polygon points="0,-70 55,0 0,25 -55,0" fill="rgba(255,255,255,0.25)"/>
                        <polygon points="0,25 55,0 0,90 -55,0" fill="rgba(0,0,0,0.15)"/>
                    </g>
                </svg>
            </div>
        </div>
    </section>

    <section class="section" id="markets">
        <div class="container">
            <div class="section-header reveal">
                <h2>Top Crypto <span class="neon">Now</span></h2>
                <p>Track the most traded digital assets in real-time with live price action.</p>
            </div>

            <div class="crypto-grid">
                @php
                    $coins = [
                        ['Bitcoin', 'BTC', '64,230.00', '+2.34%', 'up', '#F7931A'],
                        ['Ethereum', 'ETH', '3,420.50', '+1.85%', 'up', '#627EEA'],
                        ['Solana', 'SOL', '142.80', '+4.12%', 'up', '#14F195'],
                        ['XRP', 'XRP', '0.58', '-0.72%', 'down', '#346AA9'],
                        ['Cardano', 'ADA', '0.45', '+3.05%', 'up', '#0033AD'],
                        ['Litecoin', 'LTC', '78.40', '+1.10%', 'up', '#345D9D'],
                    ];
                @endphp

                @foreach($coins as $coin)
                    <div class="crypto-card reveal">
                        <div class="crypto-header">
                            <div class="crypto-icon" style="background: {{ $coin[4] === 'up' ? 'rgba(61,255,122,0.1)' : 'rgba(255,107,107,0.1)' }}">
                                <span style="color: {{ $coin[5] }}; font-weight: 700;">{{ substr($coin[0], 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="crypto-name">{{ $coin[0] }}</div>
                                <div class="crypto-symbol">{{ $coin[1] }}</div>
                            </div>
                        </div>
                        <div class="crypto-price">${{ $coin[2] }}</div>
                        <div class="crypto-change {{ $coin[4] }}">{{ $coin[4] === 'up' ? '+' : '' }}{{ $coin[3] }}</div>
                        <svg class="mini-chart" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <polyline
                                fill="none"
                                stroke="{{ $coin[4] === 'up' ? '#3DFF7A' : '#FF6B6B' }}"
                                stroke-width="2"
                                points="0,30 15,25 30,28 45,18 60,22 75,10 90,15 100,5"
                            />
                        </svg>
                        <a href="#" class="btn btn-primary">Buy Coin</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="exchange">
        <div class="container calc-grid">
            <div class="calc-info reveal">
                <h2>Bitcoin Currency <span class="neon">Calculator</span></h2>
                <p>Convert instantly between crypto and fiat currencies with accurate market rates. Plan your next move with precision.</p>
                <a href="#" class="btn btn-secondary">Learn More</a>
            </div>

            <div class="converter-card reveal">
                <div class="converter-row">
                    <div class="converter-field">
                        <label>Amount</label>
                        <input type="number" value="1.00">
                    </div>
                    <div class="converter-field">
                        <label>From</label>
                        <select>
                            <option>BTC</option>
                            <option>ETH</option>
                            <option>SOL</option>
                        </select>
                    </div>
                </div>
                <div class="converter-row">
                    <button class="swap-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#050B12" stroke-width="2.5">
                            <path d="M7 16V4M7 4L3 8M7 4l4 4"/>
                            <path d="M17 8v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                    </button>
                    <div class="converter-field">
                        <label>To</label>
                        <select>
                            <option>USD</option>
                            <option>EUR</option>
                            <option>CDF</option>
                        </select>
                    </div>
                </div>
                <div class="converter-result">
                    <div class="value">$64,230.00</div>
                    <div class="label">1 BTC ≈ 64,230.00 USD</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="services">
        <div class="container deposit-grid">
            <div class="deposit-info reveal">
                <h2>Deposit Crypto Earn <span class="neon">Interest</span></h2>
                <p>Put your digital assets to work. Earn competitive returns while keeping your funds secure and accessible.</p>
                <ul class="deposit-list">
                    <li>Secure Storage</li>
                    <li>Daily Rewards</li>
                    <li>Instant Withdrawals</li>
                    <li>High APY Returns</li>
                </ul>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>

            <div class="deposit-visual reveal">
                <svg viewBox="0 0 420 420" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="crystalGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#F3D28A"/>
                            <stop offset="50%" style="stop-color:#C8A24B"/>
                            <stop offset="100%" style="stop-color:#6B4E12"/>
                        </linearGradient>
                        <filter id="crystalGlow">
                            <feGaussianBlur stdDeviation="10" result="blur"/>
                            <feMerge>
                                <feMergeNode in="blur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <ellipse cx="210" cy="360" rx="130" ry="30" fill="rgba(0,0,0,0.4)" filter="url(#crystalGlow)"/>
                    <g filter="url(#crystalGlow)">
                        <polygon points="210,60 330,160 210,360 90,160" fill="url(#crystalGrad)" stroke="#F3D28A" stroke-width="2"/>
                        <polygon points="210,60 330,160 210,200 90,160" fill="rgba(255,255,255,0.2)"/>
                        <polygon points="90,160 210,200 210,360" fill="rgba(0,0,0,0.15)"/>
                        <polygon points="330,160 210,200 210,360" fill="rgba(0,0,0,0.25)"/>
                    </g>
                    <circle cx="150" cy="130" r="8" fill="#3DFF7A" filter="url(#crystalGlow)"/>
                    <circle cx="280" cy="180" r="5" fill="#3DFF7A" filter="url(#crystalGlow)"/>
                    <circle cx="200" cy="320" r="6" fill="#3DFF7A" filter="url(#crystalGlow)"/>
                </svg>
            </div>
        </div>
    </section>

    <section class="section" id="pricing">
        <div class="container">
            <div class="section-header reveal">
                <h2>Why Choose <span class="neon">CryptoSphere</span></h2>
                <p>A complete ecosystem built for security, speed and growth.</p>
            </div>

            <div class="features-grid">
                @php
                    $features = [
                        ['Value Performance', 'Real-time analytics and portfolio insights to maximize returns.'],
                        ['Strong Security', 'Bank-grade encryption, 2FA and cold storage for your assets.'],
                        ['Transparent Fees', 'No hidden costs. Every fee is clearly displayed before you trade.'],
                        ['Fast Transactions', 'Execute orders in milliseconds with low latency infrastructure.'],
                        ['Smart Analytics', 'Advanced charts, indicators and AI-powered market signals.'],
                        ['Global Access', 'Trade from anywhere with support for multiple currencies.'],
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="feature-card reveal">
                        <div class="feature-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h3>{{ $feature[0] }}</h3>
                        <p>{{ $feature[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="partners">
        <div class="partners-track">
            @foreach(['Visa', 'PayPal', 'Mastercard', 'Binance', 'Coinbase', 'Stripe', 'Visa', 'PayPal', 'Mastercard', 'Binance', 'Coinbase', 'Stripe'] as $logo)
                <div class="partner-logo">{{ $logo }}</div>
            @endforeach
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container">
            <div class="cta-section reveal">
                <h2>Install CryptoHub App <span class="neon">Today</span></h2>
                <p>Manage your portfolio, track markets and trade on the go with our next-generation mobile application.</p>
                <div class="cta-actions">
                    <a href="#" class="btn btn-primary">Google Play</a>
                    <a href="#" class="btn btn-secondary">App Store</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo">
                        <div class="logo-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L3 7L12 12L21 7L12 2Z" fill="#050B12"/>
                                <path d="M3 17L12 22L21 17" stroke="#050B12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 12L12 17L21 12" stroke="#050B12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        CryptoSphere
                    </a>
                    <p>The fastest way to follow crypto markets. Secure, modern and built for the future of finance.</p>
                </div>

                <div class="footer-links">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#">Exchange</a></li>
                        <li><a href="#">Wallet</a></li>
                        <li><a href="#">Earn</a></li>
                        <li><a href="#">NFT</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">API Docs</a></li>
                        <li><a href="#">Status</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>

                <div class="newsletter">
                    <h4>Subscribe to our newsletter</h4>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Merci pour votre inscription !');">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">Send</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                © 2026 CryptoSphere. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Particules
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
                this.opacity = Math.random() * 0.4 + 0.1;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x < 0) this.x = canvas.width;
                if (this.x > canvas.width) this.x = 0;
                if (this.y < 0) this.y = canvas.height;
                if (this.y > canvas.height) this.y = 0;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(61, 255, 122, ${this.opacity})`;
                ctx.fill();
            }
        }

        function initParticles() {
            particles = [];
            const count = Math.min(window.innerWidth / 10, 120);
            for (let i = 0; i < count; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animateParticles);
        }

        resize();
        initParticles();
        animateParticles();
        window.addEventListener('resize', () => { resize(); initParticles(); });

        // Mobile menu
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>

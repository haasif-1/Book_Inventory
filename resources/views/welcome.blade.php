@extends('backend.layout.app')
@section('title', 'Welcome')

@section('main-content')

<style>
    .hero-container {
        background: linear-gradient(135deg, #111827, #1f2937, #0f172a);
        color: #fff;
        padding: 60px 20px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 0 30px rgba(0,0,0,0.25);
    }

    .hero-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 20px;
        background: linear-gradient(90deg, #38bdf8, #818cf8, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-sub {
        font-size: 18px;
        max-width: 750px;
        margin: 0 auto 35px;
        line-height: 1.6;
        color: #d1d5db;
    }

    .features {
        margin-top: 50px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
    }

    .feature-box {
        background: #1f2937;
        padding: 25px;
        width: 270px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #2d3748;
        transition: 0.3s ease;
    }

    .feature-box:hover {
        transform: translateY(-6px);
        border-color: #6366f1;
    }

    .feature-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #60a5fa;
    }

    .feature-desc {
        font-size: 14px;
        color: #d1d5db;
        line-height: 1.5;
    }

    .start-btn {
        margin-top: 40px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        padding: 12px 28px;
        border-radius: 8px;
        color: white;
        font-size: 17px;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .start-btn:hover {
        opacity: 0.8;
    }
</style>

<div class="container mt-5">

    <div class="hero-container">

        <h1 class="hero-title">AI Prompt Generator Dashboard</h1>

        <p class="hero-sub">
            Welcome to your AI Prompt Creation System — a modern platform designed to help users
            create powerful, optimized, and creative prompts for generating stunning AI images.
            Manage prompts, organize styles, and build perfect instructions for any AI model.
        </p>

        {{-- <a href="#" class="start-btn">Get Started</a> --}}

        <div class="features">
            <div class="feature-box">
                <div class="feature-title">Prompt Library</div>
                <div class="feature-desc">
                    Save, organize, and reuse top-performing prompts for fast image generation.
                </div>
            </div>

            <div class="feature-box">
                <div class="feature-title">Smart Suggestions</div>
                <div class="feature-desc">
                    Automatically refine ideas into optimized prompts with AI assistance.
                </div>
            </div>

            <div class="feature-box">
                <div class="feature-title">Multiple Styles</div>
                <div class="feature-desc">
                    Choose from various categories: realism, anime, digital art, futuristic, and more.
                </div>
            </div>

            <div class="feature-box">
                <div class="feature-title">Fast & Clean UI</div>
                <div class="feature-desc">
                    Built with Laravel + React for a smooth and high-performance experience.
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

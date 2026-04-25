@extends('layouts.app')

@section('content')

<style>
    body { background: #f8fafc; }

    .analyze-hero {
        text-align: center;
        margin-bottom: 2.5rem;
        padding-top: 2rem;
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #3b82f6;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 999px;
        margin-bottom: 1.25rem;
        letter-spacing: 0.03em;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        background: #3b82f6;
        border-radius: 50%;
    }

    .hero-title {
        font-size: 2.6rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.03em;
        margin-bottom: 0.75rem;
    }

    .hero-sub {
        color: #64748b;
        font-size: 0.875rem;
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .input-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem;
        max-width: 720px;
        margin: 0 auto 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
    }

    .input-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: #3b82f6;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.75rem;
    }

    .text-area {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        color: #0f172a;
        font-size: 0.875rem;
        resize: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }

    .text-area:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        background: #fff;
    }

    .text-area::placeholder { color: #94a3b8; }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .supports-text {
        font-size: 0.72rem;
        color: #94a3b8;
    }

    .btn-analyze {
        background: #2563eb;
        color: #fff;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 10px 28px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .btn-analyze:hover { background: #1d4ed8; transform: translateY(-1px); }
    .btn-analyze:active { transform: translateY(0); }

    /* ── Result Cards ── */
    .result-wrap { max-width: 720px; margin: 0 auto; }

    .result-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .section-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #3b82f6;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
    }

    .status-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .status-left { display: flex; align-items: center; gap: 1rem; }

    .status-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .status-icon-safe     { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
    .status-icon-warn     { background: #fffbeb; border: 1px solid #fde68a; color: #d97706; }
    .status-icon-toxic    { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    .detected-label-sub { font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 3px; }
    .detected-label-val { font-size: 1.2rem; font-weight: 700; color: #0f172a; }

    .status-right { display: flex; align-items: center; gap: 1.25rem; }

    .confidence-block { text-align: right; }
    .confidence-sub { font-size: 0.7rem; color: #94a3b8; margin-bottom: 2px; }
    .confidence-val { font-size: 1.6rem; font-weight: 800; color: #2563eb; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 999px;
    }

    .badge-safe    { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
    .badge-warn    { background: #fffbeb; border: 1px solid #fde68a; color: #d97706; }
    .badge-toxic   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    .badge-pulse {
        width: 7px; height: 7px;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    .pulse-safe  { background: #16a34a; }
    .pulse-warn  { background: #d97706; }
    .pulse-toxic { background: #dc2626; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* Probability bars */
    .prob-row { margin-bottom: 1rem; }
    .prob-row:last-child { margin-bottom: 0; }

    .prob-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .prob-name {
        font-size: 0.8rem;
        color: #475569;
    }

    .prob-name-top {
        font-size: 0.8rem;
        color: #2563eb;
        font-weight: 600;
    }

    .prob-pct { font-size: 0.78rem; font-family: monospace; color: #64748b; }
    .prob-pct-top { font-size: 0.78rem; font-family: monospace; color: #2563eb; font-weight: 700; }

    .prob-track {
        width: 100%;
        background: #f1f5f9;
        border-radius: 999px;
        height: 7px;
    }

    .prob-fill {
        height: 7px;
        border-radius: 999px;
        transition: width 0.6s ease;
        background: #cbd5e1;
    }

    .prob-fill-top { background: #2563eb; }

    /* Analyzed text box */
    .analyzed-text-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 0.875rem;
        color: #334155;
        line-height: 1.7;
    }

    /* Alert boxes */
    .alert-box {
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .alert-safe  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .alert-toxic { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* Info cards */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        max-width: 720px;
        margin: 2.5rem auto 0;
    }

    .info-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .info-card-icon {
        width: 36px;
        height: 36px;
        background: #eff6ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
    }

    .info-card-icon svg { width: 18px; height: 18px; color: #3b82f6; stroke: #3b82f6; }
    .info-card-title { font-size: 0.8rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
    .info-card-desc  { font-size: 0.72rem; color: #64748b; line-height: 1.5; }

    .error-text { color: #ef4444; font-size: 0.75rem; margin-top: 6px; }
</style>

{{-- Hero --}}
<div class="analyze-hero">
    <div class="badge-pill">
        <span class="badge-dot"></span>
        Powered by mBERT Multilingual
    </div>
    <h1 class="hero-title">Detect Cyberbullying</h1>
    <p class="hero-sub">
        Analyze text in English, Nepali (Romanized &amp; Devanagari), or mixed language.
        Powered by DistilBERT-multilingual with 86.1% accuracy across 6 categories.
    </p>
</div>

{{-- Input Card --}}
<div class="input-card">
    <form method="POST" action="/analyze">
        @csrf
        <label class="input-label">Enter text to analyze</label>
        <textarea
            name="text"
            rows="5"
            class="text-area"
            placeholder="Type or paste text here... (English, Nepali, Romanized)"
        >{{ old('text') }}</textarea>

        @error('text')
            <p class="error-text">{{ $message }}</p>
        @enderror

        <div class="form-footer">
            <span class="supports-text">Supports: English &middot; नेपाली &middot; Romanized Nepali &middot; Mixed</span>
            <button type="submit" class="btn-analyze">Analyze &rarr;</button>
        </div>
    </form>
</div>

{{-- Result --}}
@if(session('result'))
    @php
        $result   = session('result');
        $status   = session('status');
        // Cast string keys to int (Flask returns JSON keys as strings)
        $rawProbs = $result['all_probs'] ?? [];
        $allProbs = [];
        foreach ($rawProbs as $k => $v) {
            $allProbs[(int)$k] = (float)$v;
        }

        // Auto-detect: if any value > 1, probs are already in % form (0-100), not decimals
        $probsArePercent = count($allProbs) > 0 && max($allProbs) > 1;

        $labelNames = [
            0 => 'Not Cyberbullying',
            1 => 'Gender',
            2 => 'Religion',
            3 => 'Other Cyberbullying',
            4 => 'Age',
            5 => 'Ethnicity',
        ];

        $iconClass = match($status) {
            'Safe'       => 'status-icon-safe',
            'Toxic'      => 'status-icon-toxic',
            default      => 'status-icon-warn',
        };
        $badgeClass = match($status) {
            'Safe'       => 'badge-safe',
            'Toxic'      => 'badge-toxic',
            default      => 'badge-warn',
        };
        $pulseClass = match($status) {
            'Safe'       => 'pulse-safe',
            'Toxic'      => 'pulse-toxic',
            default      => 'pulse-warn',
        };
        $iconLetter = match($status) {
            'Safe'       => 'S',
            'Toxic'      => 'T',
            default      => '!',
        };

        arsort($allProbs);
    @endphp

    <div class="result-wrap">

        {{-- Status Banner --}}
        <div class="result-card">
            <div class="status-banner">
                <div class="status-left">
                    <div class="status-icon {{ $iconClass }}">{{ $iconLetter }}</div>
                    <div>
                        <p class="detected-label-sub">Detected Category</p>
                        <p class="detected-label-val">{{ $result['label'] }}</p>
                    </div>
                </div>
                <div class="status-right">
                    <div class="confidence-block">
                        <p class="confidence-sub">Confidence</p>
                        <p class="confidence-val">{{ number_format($result['confidence'], 1) }}%</p>
                    </div>
                    <div class="status-badge {{ $badgeClass }}">
                        <span class="badge-pulse {{ $pulseClass }}"></span>
                        {{ $status }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Probability Bars --}}
        @if(count($allProbs) > 0)
        <div class="result-card">
            <p class="section-label">Class Probabilities</p>
            @foreach($allProbs as $labelId => $prob)
                @php
                    $pct   = $probsArePercent ? round($prob, 1) : round($prob * 100, 1);
                    $pct   = min($pct, 100); // clamp to 100 max
                    $isTop = $labelId == $result['label_id'];
                @endphp
                <div class="prob-row">
                    <div class="prob-header">
                        <span class="{{ $isTop ? 'prob-name-top' : 'prob-name' }}">
                            {{ $labelNames[$labelId] ?? 'Unknown' }}
                            @if($isTop) &larr; predicted @endif
                        </span>
                        <span class="{{ $isTop ? 'prob-pct-top' : 'prob-pct' }}">{{ $pct }}%</span>
                    </div>
                    <div class="prob-track">
                        <div class="prob-fill {{ $isTop ? 'prob-fill-top' : '' }}" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        {{-- Analyzed Text --}}
        <div class="result-card">
            <p class="section-label">Analyzed Text</p>
            <div class="analyzed-text-box">{{ old('text') }}</div>
        </div>



    </div>
@endif

{{-- Info Cards --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-card-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253" />
            </svg>
        </div>
        <p class="info-card-title">Multilingual</p>
        <p class="info-card-desc">Detects in English, Nepali, Romanized &amp; mixed scripts</p>
    </div>
    <div class="info-card">
        <div class="info-card-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg>
        </div>
        <p class="info-card-title">6 Categories</p>
        <p class="info-card-desc">Gender, Religion, Age, Ethnicity, Other &amp; Not Cyberbullying</p>
    </div>
    <div class="info-card">
        <div class="info-card-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
        </div>
        <p class="info-card-title">86.1% Accuracy</p>
        <p class="info-card-desc">Macro F1 of 0.861 on balanced multilingual dataset</p>
    </div>
</div>

@endsection
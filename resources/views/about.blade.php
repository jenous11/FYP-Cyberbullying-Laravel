@extends('layouts.app')

@section('title', 'About — CyberGuard')

@section('content')

<style>
    body { background: #f8fafc; }

    .about-header { margin-bottom: 2rem; }
    .about-header h1 { font-size: 1.75rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
    .about-header p  { color: #64748b; font-size: 0.875rem; margin-top: 4px; }

    .about-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.75rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #2563eb;
        margin-bottom: 1rem;
    }

    .body-text {
        font-size: 0.875rem;
        color: #475569;
        line-height: 1.75;
    }

    .body-text strong { color: #0f172a; font-weight: 600; }

    /* How it works */
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }

    .step-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
    }

    .step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 7px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 0.75rem;
    }

    .step-title { font-size: 0.82rem; font-weight: 700; color: #0f172a; margin-bottom: 5px; }
    .step-desc  { font-size: 0.78rem; color: #64748b; line-height: 1.6; }

    /* Model details */
    .model-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 768px) { .model-grid { grid-template-columns: 1fr; } }

    .spec-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.8rem;
    }

    .spec-row:last-child { border-bottom: none; }
    .spec-key { color: #94a3b8; }
    .spec-val { color: #0f172a; font-weight: 600; }

    .labels-heading {
        font-size: 0.67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        margin-bottom: 0.75rem;
    }

    .label-row {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        padding: 8px 12px;
        margin-bottom: 6px;
    }

    .label-row:last-child { margin-bottom: 0; }

    .label-num {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .label-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .label-name { font-size: 0.8rem; font-weight: 600; }

    /* Tech Stack */
    .stack-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    @media (max-width: 768px) { .stack-grid { grid-template-columns: repeat(2, 1fr); } }

    .stack-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
    }

    .stack-name { font-size: 0.82rem; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
    .stack-role { font-size: 0.72rem; color: #94a3b8; }

    .footnote { font-size: 0.72rem; color: #cbd5e1; margin-top: 1.5rem; }
</style>

<div class="about-header">
    <h1>About CyberGuard</h1>
    <p>An AI-powered cyberbullying detection system built as a Final Year Project.</p>
</div>

{{-- What is CyberGuard --}}
<div class="about-card">
    <p class="section-title">What is CyberGuard?</p>
    <p class="body-text">
        CyberGuard is a web-based cyberbullying detection application that uses a fine-tuned
        <strong>DistilBERT</strong> deep learning model to classify text into six categories.
        It is designed to help identify harmful online content in real time, supporting
        safer digital spaces for users.
    </p>
</div>

{{-- How it works --}}
<div class="about-card">
    <p class="section-title">How It Works</p>
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-num">1</div>
            <p class="step-title">Input Text</p>
            <p class="step-desc">The user submits any text — a comment, message, or post — through the Analyze page.</p>
        </div>
        <div class="step-card">
            <div class="step-num">2</div>
            <p class="step-title">AI Classification</p>
            <p class="step-desc">The text is sent to a Flask REST API which runs it through the fine-tuned DistilBERT model and returns prediction probabilities for all 6 classes.</p>
        </div>
        <div class="step-card">
            <div class="step-num">3</div>
            <p class="step-title">Results Displayed</p>
            <p class="step-desc">The Laravel frontend displays the predicted category, confidence score, and probability bars for each class. All results are saved to the database.</p>
        </div>
    </div>
</div>

{{-- Model Details --}}
<div class="about-card">
    <p class="section-title">Model Details</p>
    <div class="model-grid">

        <div>
            @php
                $specs = [
                    ['label' => 'Base Model',     'value' => 'distilbert-base-multilingual-cased'],
                    ['label' => 'Task',           'value' => '6-Class Text Classification'],
                    ['label' => 'Dataset Size',   'value' => '~29,910 rows'],
                    ['label' => 'Optimizer',      'value' => 'AdamW'],
                    ['label' => 'Learning Rate',  'value' => '2e-5'],
                    ['label' => 'Epochs',         'value' => '4'],
                    ['label' => 'Test Accuracy',  'value' => '~86.5%'],
                    ['label' => 'Macro F1 Score', 'value' => '~0.861'],
                ];
            @endphp
            @foreach($specs as $spec)
                <div class="spec-row">
                    <span class="spec-key">{{ $spec['label'] }}</span>
                    <span class="spec-val">{{ $spec['value'] }}</span>
                </div>
            @endforeach
        </div>

        <div>
            <p class="labels-heading">Classification Labels</p>
            @php
                $labels = [
                    ['id' => 0, 'name' => 'Not Cyberbullying',  'dot' => '#22c55e', 'text' => '#16a34a'],
                    ['id' => 1, 'name' => 'Gender',             'dot' => '#ec4899', 'text' => '#db2777'],
                    ['id' => 2, 'name' => 'Religion',           'dot' => '#eab308', 'text' => '#ca8a04'],
                    ['id' => 3, 'name' => 'Other Cyberbullying','dot' => '#ef4444', 'text' => '#dc2626'],
                    ['id' => 4, 'name' => 'Age',                'dot' => '#a855f7', 'text' => '#7c3aed'],
                    ['id' => 5, 'name' => 'Ethnicity',          'dot' => '#f97316', 'text' => '#ea580c'],
                ];
            @endphp
            @foreach($labels as $label)
                <div class="label-row">
                    <span class="label-num">{{ $label['id'] }}</span>
                    <span class="label-dot" style="background: {{ $label['dot'] }};"></span>
                    <span class="label-name" style="color: {{ $label['text'] }};">{{ $label['name'] }}</span>
                </div>
            @endforeach
        </div>

    </div>
</div>

{{-- Tech Stack --}}
<div class="about-card">
    <p class="section-title">Tech Stack</p>
    <div class="stack-grid">
        @php
            $stack = [
                ['name' => 'Laravel',       'role' => 'Frontend & Backend'],
                ['name' => 'Tailwind CSS',  'role' => 'Styling'],
                ['name' => 'Flask',         'role' => 'ML REST API'],
                ['name' => 'DistilBERT',    'role' => 'NLP Model'],
                ['name' => 'PyTorch',       'role' => 'Model Training'],
                ['name' => 'MySQL',         'role' => 'Database'],
                ['name' => 'Hugging Face',  'role' => 'Transformers Library'],
                ['name' => 'Chart.js',      'role' => 'Data Visualization'],
            ];
        @endphp
        @foreach($stack as $tech)
            <div class="stack-card">
                <p class="stack-name">{{ $tech['name'] }}</p>
                <p class="stack-role">{{ $tech['role'] }}</p>
            </div>
        @endforeach
    </div>
</div>

<p class="footnote">
    CSIT 7th Semester &mdash; Asian College of Higher Studies (ACHS), Nepal &middot; Tribhuvan University &middot; 2025/2026
</p>

@endsection
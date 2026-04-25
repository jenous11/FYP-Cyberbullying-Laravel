@extends('layouts.app')

@section('title', 'Dashboard — CyberGuard')

@section('content')

<style>
    body { background: #f8fafc; }

    .dash-header { margin-bottom: 2rem; }
    .dash-header h1 { font-size: 1.75rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
    .dash-header p  { color: #64748b; font-size: 0.875rem; margin-top: 4px; }

    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        margin-bottom: 6px;
    }

    .stat-value { font-size: 2rem; font-weight: 800; letter-spacing: -0.02em; }
    .stat-sub   { font-size: 0.72rem; color: #94a3b8; margin-top: 4px; }

    .stat-default .stat-label { color: #64748b; }
    .stat-default .stat-value { color: #0f172a; }

    .stat-red .stat-label  { color: #ef4444; }
    .stat-red .stat-value  { color: #ef4444; }
    .stat-red  { border-color: #fecaca; }

    .stat-green .stat-label { color: #16a34a; }
    .stat-green .stat-value { color: #16a34a; }
    .stat-green { border-color: #bbf7d0; }

    .stat-blue .stat-label  { color: #2563eb; }
    .stat-blue .stat-value  { color: #2563eb; }
    .stat-blue  { border-color: #bfdbfe; }

    /* Charts */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    @media (max-width: 768px) { .charts-grid { grid-template-columns: 1fr; } }

    .chart-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .chart-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #64748b;
        margin-bottom: 1rem;
    }

    /* Category Cards */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }

    @media (max-width: 1024px) { .category-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 640px)  { .category-grid { grid-template-columns: repeat(2, 1fr); } }

    .cat-card {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .cat-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; line-height: 1.3; }
    .cat-count { font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }

    .cat-track { width: 100%; background: #f1f5f9; border-radius: 999px; height: 5px; }
    .cat-fill  { height: 5px; border-radius: 999px; transition: width 0.6s ease; }

    .cat-pct { font-size: 0.7rem; color: #94a3b8; }

    /* Recent Table */
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .table-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #64748b;
    }

    .view-all {
        font-size: 0.75rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }

    .view-all:hover { text-decoration: underline; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }

    .data-table thead tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .data-table th {
        text-align: left;
        font-size: 0.67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        padding: 0 1rem 0.75rem 0;
    }

    .data-table td {
        padding: 0.75rem 1rem 0.75rem 0;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: #f8fafc; }

    .conf-track { width: 56px; background: #f1f5f9; border-radius: 999px; height: 5px; display: inline-block; vertical-align: middle; }
    .conf-fill  { height: 5px; border-radius: 999px; background: #2563eb; }

    .empty-state { text-align: center; padding: 3rem 0; color: #94a3b8; font-size: 0.875rem; }
    .empty-state a { color: #2563eb; }
</style>

<div class="dash-header">
    <h1>Dashboard</h1>
    <p>Overview of all cyberbullying detections on this system.</p>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card stat-default">
        <p class="stat-label">Total Analyzed</p>
        <p class="stat-value">{{ $total }}</p>
    </div>
    <div class="stat-card stat-red">
        <p class="stat-label">Cyberbullying</p>
        <p class="stat-value">{{ $bullying }}</p>
        <p class="stat-sub">{{ $total > 0 ? round(($bullying / $total) * 100, 1) : 0 }}% of total</p>
    </div>
    <div class="stat-card stat-green">
        <p class="stat-label">Safe</p>
        <p class="stat-value">{{ $safe }}</p>
        <p class="stat-sub">{{ $total > 0 ? round(($safe / $total) * 100, 1) : 0 }}% of total</p>
    </div>
    <div class="stat-card stat-blue">
        <p class="stat-label">Avg Confidence</p>
        <p class="stat-value">{{ round($avgConfidence, 1) }}%</p>
    </div>
</div>

{{-- Charts --}}
<div class="charts-grid">
    <div class="chart-card">
        <p class="chart-title">Safe vs Cyberbullying</p>
        <div style="height:210px; display:flex; align-items:center; justify-content:center;">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <p class="chart-title">Category Breakdown</p>
        <div style="height:210px;">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

{{-- Category Cards --}}
@php
    $labelNames = [
        0 => 'Not Cyberbullying',
        1 => 'Gender',
        2 => 'Religion',
        3 => 'Other Cyberbullying',
        4 => 'Age',
        5 => 'Ethnicity',
    ];
    $catStyles = [
        0 => ['label' => '#16a34a', 'fill' => '#22c55e', 'border' => '#bbf7d0'],
        1 => ['label' => '#db2777', 'fill' => '#ec4899', 'border' => '#fbcfe8'],
        2 => ['label' => '#ca8a04', 'fill' => '#eab308', 'border' => '#fde68a'],
        3 => ['label' => '#dc2626', 'fill' => '#ef4444', 'border' => '#fecaca'],
        4 => ['label' => '#7c3aed', 'fill' => '#a855f7', 'border' => '#e9d5ff'],
        5 => ['label' => '#ea580c', 'fill' => '#f97316', 'border' => '#fed7aa'],
    ];
@endphp

<div class="category-grid">
    @for ($i = 0; $i < 6; $i++)
        @php
            $s     = $catStyles[$i];
            $count = $labelCounts[$i] ?? 0;
            $pct   = $total > 0 ? round(($count / $total) * 100, 1) : 0;
        @endphp
        <div class="cat-card" style="border: 1px solid {{ $s['border'] }};">
            <p class="cat-label" style="color: {{ $s['label'] }};">{{ $labelNames[$i] }}</p>
            <p class="cat-count">{{ $count }}</p>
            <div class="cat-track">
                <div class="cat-fill" style="width: {{ $pct }}%; background: {{ $s['fill'] }};"></div>
            </div>
            <p class="cat-pct">{{ $pct }}%</p>
        </div>
    @endfor
</div>

{{-- Recent Analyses --}}
<div class="table-card">
    <div class="table-header">
        <p class="table-title">Recent Analyses</p>
        <a href="{{ route('history') }}" class="view-all">View all &rarr;</a>
    </div>

    @if($recentAnalyses->isEmpty())
        <div class="empty-state">
            No analyses yet. <a href="{{ route('analyze') }}">Run your first one &rarr;</a>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Text</th>
                        <th>Label</th>
                        <th>Confidence</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentAnalyses as $item)
                        @php
                            $s = $catStyles[$item->label_id] ?? ['label' => '#64748b'];
                        @endphp
                        <tr>
                            <td style="max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ Str::limit($item->text, 60) }}
                            </td>
                            <td>
                                <span style="font-size: 0.75rem; font-weight: 600; color: {{ $s['label'] }};">
                                    {{ $labelNames[$item->label_id] ?? 'Unknown' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div class="conf-track">
                                        <div class="conf-fill" style="width: {{ $item->confidence }}%;"></div>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #64748b; font-family: monospace;">
                                        {{ round($item->confidence, 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td style="white-space: nowrap; color: #94a3b8; font-size: 0.75rem;">
                                {{ $item->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labelNames  = @json(array_values($labelNames));
    const labelCounts = @json(array_values($labelCounts));
    const total    = {{ $total }};
    const bullying = {{ $bullying }};
    const safe     = {{ $safe }};

    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Safe', 'Cyberbullying'],
            datasets: [{
                data: [safe, bullying],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 3,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    labels: { color: '#64748b', font: { size: 12 }, padding: 16 }
                }
            }
        }
    });

    const barColors = ['#22c55e','#ec4899','#eab308','#ef4444','#a855f7','#f97316'];
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labelNames,
            datasets: [{
                label: 'Count',
                data: labelCounts,
                backgroundColor: barColors.map(c => c + '33'),
                borderColor: barColors,
                borderWidth: 1.5,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { color: '#94a3b8', font: { size: 10 } },
                    grid: { color: '#f1f5f9' }
                },
                y: {
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    grid: { color: '#f1f5f9' },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
@extends('layouts.app')

@section('title', 'History — CyberGuard')

@section('content')

<style>
    body { background: #f8fafc; }

    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .history-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .history-header p {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 4px;
    }

    .export-btn {
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
        border: 1px solid #e2e8f0;
        background: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s;
    }

    .export-btn:hover { border-color: #2563eb; color: #2563eb; }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        font-size: 0.8rem;
        padding: 10px 16px;
        border-radius: 10px;
        margin-bottom: 1.25rem;
    }

    .empty-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 4rem;
        text-align: center;
        color: #94a3b8;
        font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .empty-card a { color: #2563eb; text-decoration: none; }
    .empty-card a:hover { text-decoration: underline; }

    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
    }

    .data-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .data-table th {
        text-align: left;
        font-size: 0.67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        padding: 0.875rem 1rem;
    }

    .data-table td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }

    .data-table tbody tr:hover td { background: #f8fafc; }

    .id-cell { color: #94a3b8; font-family: monospace; font-size: 0.72rem; }

    .text-cell {
        max-width: 240px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-size: 0.78rem;
        color: #475569;
        line-height: 1.5;
    }

    .cat-label { font-size: 0.75rem; font-weight: 600; }

    .conf-wrap { display: flex; align-items: center; gap: 8px; }
    .conf-track { width: 52px; background: #f1f5f9; border-radius: 999px; height: 5px; }
    .conf-fill  { height: 5px; border-radius: 999px; background: #2563eb; }
    .conf-val   { font-size: 0.72rem; font-family: monospace; color: #64748b; }

    .top-probs { display: flex; flex-direction: column; gap: 3px; }
    .prob-row-mini { display: flex; align-items: center; gap: 6px; }
    .prob-name-mini { font-size: 0.68rem; color: #94a3b8; width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .prob-val-mini  { font-size: 0.68rem; font-family: monospace; color: #64748b; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid;
        white-space: nowrap;
    }

    .badge-safe    { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    .badge-warn    { background: #fffbeb; border-color: #fde68a; color: #d97706; }
    .badge-toxic   { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }

    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .dot-safe  { background: #16a34a; }
    .dot-warn  { background: #d97706; }
    .dot-toxic { background: #dc2626; }

    .date-cell { font-size: 0.72rem; color: #64748b; white-space: nowrap; line-height: 1.6; }

    .delete-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.75rem;
        padding: 4px 6px;
        border-radius: 4px;
        transition: color 0.15s, background 0.15s;
        opacity: 0;
    }

    tr:hover .delete-btn { opacity: 1; }
    .delete-btn:hover { color: #ef4444; background: #fef2f2; }

    .pagination-wrap {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }
</style>

{{-- Header --}}
<div class="history-header">
    <div>
        <h1>Analysis History</h1>
        <p>All previously analyzed texts &middot; {{ $analyses->total() }} total records</p>
    </div>
    <a href="/export" class="export-btn">&darr; Export CSV</a>
</div>

{{-- Success Flash --}}
@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if($analyses->count() === 0)
    <div class="empty-card">
        <p style="margin-bottom: 8px; font-size: 0.95rem; font-weight: 600; color: #475569;">No analyses yet</p>
        <p>Go to <a href="{{ route('analyze') }}">Analyze</a> to get started.</p>
    </div>
@else

@php
    $labelNames = [
        0 => 'Not Cyberbullying',
        1 => 'Gender',
        2 => 'Religion',
        3 => 'Other Cyberbullying',
        4 => 'Age',
        5 => 'Ethnicity',
    ];
    $catColors = [
        0 => '#16a34a',
        1 => '#db2777',
        2 => '#ca8a04',
        3 => '#dc2626',
        4 => '#7c3aed',
        5 => '#ea580c',
    ];
@endphp

<div class="table-card">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Text</th>
                    <th>Category</th>
                    <th>Confidence</th>
                    <th>Top Probabilities</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($analyses as $a)
                @php
                    $probs    = $a->all_probs ? json_decode($a->all_probs, true) : [];
                    arsort($probs);
                    $topProbs = array_slice($probs, 0, 3, true);

                    $badgeClass = match($a->status) {
                        'Safe'  => 'badge-safe',
                        'Toxic' => 'badge-toxic',
                        default => 'badge-warn',
                    };
                    $dotClass = match($a->status) {
                        'Safe'  => 'dot-safe',
                        'Toxic' => 'dot-toxic',
                        default => 'dot-warn',
                    };
                    $labelColor = $catColors[$a->label_id] ?? '#64748b';
                @endphp
                <tr>
                    <td class="id-cell">{{ $a->id }}</td>

                    <td><div class="text-cell">{{ $a->input_text }}</div></td>

                    <td>
                        <span class="cat-label" style="color: {{ $labelColor }};">
                            {{ $a->label }}
                        </span>
                    </td>

                    <td>
                        <div class="conf-wrap">
                            <div class="conf-track">
                                <div class="conf-fill" style="width: {{ $a->confidence }}%;"></div>
                            </div>
                            <span class="conf-val">{{ number_format($a->confidence, 1) }}%</span>
                        </div>
                    </td>

                    <td>
                        @if(count($topProbs) > 0)
                            <div class="top-probs">
                                @foreach($topProbs as $lid => $prob)
                                    <div class="prob-row-mini">
                                        <span class="prob-name-mini">{{ $labelNames[$lid] ?? '?' }}</span>
                                        <span class="prob-val-mini">{{ round($prob * 100, 1) }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span style="color: #cbd5e1;">—</span>
                        @endif
                    </td>

                    <td>
                        <span class="status-badge {{ $badgeClass }}">
                            <span class="badge-dot {{ $dotClass }}"></span>
                            {{ $a->status }}
                        </span>
                    </td>

                    <td class="date-cell">
                        {{ $a->created_at->format('M d, Y') }}<br>
                        <span style="color: #cbd5e1;">{{ $a->created_at->format('H:i') }}</span>
                    </td>

                    <td>
                        <form method="POST" action="/history/{{ $a->id }}" onsubmit="return confirm('Delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">&times;</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($analyses->hasPages())
    <div class="pagination-wrap">
        {{ $analyses->links() }}
    </div>
@endif

@endif

@endsection
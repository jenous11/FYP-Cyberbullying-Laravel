<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Analysis;

class AnalysisController extends Controller
{
    public function index()
    {
        return view('analyze');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:3'
        ]);

        // Call Flask API
        $response = Http::timeout(30)->post('http://127.0.0.1:5000/predict', [
            'text' => $request->input('text')
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', 'Model server is unavailable. Please try again.');
        }

        $result = $response->json();

        // Fixed status logic — all specific bullying types are Toxic
        if ($result['label'] === 'Not Cyberbullying') {
            $status = 'Safe';
        } elseif ($result['confidence'] < 60) {
            $status = 'Suspicious';
        } else {
            $status = 'Toxic';
        }

        // Save to database (all_probs as JSON)
        Analysis::create([
            'input_text' => $request->input('text'),
            'label'      => $result['label'],
            'label_id'   => $result['label_id'],
            'confidence' => $result['confidence'],
            'status'     => $status,
            'all_probs'  => json_encode($result['all_probs'] ?? []),
        ]);

        return back()
            ->withInput()
            ->with('result', $result)
            ->with('status', $status);
    }

    public function history()
    {
        $analyses = Analysis::latest()->paginate(15);

        // Decode all_probs JSON for each record
        foreach ($analyses as $a) {
            $a->all_probs_decoded = $a->all_probs ? json_decode($a->all_probs, true) : [];
        }

        return view('history', compact('analyses'));
    }

    public function dashboard()
{
    $total    = Analysis::count();
    $bullying = Analysis::where('label_id', '!=', 0)->count();
    $safe     = Analysis::where('label_id', 0)->count();

    $labelCounts = [];
    for ($i = 0; $i < 6; $i++) {
        $labelCounts[$i] = Analysis::where('label_id', $i)->count();
    }

    $avgConfidence  = Analysis::avg('confidence') ?? 0;
    $recentAnalyses = Analysis::latest()->take(8)->get();

    return view('dashboard', compact(
        'total', 'bullying', 'safe',
        'labelCounts', 'avgConfidence', 'recentAnalyses'
    ));
}

    public function about()
    {
        return view('about');
    }

    public function destroy($id)
    {
        Analysis::findOrFail($id)->delete();
        return back()->with('success', 'Record deleted successfully!');
    }

    /**
     * Export analysis history as CSV
     */
    public function export()
    {
        $analyses = Analysis::latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="cyberguard_history.csv"',
        ];

        $callback = function() use ($analyses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Text', 'Label', 'Confidence', 'Status', 'Date']);

            foreach ($analyses as $a) {
                fputcsv($file, [
                    $a->id,
                    $a->input_text,
                    $a->label,
                    $a->confidence . '%',
                    $a->status,
                    $a->created_at->format('M d, Y H:i')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
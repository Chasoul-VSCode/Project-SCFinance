<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finances = Finance::where('id_users', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('pages.kelola', compact('finances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_tabungan' => 'nullable|numeric|min:0',
            'pengeluaran' => 'nullable|numeric|min:0',
            'penghasilan' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:1000',
        ]);

        $finance = new Finance();
        $finance->id_users = Auth::id();
        $finance->total_tabungan = $validated['total_tabungan'] ?? 0;
        $finance->pengeluaran = $validated['pengeluaran'] ?? 0;
        $finance->penghasilan = $validated['penghasilan'] ?? 0;
        $finance->note = $validated['note'];
        $finance->save();

        return redirect()->route('finances.index')
            ->with('success', 'Catatan keuangan berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        // Memastikan user hanya bisa mengupdate data miliknya
        if ($finance->id_users !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'total_tabungan' => 'nullable|numeric|min:0',
            'pengeluaran' => 'nullable|numeric|min:0',
            'penghasilan' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:1000',
        ]);

        $finance->update([
            'total_tabungan' => $validated['total_tabungan'] ?? $finance->total_tabungan,
            'pengeluaran' => $validated['pengeluaran'] ?? $finance->pengeluaran,
            'penghasilan' => $validated['penghasilan'] ?? $finance->penghasilan,
            'note' => $validated['note']
        ]);

        return redirect()->route('finances.index')
            ->with('success', 'Catatan keuangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        // Memastikan user hanya bisa menghapus data miliknya
        if ($finance->id_users !== Auth::id()) {
            abort(403);
        }

        $finance->delete();

        return redirect()->route('finances.index')
            ->with('success', 'Catatan keuangan berhasil dihapus!');
    }
}
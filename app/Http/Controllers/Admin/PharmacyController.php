<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('category', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $medicines = $query->orderBy('name')->paginate(15);
        return view('admin.pharmacy.index', compact('medicines'));
    }

    public function create() { return view('admin.pharmacy.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'status' => 'nullable|in:available,out_of_stock,expired',
        ]);
        Medicine::create($data);
        return redirect()->route('admin.pharmacy.index')->with('success', 'Medicine added.');
    }

    public function show(Medicine $pharmacy)
    {
        return view('admin.pharmacy.show', ['medicine' => $pharmacy]);
    }

    public function edit(Medicine $pharmacy)
    {
        return view('admin.pharmacy.edit', ['medicine' => $pharmacy]);
    }

    public function update(Request $request, Medicine $pharmacy)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'status' => 'nullable|in:available,out_of_stock,expired',
        ]);
        $pharmacy->update($data);
        return redirect()->route('admin.pharmacy.index')->with('success', 'Medicine updated.');
    }

    public function destroy(Medicine $pharmacy)
    {
        $pharmacy->delete();
        return redirect()->route('admin.pharmacy.index')->with('success', 'Medicine deleted.');
    }
}

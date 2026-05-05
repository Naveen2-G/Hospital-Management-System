<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Setting;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('patient');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice_number', 'like', "%{$s}%")
                  ->orWhereHas('patient', fn($q2) => $q2->where('name', 'like', "%{$s}%"));
            });
        }
        $invoices = $query->orderByDesc('created_at')->paginate(15);
        $totals = [
            'total' => Invoice::sum('total_amount'),
            'paid' => Invoice::sum('paid_amount'),
            'due' => Invoice::sum('due_amount'),
        ];
        return view('admin.billing.index', compact('invoices', 'totals'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        return view('admin.billing.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'due_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
        $invoice = Invoice::create([
            'patient_id' => $data['patient_id'],
            'invoice_number' => 'INV-' . str_pad(Invoice::max('id') + 1, 5, '0', STR_PAD_LEFT),
            'total_amount' => $total,
            'paid_amount' => 0,
            'due_amount' => $total,
            'status' => 'unpaid',
            'due_date' => $data['due_date'] ?? null,
        ]);
        foreach ($data['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }
        return redirect()->route('admin.billing.index')->with('success', 'Invoice #' . $invoice->invoice_number . ' created.');
    }

    public function show(Invoice $billing)
    {
        $billing->load(['patient', 'items', 'payments']);
        return view('admin.billing.show', ['invoice' => $billing]);
    }

    public function edit(Invoice $billing)
    {
        $billing->load('items');
        $patients = Patient::orderBy('name')->get();
        return view('admin.billing.edit', ['invoice' => $billing, 'patients' => $patients]);
    }

    public function update(Request $request, Invoice $billing)
    {
        $data = $request->validate([
            'status' => 'nullable|in:unpaid,partial,paid',
            'due_date' => 'nullable|date',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:cash,card,online,insurance',
        ]);
        if (!empty($data['payment_amount']) && $data['payment_amount'] > 0) {
            Payment::create([
                'invoice_id' => $billing->id,
                'amount' => $data['payment_amount'],
                'method' => $data['payment_method'] ?? 'cash',
                'paid_at' => now(),
            ]);
            $billing->paid_amount += $data['payment_amount'];
            $billing->due_amount = $billing->total_amount - $billing->paid_amount;
            $billing->status = $billing->due_amount <= 0 ? 'paid' : 'partial';
        }
        if (isset($data['due_date'])) $billing->due_date = $data['due_date'];
        $billing->save();
        return redirect()->route('admin.billing.show', $billing)->with('success', 'Invoice updated.');
    }

    public function destroy(Invoice $billing)
    {
        $billing->delete();
        return redirect()->route('admin.billing.index')->with('success', 'Invoice deleted.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'items', 'payments']);
        $hospital = [
            'name' => Setting::get('hospital_name', 'HMS Hospital'),
            'address' => Setting::get('hospital_address', '123 Healthcare Avenue, Mumbai 400001'),
            'phone' => Setting::get('hospital_phone', '+91-22-12345678'),
            'email' => Setting::get('hospital_email', 'info@hms-hospital.com'),
        ];
        return view('admin.billing.print', compact('invoice', 'hospital'));
    }
}

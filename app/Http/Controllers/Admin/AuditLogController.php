<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');
        if ($request->filled('action')) $query->where('action', $request->action);
        if ($request->filled('date'))   $query->whereDate('created_at', $request->date);
        $logs = $query->orderByDesc('created_at')->paginate(25);
        return view('admin.audit-logs.index', compact('logs'));
    }
}

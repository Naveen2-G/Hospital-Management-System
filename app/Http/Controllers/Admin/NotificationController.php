<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());
        if ($request->filled('type')) $query->where('type', $request->type);
        $notifications = $query->orderByDesc('created_at')->paginate(20);

        // Mark all as read
        if ($request->has('mark_read')) {
            Notification::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
            return back()->with('success', 'All notifications marked as read.');
        }

        return view('admin.notifications.index', compact('notifications'));
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Department;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->get()->groupBy('group');
        $departments = Department::orderBy('name')->get();
        return view('admin.settings.index', compact('settings', 'departments'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hospital_name' => 'nullable|string|max:255',
            'hospital_address' => 'nullable|string',
            'hospital_phone' => 'nullable|string|max:20',
            'hospital_email' => 'nullable|email|max:255',
        ]);
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        // Handle department status updates
        if ($request->has('dept_status')) {
            foreach ($request->dept_status as $id => $status) {
                Department::where('id', $id)->update(['status' => $status]);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}

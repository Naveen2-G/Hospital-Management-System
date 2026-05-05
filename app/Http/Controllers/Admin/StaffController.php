<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('department');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('designation', 'like', "%{$s}%");
            });
        }
        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);
        $staff = $query->orderBy('name')->paginate(15);
        $departments = Department::where('status', 'active')->get();
        return view('admin.staff.index', compact('staff', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $messages = [
            'phone.required' => 'Phone number is mandatory to enter.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'designation' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:active,inactive',
        ], $messages);
        Staff::create($data);
        return redirect()->route('admin.staff.index')->with('success', 'Staff member added.');
    }

    public function show(Staff $staff)
    {
        $staff->load('department');
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $messages = [
            'phone.required' => 'Phone number is mandatory to enter.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'designation' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:active,inactive',
        ], $messages);
        $staff->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted.');
    }
}

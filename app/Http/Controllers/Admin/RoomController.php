<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Bed;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::withCount(['beds', 'availableBeds']);
        if ($request->filled('type'))   $query->where('type', $request->type);
        if ($request->filled('status')) $query->where('status', $request->status);
        $rooms = $query->orderBy('room_number')->paginate(15);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create() { return view('admin.rooms.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number',
            'type' => 'required|in:ICU,General,Private,Semi-Private',
            'floor' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'rate_per_day' => 'required|numeric|min:0',
            'status' => 'nullable|in:available,occupied,maintenance',
        ]);
        $room = Room::create($data);
        // Auto-create beds
        for ($i = 1; $i <= $room->capacity; $i++) {
            Bed::create(['room_id' => $room->id, 'bed_number' => $room->room_number . '-B' . $i]);
        }
        return redirect()->route('admin.rooms.index')->with('success', 'Room added with ' . $room->capacity . ' bed(s).');
    }

    public function show(Room $room)
    {
        $room->load('beds');
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room) { return view('admin.rooms.edit', compact('room')); }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id,
            'type' => 'required|in:ICU,General,Private,Semi-Private',
            'floor' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'rate_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
        ]);
        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('success', 'Room updated.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted.');
    }
}

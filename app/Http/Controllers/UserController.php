<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
        public function index(Request $request)
{
    // Mapping role => label
    $roleLabels = [
        '1' => 'Superadmin',
        '2' => 'Regional Office Head',
        '3' => 'Warehouse Head',
        '4' => 'Field Technician',
    ];

    // Ambil role yang ada di DB
    $rolesFromDb = User::select('role')->distinct()->pluck('role')->toArray();

    // Buat array roles berdasarkan data dari DB
    $roles = collect($roleLabels)->only($rolesFromDb)->toArray();

    // Mulai query untuk ambil data user
    $query = User::query();

    // Terapkan filter role jika ada
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Ambil daftar region yang valid dan tidak kosong
    $regions = User::select('region')
                   ->distinct()
                   ->whereNotNull('region')  // Menghindari region kosong
                   ->pluck('region');

    // Terapkan filter region jika ada
    if ($request->filled('region')) {
        $query->where('region', $request->region);
    }

    // Terapkan filter search jika ada
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Ambil data user dengan filter yang diterapkan
    $users = $query
        ->orderBy('role', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();  // Menjaga query string di URL

    // Kirim data ke view
    return view('kepalagudang.datauser', compact('users', 'roles', 'regions', 'roleLabels'));
}


    public function store(Request $request)
    {
        // Validasi dan simpan data user baru
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|numeric|in:1,2,3,4',
            'bagian' => 'nullable|string|max:255',
            'atasan' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'region' => $request->region,
            'bagian' => $request->bagian,
            'atasan' => $request->atasan,
        ]);

        return redirect()->route('kepalagudang.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('kepalagudang.datauser', compact('user'));
    }

    public function update(Request $request, $id)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|numeric|in:1,2,3,4',
        'region' => 'nullable|string|max:255',
        'atasan' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Temukan user berdasarkan ID
    $user = User::findOrFail($id);

    // Data yang akan diupdate
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'region' => $request->region,
        'atasan' => $request->atasan,
    ];

        if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return response()->json(['success' => true]);

}


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('kepalagudang.user.index')->with('success', 'User berhasil dihapus.');
    }
}
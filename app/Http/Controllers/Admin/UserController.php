<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $query = User::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::with('favoriteFilms')->findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Prevent deleting other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun admin lain.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}

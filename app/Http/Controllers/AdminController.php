<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        return view('admin');
    }

    public function officers() {
//        $officers = DB::table('officers')->orderBy('sort_order')->orderBy('year', 'desc')->get();
        $officers = Officer::all()->sortBy('sort_order')->sortByDesc('year');
        return view('admin.officers', compact('officers'));
    }

    public function searchUsers(Request $request) {
        $query = $request->input('q');
        if (empty($query)) {
            return response()->json([]);
        }
        $users = DB::table('users')
            ->where('username', 'LIKE', '%' . $query . '%')
            ->orWhere('first_name', 'LIKE', '%' . $query . '%')
            ->orWhere('last_name', 'LIKE', '%' . $query . '%')
            ->limit(10)
            ->select(['id', 'username', 'first_name', 'last_name'])
            ->get();
        return response()->json($users);
    }
}

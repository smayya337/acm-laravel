<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficerRequest;
use App\Http\Requests\UpdateOfficerRequest;
use App\Models\Officer;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $year = now()->year;
        $largest_in_db = DB::table("officers")->max('year');
        if ($largest_in_db !== null) {
            $year = $largest_in_db;
        }
        return $this->showByYear($year);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficerRequest $request)
    {
        $validated = $request->validated();
        $user_id = DB::table('users')->where('username', '=', $validated['user_id'])->value('id');
        $validated['user_id'] = $user_id;
        $officer = new Officer($validated);
        $officer->save();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Officer $officer)
    {
        return view('admin.officer_detail', compact('officer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Officer $officer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficerRequest $request, Officer $officer)
    {
        $validated = $request->validated();
        $user_id = DB::table('users')->where('username', '=', $validated['user_id'])->value('id');
        $validated['user_id'] = $user_id;
        $officer->update($validated);
        $officer->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Officer $officer)
    {
        $officer->delete();
        return redirect()->route('admin.officers');
    }

    public function showByYear(int $year) {
        $officers = Officer::where('year', '=', $year)->get();
        $all_years = DB::table('officers')->orderByDesc('year')->groupBy('year')->distinct()->pluck('year');
        return view('officers', compact('officers', 'year', 'all_years'));
    }
}

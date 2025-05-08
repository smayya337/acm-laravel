<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user_page', ['req_user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $image = $request->file('profile_image');
        $image_data = Image::read($image);
        $dimension = min($image_data->width(), $image_data->height());
        $image_data = $image_data->crop($dimension, $dimension, position: 'center');
        $path = 'images/users/' . $user->id . '.webp';
        Storage::disk('public')->makeDirectory('images/users');
        $image_data->save(Storage::disk('public')->path($path));
        $validated['image'] = $path;
        if ($validated['bio'] === null) {
            $validated['bio'] = '';
        }
        $user->update($validated);
        $user->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

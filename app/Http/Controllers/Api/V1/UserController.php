<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\FileHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\BadgeResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * List all users (paginated)
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply filters
        if ($request->has('is_admin')) {
            $query->where('is_admin', $request->boolean('is_admin'));
        }

        if ($request->has('hidden')) {
            $query->where('hidden', $request->boolean('hidden'));
        }

        // Apply sorting
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        // Apply includes
        if ($request->has('include')) {
            $includes = explode(',', $request->input('include'));
            if (in_array('badges', $includes)) {
                $query->with('badges');
            }
            if (in_array('events', $includes)) {
                $query->with('events');
            }
        }

        // Paginate
        $perPage = $request->input('per_page', 25);
        $users = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users->items()),
            'meta' => [
                'pagination' => $this->getPaginationMetaFromPaginator($users),
            ],
        ]);
    }

    /**
     * Create a new user
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('users', 'public');
        }

        $user = User::create($validated);
        $user->load('badges');

        return $this->createdResponse(
            new UserResource($user),
            'User created successfully'
        );
    }

    /**
     * Get user by ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = User::with(['badges', 'events'])->find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        return $this->resourceResponse(new UserResource($user));
    }

    /**
     * Get public profile by username
     */
    public function showByUsername(Request $request, string $username): JsonResponse
    {
        $user = User::with(['badges', 'events'])->where('username', $username)->first();

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        // Respect hidden flag for public access
        if ($user->hidden && (!auth()->check() || !auth()->user()->is_admin)) {
            return $this->forbiddenResponse('This profile is hidden');
        }

        return $this->resourceResponse(new UserResource($user));
    }

    /**
     * Update user
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($validated);
        $user->load('badges');

        return $this->successResponse(
            new UserResource($user),
            'User updated successfully'
        );
    }

    /**
     * Delete user
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $user->delete();

        return $this->deletedResponse('User deleted successfully');
    }

    /**
     * Get user's badges
     */
    public function badges($id): JsonResponse
    {
        $user = User::with('badges')->find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse(BadgeResource::collection($user->badges));
    }

    /**
     * Assign badges to user
     */
    public function assignBadges(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $request->validate([
            'badge_ids' => 'required|array',
            'badge_ids.*' => 'exists:badges,id'
        ]);

        // Get badges that the user doesn't already have
        $existingBadgeIds = $user->badges->pluck('id')->toArray();
        $newBadgeIds = array_diff($request->input('badge_ids'), $existingBadgeIds);

        if (empty($newBadgeIds)) {
            return $this->errorResponse('User already has all selected badges', 422, 'DUPLICATE_BADGES');
        }

        // Attach new badges
        $user->badges()->attach($newBadgeIds);
        $user->load('badges');

        return $this->successResponse(
            new UserResource($user),
            count($newBadgeIds) . ' badge(s) assigned successfully'
        );
    }

    /**
     * Remove badges from user
     */
    public function removeBadges(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $request->validate([
            'badge_ids' => 'required|array',
            'badge_ids.*' => 'exists:badges,id'
        ]);

        $user->badges()->detach($request->input('badge_ids'));
        $user->load('badges');

        return $this->successResponse(
            new UserResource($user),
            count($request->input('badge_ids')) . ' badge(s) removed successfully'
        );
    }

    /**
     * Get events user has RSVPed to
     */
    public function events($id): JsonResponse
    {
        $user = User::with('events')->find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse(EventResource::collection($user->events));
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return $this->successResponse(null, 'Password reset successfully');
    }

    /**
     * Helper method to get pagination meta from paginator
     */
    private function getPaginationMetaFromPaginator($paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'total_pages' => $paginator->lastPage(),
            'has_more' => $paginator->hasMorePages(),
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ];
    }
}

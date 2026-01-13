<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\StoreBadgeRequest;
use App\Http\Requests\Api\V1\UpdateBadgeRequest;
use App\Http\Resources\BadgeResource;
use App\Http\Resources\UserResource;
use App\Models\Badge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BadgeController extends ApiController
{
    /**
     * List all badges
     */
    public function index(Request $request): JsonResponse
    {
        $query = Badge::query();

        // Apply sorting
        $sortField = $request->input('sort', 'name');
        $sortOrder = $request->input('order', 'asc');
        $query->orderBy($sortField, $sortOrder);

        // Always include user count
        $query->withCount('users');

        // Check if we need pagination
        if ($request->has('per_page')) {
            $perPage = $request->input('per_page', 25);
            $badges = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => BadgeResource::collection($badges->items()),
                'meta' => [
                    'pagination' => $this->getPaginationMetaFromPaginator($badges),
                ],
            ]);
        }

        // Return all badges without pagination
        $badges = $query->get();
        return $this->successResponse(BadgeResource::collection($badges));
    }

    /**
     * Create a new badge
     */
    public function store(StoreBadgeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $badge = Badge::create($validated);
        $badge->loadCount('users');

        return $this->createdResponse(
            new BadgeResource($badge),
            'Badge created successfully'
        );
    }

    /**
     * Get badge details
     */
    public function show(Request $request, $id): JsonResponse
    {
        $badge = Badge::withCount('users')->find($id);

        if (!$badge) {
            return $this->notFoundResponse('Badge not found');
        }

        return $this->resourceResponse(new BadgeResource($badge));
    }

    /**
     * Update badge
     */
    public function update(UpdateBadgeRequest $request, $id): JsonResponse
    {
        $badge = Badge::find($id);

        if (!$badge) {
            return $this->notFoundResponse('Badge not found');
        }

        $validated = $request->validated();
        $badge->update($validated);
        $badge->loadCount('users');

        return $this->successResponse(
            new BadgeResource($badge),
            'Badge updated successfully'
        );
    }

    /**
     * Delete badge
     */
    public function destroy($id): JsonResponse
    {
        $badge = Badge::find($id);

        if (!$badge) {
            return $this->notFoundResponse('Badge not found');
        }

        $badge->delete();

        return $this->deletedResponse('Badge deleted successfully');
    }

    /**
     * Get users who have this badge
     */
    public function users($id): JsonResponse
    {
        $badge = Badge::with('users')->find($id);

        if (!$badge) {
            return $this->notFoundResponse('Badge not found');
        }

        return $this->successResponse(UserResource::collection($badge->users));
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

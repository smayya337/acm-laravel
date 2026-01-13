<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\StoreOfficerRequest;
use App\Http\Requests\Api\V1\UpdateOfficerRequest;
use App\Http\Resources\OfficerResource;
use App\Models\Officer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfficerController extends ApiController
{
    /**
     * List all officers (paginated)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Officer::with('user');

        // Apply year filter
        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        // Apply position filter
        if ($request->has('position')) {
            $query->where('position', 'like', '%' . $request->input('position') . '%');
        }

        // Apply sorting
        $sortField = $request->input('sort', 'year');
        $sortOrder = $request->input('order', 'desc');

        if ($sortField === 'year') {
            $query->orderBy('year', $sortOrder)->orderBy('sort_order', 'asc');
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        // Paginate
        $perPage = $request->input('per_page', 50);
        $officers = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => OfficerResource::collection($officers->items()),
            'meta' => [
                'pagination' => $this->getPaginationMetaFromPaginator($officers),
            ],
        ]);
    }

    /**
     * Get current year's officers
     */
    public function current(Request $request): JsonResponse
    {
        $currentYear = date('Y');

        $officers = Officer::with('user')
            ->where('year', $currentYear)
            ->orderBy('sort_order', 'asc')
            ->get();

        return $this->successResponse(OfficerResource::collection($officers));
    }

    /**
     * Get officers for a specific year
     */
    public function byYear(Request $request, int $year): JsonResponse
    {
        $officers = Officer::with('user')
            ->where('year', $year)
            ->orderBy('sort_order', 'asc')
            ->get();

        return $this->successResponse(OfficerResource::collection($officers));
    }

    /**
     * Create a new officer
     */
    public function store(StoreOfficerRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $officer = Officer::create($validated);
        $officer->load('user');

        return $this->createdResponse(
            new OfficerResource($officer),
            'Officer created successfully'
        );
    }

    /**
     * Get officer details
     */
    public function show(Request $request, $id): JsonResponse
    {
        $officer = Officer::with('user')->find($id);

        if (!$officer) {
            return $this->notFoundResponse('Officer not found');
        }

        return $this->resourceResponse(new OfficerResource($officer));
    }

    /**
     * Update officer
     */
    public function update(UpdateOfficerRequest $request, $id): JsonResponse
    {
        $officer = Officer::find($id);

        if (!$officer) {
            return $this->notFoundResponse('Officer not found');
        }

        $validated = $request->validated();
        $officer->update($validated);
        $officer->load('user');

        return $this->successResponse(
            new OfficerResource($officer),
            'Officer updated successfully'
        );
    }

    /**
     * Delete officer
     */
    public function destroy($id): JsonResponse
    {
        $officer = Officer::find($id);

        if (!$officer) {
            return $this->notFoundResponse('Officer not found');
        }

        $officer->delete();

        return $this->deletedResponse('Officer deleted successfully');
    }

    /**
     * Delete all officers for a specific year
     */
    public function deleteByYear(int $year): JsonResponse
    {
        $count = Officer::where('year', $year)->count();
        Officer::where('year', $year)->delete();

        return $this->deletedResponse(
            "All officers for year {$year} deleted successfully ({$count} records removed)"
        );
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

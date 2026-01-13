<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\FileHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\StoreEventRequest;
use App\Http\Requests\Api\V1\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends ApiController
{
    /**
     * List all events (paginated)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Event::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Apply date filters
        if ($request->has('start_after')) {
            $query->where('start', '>=', $request->input('start_after'));
        }

        if ($request->has('start_before')) {
            $query->where('start', '<=', $request->input('start_before'));
        }

        // Apply location filter
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        // Apply sorting
        $sortField = $request->input('sort', 'start');
        $sortOrder = $request->input('order', 'asc');
        $query->orderBy($sortField, $sortOrder);

        // Apply includes
        if ($request->has('include')) {
            $includes = explode(',', $request->input('include'));
            if (in_array('attendees', $includes)) {
                $query->with('users')->withCount('users');
            }
        } else {
            $query->withCount('users');
        }

        // Paginate
        $perPage = $request->input('per_page', 25);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EventResource::collection($events->items()),
            'meta' => [
                'pagination' => $this->getPaginationMetaFromPaginator($events),
            ],
        ]);
    }

    /**
     * List upcoming events
     */
    public function upcoming(Request $request): JsonResponse
    {
        $query = Event::where('start', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->withCount('users');

        $perPage = $request->input('per_page', 25);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EventResource::collection($events->items()),
            'meta' => [
                'pagination' => $this->getPaginationMetaFromPaginator($events),
            ],
        ]);
    }

    /**
     * List past events
     */
    public function past(Request $request): JsonResponse
    {
        $query = Event::where('start', '<', Carbon::now())
            ->orderBy('start', 'desc')
            ->withCount('users');

        $perPage = $request->input('per_page', 25);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EventResource::collection($events->items()),
            'meta' => [
                'pagination' => $this->getPaginationMetaFromPaginator($events),
            ],
        ]);
    }

    /**
     * Create a new event
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($validated);
        $event->loadCount('users');

        return $this->createdResponse(
            new EventResource($event),
            'Event created successfully'
        );
    }

    /**
     * Get event details
     */
    public function show(Request $request, $id): JsonResponse
    {
        $event = Event::with('users')->withCount('users')->find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        return $this->resourceResponse(new EventResource($event));
    }

    /**
     * Update event
     */
    public function update(UpdateEventRequest $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        $event->loadCount('users');

        return $this->successResponse(
            new EventResource($event),
            'Event updated successfully'
        );
    }

    /**
     * Delete event
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        $event->delete();

        return $this->deletedResponse('Event deleted successfully');
    }

    /**
     * Upload event image
     */
    public function uploadImage(Request $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:' . FileHelper::getMaxUploadSizeKB()
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $event->update(['image' => $path]);
        }

        $event->loadCount('users');

        return $this->successResponse(
            new EventResource($event),
            'Event image uploaded successfully'
        );
    }

    /**
     * Get event attendees
     */
    public function attendees($id): JsonResponse
    {
        $event = Event::with('users')->find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        return $this->successResponse(UserResource::collection($event->users));
    }

    /**
     * RSVP to event (join)
     */
    public function rsvp(Request $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        $user = $request->user();

        // Check if already RSVPed
        if ($event->users->contains($user->id)) {
            return $this->errorResponse('You have already RSVPed to this event', 422, 'ALREADY_RSVPED');
        }

        $event->users()->attach($user->id);
        $event->loadCount('users');

        return $this->successResponse(
            new EventResource($event),
            'RSVP successful'
        );
    }

    /**
     * Cancel RSVP (leave)
     */
    public function cancelRsvp(Request $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return $this->notFoundResponse('Event not found');
        }

        $user = $request->user();

        // Check if RSVPed
        if (!$event->users->contains($user->id)) {
            return $this->errorResponse('You have not RSVPed to this event', 422, 'NOT_RSVPED');
        }

        $event->users()->detach($user->id);
        $event->loadCount('users');

        return $this->successResponse(
            new EventResource($event),
            'RSVP cancelled successfully'
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

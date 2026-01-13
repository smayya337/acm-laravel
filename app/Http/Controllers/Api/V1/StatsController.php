<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Badge;
use App\Models\Event;
use App\Models\Officer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends ApiController
{
    /**
     * Get comprehensive admin statistics
     */
    public function index(Request $request): JsonResponse
    {
        $currentYear = date('Y');

        $stats = [
            'users' => [
                'total' => User::count(),
                'admins' => User::where('is_admin', true)->count(),
                'hidden' => User::where('hidden', true)->count(),
            ],
            'events' => [
                'total' => Event::count(),
                'upcoming' => Event::where('start', '>=', Carbon::now())->count(),
                'past' => Event::where('start', '<', Carbon::now())->count(),
            ],
            'officers' => [
                'total' => Officer::count(),
                'current_year' => Officer::where('year', $currentYear)->count(),
            ],
            'badges' => [
                'total' => Badge::count(),
                'assigned' => DB::table('badge_user')->count(),
            ],
            'rsvps' => [
                'total' => DB::table('event_user')->count(),
            ],
        ];

        return $this->successResponse($stats);
    }

    /**
     * Get public statistics
     */
    public function public(Request $request): JsonResponse
    {
        $stats = [
            'members' => User::where('hidden', false)->count(),
            'upcoming_events' => Event::where('start', '>=', Carbon::now())->count(),
            'total_events' => Event::count(),
            'active_officers' => Officer::where('year', date('Y'))->count(),
        ];

        return $this->successResponse($stats);
    }
}

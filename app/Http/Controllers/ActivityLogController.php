<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    protected $activityService;

    public function __construct(ActivityLogService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function logActivity(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'details' => 'nullable|array',
            'page' => 'nullable|string',
            'element' => 'nullable|string',
        ]);

        $activity = Activity::create([
            'log_name' => 'user_activity',
            'description' => $request->action,
            'subject_id' => null,
            'subject_type' => 'user_activity',
            'causer_id' => Auth::id(),
            'causer_type' => Auth::check() ? get_class(Auth::user()) : null,
            'properties' => [
                'action' => $request->action,
                'details' => $request->details,
                'page' => $request->page,
                'element' => $request->element,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->header('Referer'),
                'timestamp' => now()->toISOString(),
            ],
        ]);

        return response()->json(['success' => true]);
    }

    public function getActivityStats()
    {
        $stats = $this->activityService->getTodayStats();
        $breakdown = $this->activityService->getActivityBreakdown();
        $recentActivities = $this->activityService->getRecentActivities(10);

        return response()->json([
            'stats' => $stats,
            'breakdown' => $breakdown,
            'recent' => $recentActivities,
        ]);
    }

    public function getUserActivity(Request $request)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            return response()->json(['error' => 'User ID required'], 400);
        }

        $userInfo = $this->activityService->getUserSessionInfo($userId);
        
        return response()->json($userInfo);
    }
}
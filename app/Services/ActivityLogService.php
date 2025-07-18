<?php

namespace App\Services;

use App\Models\User;
use App\Models\LoginActivity;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityLogService
{
    public function getTodayStats(): array
    {
        $today = Carbon::today();
        
        return [
            'total_activities' => Activity::whereDate('created_at', $today)->count(),
            'user_activities' => Activity::whereDate('created_at', $today)
                ->whereNotNull('causer_id')
                ->count(),
            'system_activities' => Activity::whereDate('created_at', $today)
                ->whereNull('causer_id')
                ->count(),
            'logins' => LoginActivity::whereDate('created_at', $today)->count(),
            'unique_users' => Activity::whereDate('created_at', $today)
                ->whereNotNull('causer_id')
                ->distinct('causer_id')
                ->count(),
        ];
    }

    public function getActivityBreakdown(): array
    {
        return Activity::select('description', DB::raw('count(*) as count'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy('description')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    public function getModelBreakdown(): array
    {
        return Activity::select('log_name', DB::raw('count(*) as count'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy('log_name')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    public function getMostActiveUsers(int $limit = 10): array
    {
        return Activity::with('causer')
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('causer_id')
            ->select('causer_id', DB::raw('count(*) as activity_count'))
            ->groupBy('causer_id')
            ->orderBy('activity_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($activity) {
                return [
                    'user' => $activity->causer?->name ?? 'Unknown',
                    'email' => $activity->causer?->email ?? 'Unknown',
                    'activity_count' => $activity->activity_count,
                ];
            })
            ->toArray();
    }

    public function getRecentActivities(int $limit = 20): array
    {
        return Activity::with('causer')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user' => $activity->causer?->name ?? 'System',
                    'action' => $activity->description,
                    'model' => $activity->log_name,
                    'subject_id' => $activity->subject_id,
                    'created_at' => $activity->created_at,
                    'ip_address' => $activity->properties['ip_address'] ?? 'N/A',
                ];
            })
            ->toArray();
    }

    public function getHourlyActivity(): array
    {
        $dbDriver = DB::connection()->getDriverName();
        
        if ($dbDriver === 'sqlite') {
            $activities = Activity::whereDate('created_at', Carbon::today())
                ->select(DB::raw("strftime('%H', created_at) as hour"), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->pluck('count', 'hour')
                ->toArray();
        } else {
            $activities = Activity::whereDate('created_at', Carbon::today())
                ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->pluck('count', 'hour')
                ->toArray();
        }

        // Fill missing hours with 0
        $hourlyData = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $hourlyData[$hour] = $activities[$hour] ?? 0;
        }

        return $hourlyData;
    }

    public function getUserSessionInfo(int $userId): array
    {
        $user = User::find($userId);
        if (!$user) {
            return [];
        }

        $loginActivity = LoginActivity::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        $recentActivity = Activity::where('causer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        return [
            'user' => $user,
            'last_login' => $loginActivity,
            'last_activity' => $recentActivity,
            'total_activities_today' => Activity::where('causer_id', $userId)
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'is_online' => $recentActivity && $recentActivity->created_at->diffInMinutes(now()) < 5,
        ];
    }
}
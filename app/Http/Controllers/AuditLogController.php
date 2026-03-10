<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs
     */
    public function index(Request $request)
    {
        try {
            \Log::info('Audit logs index request', [
                'is_ajax' => $request->ajax(),
                'filters' => $request->all()
            ]);
            
            $query = AuditLog::with('user')->orderBy('created_at', 'desc');

            // Filtering
            if ($request->filled('action')) {
                $query->byAction($request->action);
            }

            if ($request->filled('model_type')) {
                $query->byModel($request->model_type);
            }

            if ($request->filled('user_id')) {
                $query->byUser($request->user_id);
            }

            if ($request->filled('date_from')) {
                $query->where('created_at', '>=', Carbon::parse($request->date_from)->setTimezone(config('app.timezone'))->startOfDay());
            }

            if ($request->filled('date_to')) {
                $query->where('created_at', '<=', Carbon::parse($request->date_to)->setTimezone(config('app.timezone'))->endOfDay());
            }

            // Special filters for user activities
            if ($request->filled('activity_type')) {
                switch ($request->activity_type) {
                    case 'login_activities':
                        $query->whereIn('action', ['login', 'logout', 'login_failed', 'session_timeout']);
                        break;
                    case 'bill_header_changes':
                        $query->where('action', 'bill_header_updated');
                        break;
                    case 'user_changes':
                        $query->whereIn('action', ['profile_updated', 'password_changed']);
                        break;
                    case 'suspicious_activities':
                        $query->where('action', 'suspicious_activity');
                        break;
                }
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhere('model_type', 'like', "%{$search}%")
                      ->orWhere('user_name', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%")
                      ->orWhereRaw('JSON_SEARCH(old_values, "one", ?) IS NOT NULL', ["%{$search}%"])
                      ->orWhereRaw('JSON_SEARCH(new_values, "one", ?) IS NOT NULL', ["%{$search}%"]);
                });
            }

            $auditLogs = $query->paginate(20);

            // Get filter options
            $actions = AuditLog::distinct()->pluck('action')->filter()->sort()->values();
            $modelTypes = AuditLog::distinct()->pluck('model_type')->filter()->sort()->map(function($type) {
                return [
                    'value' => $type,
                    'label' => class_basename($type)
                ];
            })->values();
            $users = User::orderBy('name')->get(['id', 'name']);

            // Activity type options
            $activityTypes = [
                ['value' => 'login_activities', 'label' => 'Login Activities'],
                ['value' => 'bill_header_changes', 'label' => 'Bill Header Changes'],
                ['value' => 'user_changes', 'label' => 'User Changes'],
                ['value' => 'suspicious_activities', 'label' => 'Suspicious Activities'],
            ];

            if ($request->ajax()) {
                try {
                    $html = view('admin.audit-logs.table', compact('auditLogs'))->render();
                    $pagination = $auditLogs->links()->render();
                    
                    \Log::info('AJAX audit logs request', [
                        'filters' => $request->all(),
                        'total_found' => $auditLogs->total(),
                        'current_page' => $auditLogs->currentPage(),
                        'per_page' => $auditLogs->perPage()
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'html' => $html,
                        'pagination' => $pagination,
                        'total' => $auditLogs->total(),
                        'current_page' => $auditLogs->currentPage(),
                        'last_page' => $auditLogs->lastPage(),
                        'filters_applied' => $request->all()
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error rendering AJAX audit logs response', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'error' => 'Failed to render audit logs table',
                        'message' => $e->getMessage()
                    ], 500);
                }
            }

            // Get stats for the page
            $stats = [
                'total_logs' => AuditLog::count(),
                'today_logs' => AuditLog::whereDate('created_at', today())->count(),
                'this_week_logs' => AuditLog::whereBetween('created_at', [
                    now()->startOfWeek(), 
                    now()->endOfWeek()
                ])->count(),
                'this_month_logs' => AuditLog::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)->count(),
            ];

            return view('admin.audit-logs.index', compact('auditLogs', 'actions', 'modelTypes', 'users', 'activityTypes', 'stats'));
        } catch (\Exception $e) {
            \Log::error('Error in audit logs index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to load audit logs',
                    'html' => '<div class="text-center py-8 text-red-600">Failed to load audit logs. Please try again.</div>'
                ], 500);
            }
            
            return view('admin.audit-logs.index', [
                'auditLogs' => collect([])->paginate(20),
                'actions' => collect([]),
                'modelTypes' => collect([]),
                'users' => collect([]),
                'activityTypes' => [],
                'stats' => [
                    'total_logs' => 0,
                    'today_logs' => 0,
                    'this_week_logs' => 0,
                    'this_month_logs' => 0,
                ]
            ])->with('error', 'Failed to load audit logs. Please try again.');
        }
    }

    /**
     * Show detailed audit log
     */
    public function show(AuditLog $auditLog)
    {
        try {
            \Log::info('Audit log show request', [
                'audit_log_id' => $auditLog->id,
                'action' => $auditLog->action,
                'model_type' => $auditLog->model_type
            ]);
            
            $auditLog->load('user');
            
            \Log::info('Audit log loaded successfully', [
                'has_user' => $auditLog->user ? true : false,
                'user_name' => $auditLog->user ? $auditLog->user->name : 'System'
            ]);
            
            return response()->json($auditLog);
        } catch (\Exception $e) {
            \Log::error('Error showing audit log: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load audit log details',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user login history
     */
    public function getUserLoginHistory(Request $request, User $user = null)
    {
        $userId = $user ? $user->id : $request->input('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $targetUser = $user ?: User::findOrFail($userId);
        $loginHistory = AuditService::getUserLoginHistory($targetUser, 100);

        return response()->json([
            'user' => [
                'id' => $targetUser->id,
                'name' => $targetUser->name,
                'email' => $targetUser->email,
            ],
            'login_history' => $loginHistory,
            'summary' => [
                'total_logins' => $loginHistory->where('action', 'login')->count(),
                'total_logouts' => $loginHistory->where('action', 'logout')->count(),
                'failed_attempts' => $loginHistory->where('action', 'login_failed')->count(),
                'last_login' => $loginHistory->where('action', 'login')->first()?->created_at,
                'last_logout' => $loginHistory->where('action', 'logout')->first()?->created_at,
            ]
        ]);
    }

    /**
     * Get bill header change history
     */
    public function getBillHeaderHistory(Request $request)
    {
        $history = AuditService::getBillHeaderChangeHistory(50);

        return response()->json([
            'history' => $history,
            'summary' => [
                'total_changes' => $history->count(),
                'last_change' => $history->first()?->created_at,
                'changes_by_user' => $history->groupBy('user_name')->map->count(),
            ]
        ]);
    }

    /**
     * Export audit logs
     */
    public function export(Request $request)
    {
        $query = AuditLog::with('user');

        // Apply same filters as index
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        if ($request->filled('model_type')) {
            $query->byModel($request->model_type);
        }

        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

                    if ($request->filled('date_from')) {
                $query->where('created_at', '>=', Carbon::parse($request->date_from)->setTimezone(config('app.timezone'))->startOfDay());
            }

            if ($request->filled('date_to')) {
                $query->where('created_at', '<=', Carbon::parse($request->date_to)->setTimezone(config('app.timezone'))->endOfDay());
            }

        if ($request->filled('activity_type')) {
            switch ($request->activity_type) {
                case 'login_activities':
                    $query->whereIn('action', ['login', 'logout', 'login_failed', 'session_timeout']);
                    break;
                case 'bill_header_changes':
                    $query->where('action', 'bill_header_updated');
                    break;
                case 'user_changes':
                    $query->whereIn('action', ['profile_updated', 'password_changed']);
                    break;
                case 'suspicious_activities':
                    $query->where('action', 'suspicious_activity');
                    break;
            }
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'audit_logs_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($auditLogs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Date/Time',
                'Action',
                'Model Type',
                'Model ID',
                'User',
                'Description',
                'Changes',
                'IP Address',
                'User Agent',
                'URL'
            ]);

            foreach ($auditLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->formatted_action,
                    $log->model_name,
                    $log->model_id,
                    $log->user_name,
                    $log->description,
                    $log->formatted_changes,
                    $log->ip_address,
                    $log->user_agent,
                    $log->url
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get audit statistics
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_logs' => AuditLog::count(),
                'today_logs' => AuditLog::whereDate('created_at', today())->count(),
                'this_week_logs' => AuditLog::whereBetween('created_at', [
                    now()->startOfWeek(), 
                    now()->endOfWeek()
                ])->count(),
                'this_month_logs' => AuditLog::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)->count(),
                
                'actions_stats' => AuditLog::selectRaw('action, COUNT(*) as count')
                                         ->groupBy('action')
                                         ->pluck('count', 'action')
                                         ->toArray(),
                
                'models_stats' => AuditLog::selectRaw('model_type, COUNT(*) as count')
                                        ->groupBy('model_type')
                                        ->pluck('count', 'model_type')
                                        ->map(function($count, $type) {
                                            return [
                                                'model' => class_basename($type),
                                                'count' => $count
                                            ];
                                        })
                                        ->values()
                                        ->toArray(),
                
                'users_stats' => AuditLog::selectRaw('user_name, COUNT(*) as count')
                                       ->whereNotNull('user_name')
                                       ->groupBy('user_name')
                                       ->orderByDesc('count')
                                       ->limit(10)
                                       ->pluck('count', 'user_name')
                                       ->toArray(),

                // Enhanced statistics
                'login_stats' => [
                    'total_logins' => AuditLog::where('action', 'login')->count(),
                    'total_logouts' => AuditLog::where('action', 'logout')->count(),
                    'failed_logins' => AuditLog::where('action', 'login_failed')->count(),
                    'session_timeouts' => AuditLog::where('action', 'session_timeout')->count(),
                ],

                'bill_header_stats' => [
                    'total_changes' => AuditLog::where('action', 'bill_header_updated')->count(),
                    'last_change' => AuditLog::where('action', 'bill_header_updated')->latest()->first()?->created_at?->format('Y-m-d H:i:s'),
                ],

                'suspicious_activities' => [
                    'total' => AuditLog::where('action', 'suspicious_activity')->count(),
                    'recent' => AuditLog::where('action', 'suspicious_activity')
                                      ->where('created_at', '>=', now()->subDays(7))
                                      ->count(),
                ],

                'recent_activities' => AuditLog::latest()->limit(10)->get()->map(function($log) {
                    return [
                        'id' => $log->id,
                        'action' => $log->action,
                        'description' => $log->description,
                        'user_name' => $log->user_name,
                        'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                    ];
                })->toArray()
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            \Log::error('Error getting audit stats: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load statistics',
                'total_logs' => 0,
                'today_logs' => 0,
                'this_week_logs' => 0,
                'this_month_logs' => 0,
                'actions_stats' => [],
                'models_stats' => [],
                'users_stats' => [],
                'login_stats' => [
                    'total_logins' => 0,
                    'total_logouts' => 0,
                    'failed_logins' => 0,
                    'session_timeouts' => 0,
                ],
                'bill_header_stats' => [
                    'total_changes' => 0,
                    'last_change' => null,
                ],
                'suspicious_activities' => [
                    'total' => 0,
                    'recent' => 0,
                ],
                'recent_activities' => []
            ], 500);
        }
    }

    /**
     * Get cleanup estimate
     */
    public function cleanupEstimate(Request $request)
    {
        try {
            $days = $request->get('days');
            
            if (!is_numeric($days) || $days < 30 || $days > 3650) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid number of days. Must be between 30 and 3650 days.'
                ], 400);
            }

            $days = (int)$days;
            $cutoffDate = now()->subDays($days);
            $estimatedCount = AuditLog::where('created_at', '<', $cutoffDate)->count();

            return response()->json([
                'success' => true,
                'estimated_count' => $estimatedCount,
                'cutoff_date' => $cutoffDate->format('Y-m-d H:i:s'),
                'days' => $days
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting cleanup estimate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cleanup estimate.'
            ], 500);
        }
    }

    /**
     * Clean old audit logs
     */
    public function cleanup(Request $request)
    {
        try {
            // Handle both JSON and form data
            $days = $request->input('days') ?? $request->json('days') ?? $request->get('days');
            
            // Validate that days parameter exists
            if ($days === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Number of days is required.'
                ], 400);
            }
            
            // Validate the input
            if (!is_numeric($days) || $days < 30 || $days > 3650) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid number of days. Must be between 30 and 3650 days.'
                ], 400);
            }

            $days = (int)$days;
            $cutoffDate = now()->subDays($days);
            
            // Get count before deletion for better user feedback
            $logsToDelete = AuditLog::where('created_at', '<', $cutoffDate);
            $countToDelete = $logsToDelete->count();
            
            if ($countToDelete === 0) {
                return response()->json([
                    'success' => true,
                    'message' => "No audit logs found older than {$days} days to delete.",
                    'deleted_count' => 0,
                    'cutoff_date' => $cutoffDate->format('Y-m-d H:i:s')
                ]);
            }
            
            $deletedCount = $logsToDelete->delete();

            \Log::info('Audit logs cleanup completed', [
                'days' => $days,
                'cutoff_date' => $cutoffDate,
                'deleted_count' => $deletedCount,
                'requested_by' => auth()->user()->name ?? 'Unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} audit log records older than {$days} days.",
                'deleted_count' => $deletedCount,
                'cutoff_date' => $cutoffDate->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error during audit logs cleanup: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'user' => auth()->user()->name ?? 'Unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cleanup audit logs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get real-time audit log updates
     */
    public function getRecentLogs(Request $request)
    {
        $limit = $request->get('limit', 10);
        $since = $request->get('since');

        $query = AuditLog::with('user')->latest();

        if ($since) {
            $query->where('created_at', '>', Carbon::parse($since));
        }

        $logs = $query->limit($limit)->get();

        return response()->json([
            'logs' => $logs,
            'last_update' => now()->toISOString()
        ]);
    }
}
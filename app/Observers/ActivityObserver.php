<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityObserver
{
    /**
     * Log user activity
     */
    public function logActivity($action, $model = null, $description = null)
    {
        if (!Auth::check()) {
            return;
        }

        Activity::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description ?? $this->generateDescription($action, $model),
        ]);
    }

    /**
     * Generate activity description
     */
    private function generateDescription($action, $model)
    {
        if (!$model) {
            return ucfirst($action);
        }

        $modelName = class_basename(get_class($model));
        $identifier = $model->name ?? $model->title ?? $model->email ?? "#{$model->id}";

        return match ($action) {
            'created' => "Created new {$modelName}: {$identifier}",
            'updated' => "Updated {$modelName}: {$identifier}",
            'deleted' => "Deleted {$modelName}: {$identifier}",
            'viewed' => "Viewed {$modelName}: {$identifier}",
            'logged_in' => "User logged in",
            'logged_out' => "User logged out",
            default => ucfirst($action) . " {$modelName}: {$identifier}",
        };
    }

    /**
     * Handle user login event
     */
    public function login($event)
    {
        $this->logActivity('logged_in', $event->user, 'User logged in');
    }

    /**
     * Handle user logout event
     */
    public function logout($event)
    {
        $this->logActivity('logged_out', $event->user, 'User logged out');
    }
}

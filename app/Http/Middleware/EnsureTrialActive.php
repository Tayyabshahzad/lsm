<?php

namespace App\Http\Middleware;

use App\Models\TrialClass;
use Closure;
use Illuminate\Http\Request;

class EnsureTrialActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $courseId = $request->route('courseId');
        $user = auth()->user();
        $trial = TrialClass::where('user_id', $user->id)
        ->where('course_id', $courseId)
        ->where('status', 'pending')
        ->first();
        if (!$trial || now()->greaterThan($trial->trial_end)) {
            return redirect()->route('courses.index')->with('error', 'Your trial has expired or is inactive.');
        }
        return $next($request);
    }
}

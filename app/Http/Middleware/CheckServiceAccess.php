<?php

namespace App\Http\Middleware;

use App\Models\StudentProfile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class CheckServiceAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == 'student'){
            // Getting the service name from the URL.
            $serviceName = $request->segment(1);

            $studentProfile = StudentProfile::where('user_id', Auth::user()->id)->first();
            if ($studentProfile->lessonPlan == null || $studentProfile->lessonPlan->{$serviceName.'_available'} === 0) {
                return Redirect::route('not_available')->with('serviceName', $serviceName);
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Events\VisitorVisited; 
use Illuminate\Support\Facades\Log;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('/')) {          
            $ipAddress = $request->ip();
            Log::info("Visite de la page d'accueil. IP: " . $ipAddress);
            if ($this->isLocal($ipAddress)) {
                Log::info("Exclusion de l'IP locale: " . $ipAddress);
                return $next($request); 
            }

            event(new VisitorVisited($ipAddress));
            
            Log::info("Enregistrement dans la session pour l'IP: " . $ipAddress);
        }

        return $next($request);
    }

     private function isLocal($ipAddress)
     {
         return in_array($ipAddress, ['127.0.0.1', '::1', 'localhost']);
     }
}

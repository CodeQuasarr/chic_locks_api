<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priorité à la langue dans l'URL
        $locale = $request->route('locale', null);

        if (!$locale) {
            // Sinon, on prend la langue dans les en-têtes (si disponible)
            $locale = $request->header('Accept-Language', 'en');
        }

        // Validation de la langue
        if (!in_array($locale, ['en', 'fr', 'es'])) {
            // Langue invalide, on peut retourner une erreur 400 ou une langue par défaut
            abort(400, 'Invalid language');
        }

        // Définir la langue
        App::setLocale($locale);

        return $next($request);
    }
}

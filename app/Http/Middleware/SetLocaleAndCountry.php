<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleAndCountry
{
    public function handle(Request $request, Closure $next)
    {
        // Get available countries and locales from config
        $availableCountries = config('app.available_countries', []);
        $availableLocales = config('app.available_locales', []);
        
        // Handle locale - completely independent of country
        // Priority: URL parameter > Session > Default to 'en'
        $locale = $request->get('locale') ?? Session::get('locale') ?? 'en';
        
        // Validate locale exists in config
        if (!array_key_exists($locale, $availableLocales)) {
            $locale = 'en';
        }
        
        // Handle country - completely independent of locale
        // Priority: URL parameter > Session > Default to 'WW' (Rest of World)
        $country = $request->get('country') ?? Session::get('country') ?? 'WW';
        
        // Validate country exists in config
        if (!array_key_exists($country, $availableCountries)) {
            $country = 'WW';
        }
        
        // Store in session for persistence
        Session::put('locale', $locale);
        Session::put('country', $country);
        
        // Set application locale
        App::setLocale($locale);
        
        // Get country information from database
        $countryInfo = \App\Models\Country::where('iso2', $country)->first();
        $currency = $countryInfo ? $countryInfo->currency_symbol : '$';
        
        // Share data with all views
        view()->share([
            'currentCountry' => $country,
            'currentLocale' => $locale,
            'currentCurrency' => $currency,
            'countryInfo' => $countryInfo,
            'availableCountries' => $availableCountries,
            'availableLocales' => $availableLocales,
        ]);

        return $next($request);
    }
}

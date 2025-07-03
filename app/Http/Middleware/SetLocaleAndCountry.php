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
        // Get country from URL parameter, session, or default
        $country = $request->get('country', Session::get('country', 'US'));
        $locale = $request->get('locale', Session::get('locale'));
        
        // Get available countries and locales
        $availableCountries = config('app.available_countries');
        $availableLocales = config('app.available_locales');
        
        // Validate country
        if (!array_key_exists($country, $availableCountries)) {
            $country = 'US';
        }
        
        // Set locale based on country if not explicitly set
        if (!$locale) {
            $locale = $availableCountries[$country]['locale'] ?? 'en';
        }
        
        // Validate locale
        if (!array_key_exists($locale, $availableLocales)) {
            $locale = 'en';
        }
        
        // Store in session
        Session::put('country', $country);
        Session::put('locale', $locale);
        
        // Set application locale
        App::setLocale($locale);
        
        // Get country information from database
        $countryInfo = \App\Models\Country::where('iso2', $country)->first();
        $currency = $countryInfo ? $countryInfo->currency_symbol : '$';
        
        // Share with views
        view()->share('currentCountry', $country);
        view()->share('currentLocale', $locale);
        view()->share('currentCurrency', $currency);
        view()->share('countryInfo', $countryInfo);
        view()->share('availableCountries', $availableCountries);
        view()->share('availableLocales', $availableLocales);

        return $next($request);
    }
}

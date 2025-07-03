<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\BlogPost;
use App\Models\Country;

echo "Fixing blog post country associations...\n";

$defaultCountry = Country::where('iso2', 'PK')->first();
if (!$defaultCountry) {
    echo "Error: Default country (PK) not found!\n";
    exit(1);
}

echo "Default country: {$defaultCountry->name} (ID: {$defaultCountry->id})\n";

// Update all blog posts to have the default country ID
$updated = BlogPost::whereNull('country_id')->update(['country_id' => $defaultCountry->id]);
echo "Updated {$updated} blog posts with null country_id\n";

// Check for invalid country IDs and update them
$invalidCountryIds = BlogPost::whereNotIn('country_id', Country::pluck('id'))->get();
if ($invalidCountryIds->count() > 0) {
    $updated2 = BlogPost::whereNotIn('country_id', Country::pluck('id'))->update(['country_id' => $defaultCountry->id]);
    echo "Updated {$updated2} blog posts with invalid country_id\n";
}

echo "All blog posts now have valid country associations.\n";

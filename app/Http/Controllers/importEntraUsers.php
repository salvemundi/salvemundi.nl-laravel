<?php
declare(strict_types=1);

use Illuminate\Support\Facades\DB;

// Autoload Laravel
require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Pad naar CSV
$csvPath = base_path('storage/import/entra_users_fixed.csv');

if (!file_exists($csvPath)) {
    die("CSV bestand niet gevonden: $csvPath\n");
}

// Open CSV en importeer
if (($handle = fopen($csvPath, 'r')) !== false) {
    $header = fgetcsv($handle); // eerste rij overslaan

    while (($row = fgetcsv($handle)) !== false) {
        // Check of gebruiker al bestaat op e-mail
        if (!DB::table('users')->where('email', $row[1])->exists()) {
            DB::table('users')->insert([
                'AzureID'    => $row[1], // userPrincipalName
                'DisplayName'=> $row[0],
                'FirstName'  => $row[3],
                'LastName'   => $row[4],
                'email'      => $row[1],
                'visibility' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Gebruiker {$row[1]} toegevoegd\n";
        } else {
            echo "Gebruiker {$row[1]} bestaat al\n";
        }
    }

    fclose($handle);
}

echo "Import klaar!\n";

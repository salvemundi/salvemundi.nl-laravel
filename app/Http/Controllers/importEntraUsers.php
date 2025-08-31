<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// CSV pad
$csvFile = __DIR__.'/storage/import/entra_users_fixed.csv';
if (!file_exists($csvFile)) {
    die("CSV bestand niet gevonden\n");
}

$handle = fopen($csvFile, 'r');
$header = fgetcsv($handle, 0, ',');

while (($data = fgetcsv($handle, 0, ',')) !== false) {
    $user = [
        'DisplayName' => $data[0],
        'email' => $data[1],
        'password' => Hash::make($data[2]),
        'FirstName' => $data[3],
        'LastName' => $data[4],
        'visibility' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ];

    // check of gebruiker al bestaat op e-mail
    if (!DB::table('users')->where('email', $user['email'])->exists()) {
        DB::table('users')->insert($user);
        echo "Gebruiker {$user['email']} toegevoegd\n";
    } else {
        echo "Gebruiker {$user['email']} bestaat al\n";
    }
}

fclose($handle);

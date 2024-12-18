<?php


namespace Database\Seeders;

use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use App\Models\Oefening;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categorieen = ['warming-up', 'techniek', 'tactiek', 'conditie', 'cooling-down', 'keeper', 'theorie'];

        for ($i = 0; $i < 10; $i++) {
            Oefening::create([
                'name' => Lorem::sentence(3),
                'categorie' => json_encode([$categorieen[array_rand($categorieen)]]),
                'onderdeel' => json_encode(['onderdeel' . rand(1, 5)]),
                'leeftijdsgroep' => json_encode(['O' . rand(6, 18)]),
                'duur' => rand(5, 240),
                'minimum_aantal_spelers' => rand(2, 20),
                'benodigdheden' => json_encode(['bal', 'kegel', 'hoepel'][rand(0, 2)]),
                'water_nodig' => (bool)rand(0, 1),
                'omschrijving' => 'Automatisch gegenereerde beschrijving',
                'source' => 'http://example.com',
                'afbeeldingen' => json_encode(['url' => 'http://example.com/image.png']),
            ]);
        }
    }
}
//
//namespace Database\Seeders;
//
//// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
//use App\Models\User;
//use App\Models\Oefening;
//
//class DatabaseSeeder extends Seeder
//{
//    /**
//     * Seed the application's database.
//     */
//    public function run(): void
//    {
//        DB::table('users')->insert([
//            'name' => 'Admin User',
//            'email' => 'admin@example.com',
//            'role' => 'admin',
//            'password' => bcrypt('password'),
//        ]);
//
//
//    Oefening::create([
//        'name' => 'Test Oefening',
//        'categorie' => json_encode(['categorie1']),
//        'onderdeel' => json_encode(['onderdeel1']),
//        'leeftijdsgroep' => json_encode(['O10']),
//        'duur' => 10,
//        'minimum_aantal_spelers' => 2,
//        'benodigdheden' => json_encode(['bal']),
//        'water_nodig' => 1,
//        'omschrijving' => 'Test beschrijving',
//        'source' => 'http://example.com',
//        'afbeeldingen' => json_encode(['url' => 'http://example.com/image.png']),
//    ]);
//
//    $oefeningIDs = [4, 2, 3];
//        $userID = 1;
//        DB::table('training')->insert([
//            'name' => "test",
//            'beschrijving' => "Testen of hij het doet",
//            'enabled' => True,
//            'oefeningIDs' => json_encode($oefeningIDs), // JSON met oefening IDs
//            'userID' => $userID,
//            'ratings' => NULL, // Willekeurige rating
//            'totale_duur' => 15,
//        ]);
//
//        $oefeningIDs2 = [4, 5, ];
//        $userID = 1;
//        DB::table('training')->insert([
//            'name' => "Hete aardappel 2.0",
//            'beschrijving' => "Random teksstttt",
//            'enabled' => True,
//            'oefeningIDs' => json_encode($oefeningIDs2), // JSON met oefening IDs
//            'userID' => $userID,
//            'ratings' => NULL, // Willekeurige rating
//            'totale_duur' => 30,
//        ]);
//
//}
//}

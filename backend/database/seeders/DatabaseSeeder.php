<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Departure;
use App\Models\Supplement;
use App\Models\Page;
use App\Models\Post;
use App\Models\Feature;
use App\Models\Currency;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Currency::firstOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1.0, 'is_active' => true]);
        Currency::firstOrCreate(['code' => 'USD'], ['name' => 'Dollar américain', 'symbol' => '$', 'exchange_rate' => 1.08, 'is_active' => true]);

        $eur = Currency::where('code', 'EUR')->first();

        $this->call(SiteSettingsSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(FeatureSeeder::class);

        $makkah = City::firstOrCreate(['name' => 'Makkah']);
        $medina = City::firstOrCreate(['name' => 'Médine']);

        $valy = Hotel::firstOrCreate(['name' => 'VALY HOTEL'], ['city_id' => $makkah->id, 'rating' => 4, 'distance_to_haram' => '200m', 'description' => 'Hotel moderne à proximité immédiate du Haram.']);
        $sheraton = Hotel::firstOrCreate(['name' => 'SHERATON HOTEL'], ['city_id' => $makkah->id, 'rating' => 5, 'distance_to_haram' => '150m', 'description' => 'Hotel de luxe avec vue sur le Haram.']);
        $voco = Hotel::firstOrCreate(['name' => 'VOCO HOTEL'], ['city_id' => $medina->id, 'rating' => 4, 'distance_to_haram' => '300m', 'description' => 'Hotel confortable proche de Masjid an-Nabawi.']);

        $express = Package::firstOrCreate(['slug' => 'omra-express'], [
            'title' => 'OMRA EXPRESS',
            'duration_days' => 10,
            'base_price_quad' => 7500.00,
            'description' => 'Formule Omra express de 10 jours.',
            'currency_id' => $eur->id,
        ]);

        $confort = Package::firstOrCreate(['slug' => 'omra-confort'], [
            'title' => 'OMRA CONFORT',
            'duration_days' => 14,
            'base_price_quad' => 9500.00,
            'description' => 'Formule Omra confort de 14 jours.',
            'currency_id' => $eur->id,
        ]);

        $depExpress1 = Departure::firstOrCreate(
            ['package_id' => $express->id, 'start_date' => '2026-12-01'],
            [
                'end_date' => '2026-12-10',
                'is_school_holiday' => false,
                'details_formule' => '<p><strong>OMRA EXPRESS</strong> vous propose une Omra exceptionnelle au départ de <strong>France</strong> spécialement conçue pour vous offrir un voyage spirituel alliant sérénité, confort et accompagnement personnalisé.</p><p>Ce séjour de <strong>10 jours</strong> vous permettra d\'accomplir votre Omra dans les meilleures conditions grâce à une organisation complète et une équipe expérimentée.</p>',
                'encadrement' => [
                    ['icon' => 'users', 'title' => 'Guides et imams expérimentés'],
                    ['icon' => 'book', 'title' => 'Cours sur les bienfaits de Médine'],
                    ['icon' => 'mosque', 'title' => 'Visites de Médine'],
                    ['icon' => 'kaaba', 'title' => "Accomplissement de l'Omra"],
                    ['icon' => 'map', 'title' => 'Visites de Makkah'],
                ],
                'transport' => '<p>Nous mettons à votre disposition un service de transfert confortable et sécurisé tout au long de votre séjour.</p>',
                'inclus' => [
                    ['icon' => 'plane', 'text' => 'Vols aller-retour'],
                    ['icon' => 'hotel', 'text' => 'Hôtels proches du Haram'],
                    ['icon' => 'utensils', 'text' => 'Petit déjeuner'],
                    ['icon' => 'users', 'text' => 'Encadrement par guides et imams'],
                    ['icon' => 'bus', 'text' => 'Transferts en bus climatisés'],
                ],
                'non_inclus' => [
                    ['icon' => 'wallet', 'text' => 'Dépenses personnelles'],
                    ['icon' => 'utensils', 'text' => 'Repas non mentionnés'],
                    ['icon' => 'shield', 'text' => 'Assurance voyage'],
                    ['icon' => 'stamp', 'text' => 'Frais de visa'],
                ],
            ]
        );

        $depExpress2 = Departure::firstOrCreate(
            ['package_id' => $express->id, 'start_date' => '2026-12-15'],
            [
                'end_date' => '2026-12-24',
                'is_school_holiday' => true,
                'details_formule' => $depExpress1->details_formule,
                'encadrement' => $depExpress1->encadrement,
                'transport' => $depExpress1->transport,
                'inclus' => $depExpress1->inclus,
                'non_inclus' => $depExpress1->non_inclus,
            ]
        );

        $depExpress3 = Departure::firstOrCreate(
            ['package_id' => $express->id, 'start_date' => '2027-02-01'],
            [
                'end_date' => '2027-02-10',
                'is_school_holiday' => false,
                'details_formule' => $depExpress1->details_formule,
                'encadrement' => $depExpress1->encadrement,
                'transport' => $depExpress1->transport,
                'inclus' => $depExpress1->inclus,
                'non_inclus' => $depExpress1->non_inclus,
            ]
        );

        $depConfort1 = Departure::firstOrCreate(
            ['package_id' => $confort->id, 'start_date' => '2026-12-05'],
            [
                'end_date' => '2026-12-18',
                'is_school_holiday' => false,
                'details_formule' => '<p><strong>OMRA CONFORT</strong> a été conçue pour les pèlerins souhaitant bénéficier d\'un excellent niveau de confort et d\'un emplacement privilégié à proximité des lieux saints.</p><p>Ce séjour de <strong>14 jours</strong> vous permet de vivre pleinement votre expérience spirituelle dans les meilleures conditions.</p>',
                'encadrement' => [
                    ['icon' => 'users', 'title' => 'Guides et imams francophones qualifiés'],
                    ['icon' => 'book', 'title' => 'Cours sur les bienfaits de Médine (en ligne)'],
                    ['icon' => 'mosque', 'title' => 'Visites de Médine'],
                    ['icon' => 'kaaba', 'title' => "Accomplissement de l'Omra"],
                    ['icon' => 'map', 'title' => 'Visites de Makkah'],
                    ['icon' => 'star', 'title' => 'Accomplissement 2ème Omra'],
                ],
                'transport' => '<p>Service de transfert confortable, sécurisé et parfaitement organisé tout au long de votre séjour.</p>',
                'inclus' => [
                    ['icon' => 'plane', 'text' => 'Vols aller-retour'],
                    ['icon' => 'hotel', 'text' => 'Hôtels proches du Haram'],
                    ['icon' => 'utensils', 'text' => 'Petit déjeuner'],
                    ['icon' => 'users', 'text' => 'Encadrement par guides et imams expérimentés'],
                    ['icon' => 'bus', 'text' => 'Transferts en bus climatisés'],
                    ['icon' => 'calendar', 'text' => 'Programme complet (visites, cours & Omra)'],
                ],
                'non_inclus' => [
                    ['icon' => 'wallet', 'text' => 'Dépenses personnelles'],
                    ['icon' => 'utensils', 'text' => 'Repas non mentionnés'],
                    ['icon' => 'shield', 'text' => 'Assurance voyage (recommandée)'],
                    ['icon' => 'stamp', 'text' => 'Frais de visa (supplément)'],
                ],
            ]
        );

        $depConfort2 = Departure::firstOrCreate(
            ['package_id' => $confort->id, 'start_date' => '2027-01-10'],
            [
                'end_date' => '2027-01-23',
                'is_school_holiday' => false,
                'details_formule' => $depConfort1->details_formule,
                'encadrement' => $depConfort1->encadrement,
                'transport' => $depConfort1->transport,
                'inclus' => $depConfort1->inclus,
                'non_inclus' => $depConfort1->non_inclus,
            ]
        );

        foreach ([$depExpress1, $depExpress2, $depExpress3] as $dep) {
            if (!$dep->hotels()->where('hotel_id', $valy->id)->exists()) {
                $dep->hotels()->attach($valy->id, ['nights' => 5]);
            }
            if (!$dep->hotels()->where('hotel_id', $voco->id)->exists()) {
                $dep->hotels()->attach($voco->id, ['nights' => 4]);
            }
        }

        foreach ([$depConfort1, $depConfort2] as $dep) {
            if (!$dep->hotels()->where('hotel_id', $sheraton->id)->exists()) {
                $dep->hotels()->attach($sheraton->id, ['nights' => 7]);
            }
            if (!$dep->hotels()->where('hotel_id', $voco->id)->exists()) {
                $dep->hotels()->attach($voco->id, ['nights' => 6]);
            }
        }

        Supplement::firstOrCreate(['type' => 'triple'], ['amount' => 300.00, 'is_percentage' => false]);
        Supplement::firstOrCreate(['type' => 'double'], ['amount' => 600.00, 'is_percentage' => false]);
        Supplement::firstOrCreate(['type' => 'baby'], ['amount' => 200.00, 'is_percentage' => false]);
        Supplement::firstOrCreate(['type' => 'single'], ['amount' => 1200.00, 'is_percentage' => false]);
        Supplement::firstOrCreate(['type' => 'ecole'], ['amount' => 15.00, 'is_percentage' => true]);

        Page::firstOrCreate(['slug' => 'cgv'], ['title' => 'Conditions Générales de Vente', 'content' => "<h2>CGV - Conditions Générales de Vente</h2><p>Les présentes conditions générales de vente régissent les relations contractuelles entre l'agence Omra et ses clients. Tout paiement effectué vaut acceptation des présentes conditions.</p><h3>Réservation et paiement</h3><p>Un acompte de 30% est demandé à la réservation. Le solde doit être réglé au plus tard 30 jours avant le départ.</p><h3>Annulation</h3><p>Toute annulation doit être notifiée par écrit. Des frais d'annulation peuvent s'appliquer selon le délai.</p>", 'is_published' => true]);
        Page::firstOrCreate(['slug' => 'cgu'], ['title' => "Conditions Générales d'Utilisation", 'content' => "<h2>CGU - Conditions Générales d'Utilisation</h2><p>Ce site est édité par l'agence Omra. En utilisant ce site, vous acceptez les présentes conditions d'utilisation.</p><h3>Propriété intellectuelle</h3><p>Tout le contenu du site est protégé par le droit d'auteur.</p>", 'is_published' => true]);
        Page::firstOrCreate(['slug' => 'mentions-legales'], ['title' => 'Mentions Légales', 'content' => "<h2>Mentions Légales</h2><p><strong>Éditeur du site :</strong> Agence Omra – SAS au capital de 10 000€</p><p><strong>Contact :</strong> contact@omra.fr</p><p><strong>Hébergeur :</strong>...</p>", 'is_published' => true]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Omra pendant le Ramadan 2027',
                'slug' => 'ramadan-2027',
                'excerpt' => 'Préparez votre séjour pour le mois sacré du Ramadan 2027 à Makkah et Médine.',
                'content' => '<p>Le Ramadan 2027 est une période exceptionnelle pour effectuer la Omra. Les récompenses spirituelles sont multipliées et l\'ambiance dans les deux saintes mosquées est unique.</p><p>Nous proposons des départs spéciaux pour le Ramadan 2027 avec des formules adaptées pour vivre pleinement cette expérience spirituelle.</p><p>Réservez dès maintenant pour garantir votre place.</p>',
                'is_published' => true,
                'position' => 1,
            ],
            [
                'title' => 'Conseils pour votre premier voyage Omra',
                'slug' => 'conseils-voyage',
                'excerpt' => 'Tout ce qu\'il faut savoir avant de partir pour la Omra.',
                'content' => '<p>Vous préparez votre premier voyage pour la Omra ? Voici quelques conseils essentiels :</p><ul><li>Prévoyez des vêtements confortables et adaptés au climat</li><li>Emportez une trousse de premiers soins</li><li>Restez hydraté, surtout pendant les saisons chaudes</li><li>Respectez les consignes de votre guide</li></ul>',
                'is_published' => true,
                'position' => 2,
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}

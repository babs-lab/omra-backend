<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Sarah M.', 'city' => 'Lyon', 'content' => 'Organisation parfaite du début à la fin.', 'rating' => 5, 'position' => 1, 'is_active' => true],
            ['name' => 'Yacine B.', 'city' => 'Marseille', 'content' => 'Une équipe au top, très à l\'écoute et disponible.', 'rating' => 5, 'position' => 2, 'is_active' => true],
            ['name' => 'Amina K.', 'city' => 'Marseille', 'content' => 'Voyage spirituel inoubliable, qu\'Allah vous récompense.', 'rating' => 5, 'position' => 3, 'is_active' => true],
            ['name' => 'Fatima Z.', 'city' => 'Paris', 'content' => 'Une Omra organisée avec beaucoup de professionnalisme.', 'rating' => 4, 'position' => 4, 'is_active' => true],
            ['name' => 'Mohamed A.', 'city' => 'Lille', 'content' => 'Une expérience sereine et enrichissante que nous recommandons sans hésitation.', 'rating' => 5, 'position' => 5, 'is_active' => true],
            ['name' => 'Karim H.', 'city' => 'Toulouse', 'content' => 'Accompagnement exceptionnel, des hôtels parfaitement situés et un séjour béni.', 'rating' => 5, 'position' => 6, 'is_active' => true],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }
    }
}

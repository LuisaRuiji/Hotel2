<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Spa & Wellness
            [
                'name' => 'Swedish Massage',
                'description' => '60-minute relaxing full body massage using long, flowing strokes to promote relaxation and well-being.',
                'price' => 120.00,
                'category' => 'spa',
                'duration' => '60 minutes',
                'is_available' => true,
                'image_url' => 'services/spa-massage.jpg'
            ],
            [
                'name' => 'Deep Tissue Massage',
                'description' => '90-minute therapeutic massage targeting deep muscle tension and chronic pain areas.',
                'price' => 150.00,
                'category' => 'spa',
                'duration' => '90 minutes',
                'is_available' => true,
                'image_url' => 'services/deep-tissue.jpg'
            ],
            
            // Dining & Restaurant
            [
                'name' => 'Private Dining Experience',
                'description' => 'Exclusive 5-course dinner prepared by our executive chef in a private setting.',
                'price' => 200.00,
                'category' => 'dining',
                'duration' => '2-3 hours',
                'is_available' => true,
                'image_url' => 'services/private-dining.jpg'
            ],
            [
                'name' => 'In-Room Breakfast',
                'description' => 'Gourmet breakfast served in the comfort of your room.',
                'price' => 45.00,
                'category' => 'dining',
                'duration' => '45 minutes',
                'is_available' => true,
                'image_url' => 'services/room-breakfast.jpg'
            ],

            // Laundry
            [
                'name' => 'Express Laundry',
                'description' => 'Same-day laundry and pressing service.',
                'price' => 50.00,
                'category' => 'laundry',
                'duration' => '6 hours',
                'is_available' => true,
                'image_url' => 'services/express-laundry.jpg'
            ],
            [
                'name' => 'Dry Cleaning',
                'description' => 'Professional dry cleaning service with 24-hour turnaround.',
                'price' => 35.00,
                'category' => 'laundry',
                'duration' => '24 hours',
                'is_available' => true,
                'image_url' => 'services/dry-cleaning.jpg'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 
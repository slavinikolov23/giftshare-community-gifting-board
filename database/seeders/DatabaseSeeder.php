<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Item;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Categories (idempotent)
        $categories = [
            'Книги',
            'Електроника',
            'Дрехи',
            'Мебели',
            'Спорт',
            'Играчки',
            'Домакинство',
            'Автомобили',
            'Инструменти',
            'Други',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        $categoryIds = Category::pluck('id')->toArray();

        // Create Users (20 random users)
        $users = User::factory(20)->create();

        // Create / ensure Test User (idempotent)
        $testUser = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('test_password123!'),
            ]
        );

        if (! $users->contains('id', $testUser->id)) {
            $users->push($testUser);
        }

        // Create Items (80 items)
        $items = Item::factory(80)->create([
            'category_id' => fn() => fake()->randomElement($categoryIds),
            'user_id' => fn() => $users->random()->id,
        ]);

        // Create Comments (for 60% of items, 1-5 comments each)
        foreach ($items->random((int)($items->count() * 0.6)) as $item) {
            $commentCount = rand(1, 5);
            Comment::factory($commentCount)->create([
                'item_id' => $item->id,
                'user_id' => fn() => $users->random()->id,
            ]);
        }

        // Create Votes (for all items, 0-15 votes each)
        foreach ($items as $item) {
            $voteCount = rand(0, 15);
            $votedUsers = $users->random(min($voteCount, $users->count()));
            
            foreach ($votedUsers as $user) {
                Vote::create([
                    'item_id' => $item->id,
                    'user_id' => $user->id,
                    'value' => fake()->randomElement([1, -1]),
                ]);
            }
        }

        // Note: Images would need actual files. For now, we'll skip them in seeder
        // In production, you would copy sample images to storage/app/public/images
        // and create Image records pointing to them

        $this->command->info('Database seeded successfully!');
        $this->command->info('Test user: admin@test.com / test_password123!');
    }
}

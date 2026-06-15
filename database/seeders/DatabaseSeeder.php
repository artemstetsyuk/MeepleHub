<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Викликаємо ваш окремий сідер категорій
        $this->call([
            CategorySeeder::class,
        ]);

        // Тут у майбутньому можна додати інші сідери (наприклад, UserSeeder чи GameSeeder)
    }
}
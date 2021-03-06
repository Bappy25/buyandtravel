<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        	// Seed the countries
		$this->call('CountriesSeeder');
		$this->command->info('Seeded the countries!');

            // Seed the product types
        $this->call(ProductTypesSeeder::class);
        $this->command->info('Seeded the product types!');

            // Seed the users
        $this->call(UsersSeeder::class);
        $this->command->info('Seeded the users!');

            // Seed the notifications
        $this->call(NotificationSeeder::class);
        $this->command->info('Seeded the notifications!');

            // Seed the message subjects
        $this->call(MessageSubjectsTableSeeder::class);
        $this->command->info('Seeded the message subjects!');

            // Seed the messages
        $this->call(MessagesTableSeeder::class);
        $this->command->info('Seeded the messages!');

            // Seed the message participants
        $this->call(MessageParticipantsTableSeeder::class);
        $this->command->info('Seeded the message participants!');

            // Seed the Orders
        $this->call(OrdersTableSeeder::class);
        $this->command->info('Seeded the orders!');

            // Seed the travel schedules
        $this->call('TravelSchedulesTableSeeder');
        $this->command->info('Seeded the travel schedules!');

            // Seed my own data
        /*$this->call('MyUserSeeder');
        $this->command->info('Seeded your user data!');*/
    }
}

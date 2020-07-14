<?php

use App\Libraries\User\CompanyLibrary;
use App\Libraries\User\UserLibrary;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    private int $noOfSharedUsers = 3;
    private int $noOfOwnerUsers = 2;

    private array $sharedUsers = [];
    private array $ownerUsers = [];

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @param \App\Libraries\User\UserLibrary $userLibrary
     * @param \App\Libraries\User\CompanyLibrary $companyLibrary
     *
     * @return void
     * @throws \Exception
     */
    public function run(UserLibrary $userLibrary, CompanyLibrary $companyLibrary)
    {
        for ($i = 0; $i < $this->noOfSharedUsers; $i++) {
            $this->sharedUsers[] = $userLibrary->createNewUser(
                $this->faker->name,
                $this->faker->userName,
                $this->faker->email,
                $this->faker->password
            );
        }

        for ($i = 0; $i < $this->noOfOwnerUsers; $i++) {
            $ownerUser = $userLibrary->createNewUser(
                $this->faker->name,
                $this->faker->userName,
                $this->faker->email,
                $this->faker->password
            );

            // add extra company
            $newCompany = $companyLibrary->setupNewCompany(
                $ownerUser,
                $this->faker->company
            );

            foreach ($this->sharedUsers as $sharedUser) {
                $newCompany->assignUser($sharedUser);
            }
        }
    }
}

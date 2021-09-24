<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Customer;
use App\Entity\Invoice;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($c = 0; $c < 30; $c++) {
            $customer = new Customer();
            $customer
                    ->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setEmail($faker->company())
                    ->setCompany($faker->email());  

                $manager->persist($customer);

            for ($i = 0; $i < mt_rand(3,10); $i++) {
                $invoice = new Invoice();
                $invoice
                    ->setAmount($faker->randomDigit())
                    ->setSentAt($faker->dateTimeBetween('-6 mounths'))
                    ->setStatus($faker->randomElement(['SENT','PAID','CANCEL']))
                    ->setCustomer($customer);  
                    
                $manager->persist($invoice);
            }
        }
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Customer;
use App\Entity\User;
use App\Entity\Invoice;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface 
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
 
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
       

        for ($u = 0; $u < 10; $u++) {
            $chrono = 1;
            $user = new User(); 

            $hash = $this->encoder->encodePassword($user, "123456");

            $user   
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setEmail($faker->company())
                ->setPassword($hash);

                $manager->persist($user);

            for ($c = 0; $c < mt_rand(3,8); $c++) {
                $customer = new Customer();
                $customer
                        ->setFirstname($faker->firstname())
                        ->setLastname($faker->lastname())
                        ->setEmail($faker->company())
                        ->setCompany($faker->email())
                        ->setUser($user);  

                    $manager->persist($customer);

                for ($i = 0; $i < mt_rand(3,10); $i++) {
                    $invoice = new Invoice();
                    $invoice
                        ->setAmount($faker->randomDigit())
                        ->setSentAt($faker->dateTimeBetween('-6 mounths'))
                        ->setStatus($faker->randomElement(['SENT','PAID','CANCEL']))
                        ->setCustomer($customer)  
                        ->setChrono($chrono);  
                        
                    $chrono = $chrono +1;
                    $manager->persist($invoice);
                }
            }
        }

        $manager->flush();
    }
}

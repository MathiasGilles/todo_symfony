<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=0; $i < 5; $i++) { 
            $user = new User();
            $user->setFirstName($faker->name)
                 ->setLastName($faker->name)
                 ->setEmail($faker->email)
                 ->setPassword("password")
                 ->setCreatedAt(new \DateTime);
            
            for ($e=0; $e < 5; $e++) { 
                $task = new Task();
                $unixTimestap = '1461067200';
                $task->setName($faker->text)
                     ->setDeadLine($faker->dateTime);
                if($e % 2 == 1){
                    $task->setState(true);
                }
                else{
                    $task->setState(false);
                }
                $manager->persist($task);
                $user->addTask($task); 
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}

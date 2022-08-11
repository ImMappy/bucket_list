<?php

namespace App\DataFixtures;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
       for($i = 0; $i < 150; $i++){
           $personne[$i] = new Personne();
           $personne[$i]->setName($faker->name);
           $personne[$i]->setAge(mt_rand(10,75));
           $manager->persist($personne[$i]);

       }
       $manager->flush();
    }
}

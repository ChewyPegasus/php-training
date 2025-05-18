<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;
use Faker\Factory;

require_once __DIR__ . "/../../vendor/autoload.php";

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $book = new Book();
            $book->setTitle($faker->sentence(mt_rand(2, 6)));
            $book->setAuthor($faker->name);
            $book->setDescription($faker->text(100));
            $book->setImageUrl($faker->url());
            $manager->persist($book);
        }

        $manager->flush();
    }
}

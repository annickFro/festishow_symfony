<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Style;

class StyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 20; $i++) {
            $style = new Style();
            $style->setName('Concert - ' . ucfirst($faker->word()));

            $manager->persist($style);
            $this->addReference('style_' . $i, $style);
        }
        $manager->flush();
    }
}

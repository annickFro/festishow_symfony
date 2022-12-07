<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    const MINUTES = [
        '0', 
        '30'
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 5; $i++) {
            $event = new Event();
            if ($i % 2 == 0) {
                $event->setName(strtoupper($faker->firstName() . ' ' . $faker->lastName()));
            } else {
                $event->setName(strtoupper($faker->company()));
            }
            // possible times : 15:00, 15:30, ... 20:30
            $hour = rand(15,20);
            $minutes = self::MINUTES[rand(0,1)] ; 
            $event->setDatetime($faker->dateTimeBetween('0 week', '+52 week')->setTime($hour, $minutes)); 
            $event->setPlace($faker->streetAddress());
            $event->setCity(strtoupper($faker->city()));
            $event->setDescription($faker->paragraphs(2, true));
            $event->setImage($faker->imageUrl(640, 480, 'Music', true));
            $event->setStyle($this->getReference('style_' . $faker->numberBetween(0, 19)));
            $manager->persist($event);
            $this->addReference('event_' . $i, $event);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           StyleFixtures::class,
        ];
    }
}

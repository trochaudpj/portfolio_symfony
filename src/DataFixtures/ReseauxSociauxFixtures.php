<?php

namespace App\DataFixtures;

use App\Entity\Social;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReseauxSociauxFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = ['Pinterest', 'Facebook', 'Instagram', 'Twitter', 'Google', 'Github', 'Discord', 'Slack', 'Linkedin'];

        foreach ($names as $name) {
            $entity = new Social();
            $entity->setName($name);
            $entity->setStatus(false);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}

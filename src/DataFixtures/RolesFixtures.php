<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RolesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roles = [
            'ROLE_DEV' => 'Développeur',
            'ROLE_ADMIN' => 'Administrateur',
        ];

        foreach ($roles as $key => $value) {
            $entity = new Roles();
            $entity->setRole($key);
            $entity->setTitre($value);
            $entity->setStatus(true);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}

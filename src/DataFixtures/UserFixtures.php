<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setEmail('admin@example.com');
        $user->setFirstName('John'); // <-- Obligatoire !
        $user->setLastName('Doe');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$d5P.hq3Hs3tHcBD058pHzOK3xRtuTFyqZiqGhnlieaT7L2ahW663u'); // pas encore hashé
        $user->setUpdatedAt(new \DateTimeImmutable());

        $manager->persist($user);
        $manager->flush();
    }
}

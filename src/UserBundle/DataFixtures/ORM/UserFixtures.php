<?php

namespace UserBundle\DataFixtures\Doctrine\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Description of UserFixtures
 *
 * @author Sébastien
 */
class UserFixtures implements FixtureInterface
{
    

    public function load(ObjectManager $manager) {


        $userManager = $this->container->get('fos_user.user_manager'); // problème pour réccuperer le serviceContainer, le tuto parle de ContainerAwareInterface ???

        $user = $userManager->createUser();

        $user
            ->setUsername('JD')
            ->setPrenom('John')
            ->setNom('Doe')
            ->setEmail('john.doe@example.com')
            ->setFirstLogin(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'))
            ->setEnabled(true);

        $user->setPlainPassword('somepass');

        $manager->persist($user);

        $manager->flush();

        // Equivalent à :

//        $encoder = $this->container
//                ->get('security.encoder_factory')
//                ->getEncoder($user)
//            ;
//        $user->setPassword($encoder->encodePassword('somepass', $user->getSalt()));


    }
}

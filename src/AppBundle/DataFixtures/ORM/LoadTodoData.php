<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Todo;


class LoadTodoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task1 = new Todo();
        $task1->setDescription('This is my first task');
        $task1->setIsComplete(false);

        $manager->persist($task1);

        $task2 = new Todo();
        $task2->setDescription('This is my second and coolest task');
        $task2->setIsComplete(true);

        $manager->persist($task2);

        $manager->flush();
    }
}
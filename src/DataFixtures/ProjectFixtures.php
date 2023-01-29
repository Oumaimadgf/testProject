<?php


namespace App\DataFixtures;


use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

            $project = new Project();
            $project->setTitle('projet1');
            $project->setDescription('test project');
            $project->setNumber(6);
            $project->setStatus('done');

        $project2 = new Project();
        $project2->setTitle('projet2');
        $project2->setDescription('test project2');
        $project2->setNumber(4);
        $project2->setStatus('progress');

        $project3 = new Project();
        $project3->setTitle('projet3');
        $project3->setDescription('test project3');
        $project3->setNumber(2);
        $project3->setStatus('blocked');

            $manager->persist($project);
            $manager->persist($project2);
            $manager->persist($project3);
            $manager->flush();





    }
}
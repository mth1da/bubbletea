<?php

namespace App\DataFixtures;

use App\Entity\Popping;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PoppingFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger ){}

    public function load(ObjectManager $manager): void
    {
        $tapioca = new Popping();
        $tapioca->setName('Tapioca');
        $tapioca->setSlug($this->slugger->slug($tapioca->getName())->lower());
        $manager->persist($tapioca);

        $litchi = new Popping();
        $litchi->setName('Litchi');
        $litchi->setSlug($this->slugger->slug($litchi->getName())->lower());
        $manager->persist($litchi);

        $peche = new Popping();
        $peche->setName('Pêche');
        $peche->setSlug($this->slugger->slug($peche->getName())->lower());
        $manager->persist($peche);

        $mangue = new Popping();
        $mangue->setName('Mangue');
        $mangue->setSlug($this->slugger->slug($mangue->getName())->lower());
        $manager->persist($mangue);

        $framboise = new Popping();
        $framboise->setName('Framboise');
        $framboise->setSlug($this->slugger->slug($framboise->getName())->lower());
        $manager->persist($framboise);

        $passion = new Popping();
        $passion->setName('Passion');
        $passion->setSlug($this->slugger->slug($passion->getName())->lower());
        $manager->persist($passion);

        $this->addReference('tapioca', $tapioca);
        $this->addReference('litchi', $litchi);
        $this->addReference('peche', $peche);
        $this->addReference('mangue', $mangue);
        $this->addReference('framboise', $framboise);
        $this->addReference('passion', $passion);

        $manager->flush();
    }
}

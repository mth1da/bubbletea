<?php

namespace App\DataFixtures;

use App\Entity\Drink;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DrinkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jasmin = new Drink();
        $jasmin->setName('Thé');
        $jasmin->setFlavour('Jasmin');
        $jasmin->setPrice(5);
        $jasmin->setSugarQuantity(1);
        $jasmin->setIsOnMenu(True);
        $jasmin->setIsPartOfMenu(True);
        $jasmin->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($jasmin);

        $fraise = new Drink();
        $fraise->setName('Thé');
        $fraise->setFlavour('Fraise');
        $fraise->setPrice(5);
        $fraise->setSugarQuantity(1);
        $fraise->setIsOnMenu(True);
        $fraise->setIsPartOfMenu(True);
        $fraise->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($fraise);

        $rose = new Drink();
        $rose->setName('Thé');
        $rose->setFlavour('Rose');
        $rose->setPrice(5);
        $rose->setSugarQuantity(1);
        $rose->setIsOnMenu(True);
        $rose->setIsPartOfMenu(True);
        $rose->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($rose);

        $litchi = new Drink();
        $litchi->setName('Thé');
        $litchi->setFlavour('Litchi');
        $litchi->setPrice(5);
        $litchi->setSugarQuantity(1);
        $litchi->setIsOnMenu(True);
        $litchi->setIsPartOfMenu(True);
        $litchi->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($litchi);

        $mangue = new Drink();
        $mangue->setName('Thé');
        $mangue->setFlavour('Mangue');
        $mangue->setPrice(5);
        $mangue->setSugarQuantity(1);
        $mangue->setIsOnMenu(True);
        $mangue->setIsPartOfMenu(True);
        $mangue->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($mangue);

        $peche = new Drink();
        $peche->setName('Thé');
        $peche->setFlavour('Pêche');
        $peche->setPrice(5);
        $peche->setSugarQuantity(1);
        $peche->setIsOnMenu(True);
        $peche->setIsPartOfMenu(True);
        $peche->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($peche);

        $pasteque = new Drink();
        $pasteque->setName('Thé');
        $pasteque->setFlavour('Pastèque');
        $pasteque->setPrice(5);
        $pasteque->setSugarQuantity(1);
        $pasteque->setIsOnMenu(False);
        $pasteque->setIsPartOfMenu(True);
        $pasteque->addDrinkPopping($this->getReference("tapioca"));
        $manager->persist($pasteque);

        $manager->flush();
    }

    //drink fixtures dépend de popping fixtures
    public function getDependencies():array
    {
        return[PoppingFixtures::class];
    }
}

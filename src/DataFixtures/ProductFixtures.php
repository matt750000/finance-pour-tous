<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Produit 1
        $product1 = new Product();
        $product1->setName('Guide de l\'Investissement pour Débutants');
        $product1->setDescription('Un e-book complet pour apprendre à investir en bourse, même sans expérience.');
        $product1->setPrice(19.99);
        $product1->setCategory($this->getReference(CategoryFixtures::CAT_INVESTISSEMENT, Category::class));
        $product1->setImage('test1.png');
        $product1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($product1);

        // Produit 2
        $product2 = new Product();
        $product2->setName('Cours Vidéo : Analyse Boursière');
        $product2->setDescription('Une formation vidéo pour maîtriser les bases de l\'analyse technique.');
        $product2->setPrice(49.99);
        $product2->setCategory($this->getReference(CategoryFixtures::CAT_ANALYSE_BOURSIERE, Category::class));
        $product2->setImage('test2.png');
        $product1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($product2);

        // Produit 3
        $product3 = new Product();
        $product3->setName('Modèle Excel : Suivi de Budget');
        $product3->setDescription('Un modèle de feuille de calcul pour gérer vos dépenses mensuelles efficacement.');
        $product3->setPrice(9.99);
        $product3->setCategory($this->getReference(CategoryFixtures::CAT_MODELES, Category::class));
        $product3->setImage('test2.png');
        $product1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($product3);

        // Produit 4
        $product4 = new Product();
        $product4->setName('Newsletter Premium - Marchés Financiers');
        $product4->setDescription('Abonnement mensuel à notre newsletter exclusive avec analyses et prévisions des marchés.');
        $product4->setPrice(14.99);
        $product4->setCategory($this->getReference(CategoryFixtures::CAT_PREMIUM, Category::class));
        $product4->setImage('test1.png');
        $product1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($product4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

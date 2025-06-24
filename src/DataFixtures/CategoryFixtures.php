<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    // 🔐 Constantes pour les références
    public const CAT_INVESTISSEMENT = 'cat_investissement';
    public const CAT_BUDGET = 'cat_budget';
    public const CAT_CRYPTO = 'cat_crypto';
    public const CAT_ANALYSE_BOURSIERE = 'cat_analyse_boursiere';
    public const CAT_MODELES = 'cat_modeles';
    public const CAT_PREMIUM = 'cat_premium';

    public function load(ObjectManager $manager): void
     {
        // Catégorie principale : E-books
        $ebooks = new Category();
        $ebooks->setName('E-books');
        $manager->persist($ebooks);
    
        // Sous-catégories pour E-books
        $investissement = new Category();
        $investissement->setName('Investissement');
        $investissement->setParent($ebooks);
        $manager->persist($investissement);
        $this->addReference(self::CAT_INVESTISSEMENT, $investissement);

        $budget = new Category();
        $budget->setName('Gestion de budget');
        $budget->setParent($ebooks);
        $manager->persist($budget);
        $this->addReference(self::CAT_BUDGET, $budget);

        $crypto = new Category();
        $crypto->setName('Cryptomonnaie');
        $crypto->setParent($ebooks);
        $manager->persist($crypto);
        $this->addReference(self::CAT_CRYPTO, $crypto);

        // Catégorie principale : Formations vidéo
        $videos = new Category();
        $videos->setName('Formations vidéo');
        $manager->persist($videos);

        // Sous-catégorie pour Formations vidéo
        $analyseBoursiere = new Category();
        $analyseBoursiere->setName('Analyse boursière pour débutants');
        $analyseBoursiere->setParent($videos);
        $manager->persist($analyseBoursiere);
        $this->addReference(self::CAT_ANALYSE_BOURSIERE, $analyseBoursiere);

        // Catégorie : Modèles de feuilles de calcul
        $modeles = new Category();
        $modeles->setName('Modèles de feuilles de calcul');
        $manager->persist($modeles);
        $this->addReference(self::CAT_MODELES, $modeles);

        // Catégorie : Accès à des analyses premium
        $premium = new Category();
        $premium->setName('Accès à des analyses ou newsletters premium');
        $manager->persist($premium);
        $this->addReference(self::CAT_PREMIUM, $premium);

        $manager->flush();
     }
}

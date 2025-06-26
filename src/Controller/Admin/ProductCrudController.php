<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield TextEditorField::new('description', 'Description');
        yield NumberField::new('price', 'Prix');
        yield AssociationField::new('category', 'Catégorie');

        yield Field::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setLabel('Image')
            ->onlyOnForms();

        yield ImageField::new('image')
            ->setBasePath('/images/products')
            ->setLabel('Image')
            ->onlyOnIndex();
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield NumberField::new('totalPrice', 'Prix total');
        yield DateTimeField::new('createdAt', 'Date de création');
        yield AssociationField::new('user', 'Utilisateur');
        yield AssociationField::new('orderItems', 'Articles de la commande');
    }
}

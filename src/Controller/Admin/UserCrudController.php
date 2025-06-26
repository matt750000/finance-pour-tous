<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email', 'Email');
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom de famille');
        yield ArrayField::new('roles', 'Rôles');
        yield DateTimeField::new('updatedAt', 'Mis à jour le');
        yield TextField::new('plainPassword')
            ->setFormType(\Symfony\Component\Form\Extension\Core\Type\PasswordType::class)
            ->onlyOnForms()
            ->setHelp('Laissez vide pour conserver le mot de passe actuel');
    }
}

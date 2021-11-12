<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            //s'user_id',
            TextField::new('nom'),
            TextField::new('prenom'),
            DateTimeField::new('birthday'),
            TextField::new('adresse'),
            TextField::new('cp'),
            TextField::new('ville'),
            TextField::new('phone'),
        ];
    }
   
}

<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use App\Entity\Roles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RolesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Roles::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('role'),
            TextField::new('titre'),
            //ChoiceField::new('status'),
        ];
    }
   
}

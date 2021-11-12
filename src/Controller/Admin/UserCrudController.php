<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            TextField::new('pseudo'),
            TextField::new('email'),
            'is_active',
            'is_banned',
            'is_dead',
            DateTimeField::new('lastvisit'),
            DateTimeField::new('register_at'),
            TextField::new('locale'),
            TextField::new('timezone'),
        ];
    }
   
}

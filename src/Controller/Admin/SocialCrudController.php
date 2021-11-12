<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Entity\social;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SocialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Social::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            TextField::new('name'),
            UrlField::new('url'),
            'status',
        ];
    }
    
}

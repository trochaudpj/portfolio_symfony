<?php

namespace App\Controller\Admin;

use App\Entity\ResetPasswordRequest;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ResetPasswordRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ResetPasswordRequest::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'user_id',
            'selector',
            'hashed_token',
            DateTimeField::new('requested_at'),
            DateTimeField::new('expires_at'),
        ];
    }
    
}

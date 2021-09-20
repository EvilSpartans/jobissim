<?php

namespace App\Controller\Admin;

use App\Entity\SubCategories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubCategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategories::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ProductType extends AbstractType
{
    public function buildForm($builder, $options)
    {
        $builder
            ->add('name',null,array('label' => 'Nom'))
            ->add('price',null,array('label' => 'Prix'))
            ->add('type',null,array('label' => 'Type'));
    }
}
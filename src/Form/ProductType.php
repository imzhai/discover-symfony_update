<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
class ProductType extends AbstractType
{
    /**
     * La méthode buildForm sera appellée par Symfony. Elle va nous permettre
     * de configurer les champs de notre formulaire.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
        ;
    }
}
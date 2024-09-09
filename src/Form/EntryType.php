<?php

namespace App\Form;

use App\Entity\Entry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('task', TextType::class, ['label' => false, 'attr' => [ 'placeholder' => 'Task' ]])
            ->add('hours_planned', null, ['label' => false, 'attr' => [ 'placeholder' => '0.0' ]])
            ->add('hours_actual', null, ['label' => false, 'attr' => [ 'placeholder' => '0.0' ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entry::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Submission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SubmissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('comments')
            ->add('entries', CollectionType::class, [
                'entry_type' => EntryType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
//            ->add('save', SubmitType::class, ['label' => 'Create Task'])
        ;
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data['entries'] = array_values($data['entries']);
        $event->setData($data);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Submission::class,
        ]);
    }
}

<?php
namespace CarDealerBundle\Form;

use CarDealerBundle\Entity\Supplier;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', TextType::class)
            ->add('quantity', TextType::class);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $part = $event -> getData();
            $form = $event -> getForm();

        if (!$part || null === $part->getId()) {
            $form
                ->add('name', TextType::class)
                ->add('supplier', EntityType::class, [
                    'class' => Supplier::class,
                    'choice_label' => 'name'
                ]);
        }});
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class'
        => 'CarDealerBundle\Entity\Part',));
    }

    public function getName()
    {
        return 'carDealer_bundle_part_type';
    }

}
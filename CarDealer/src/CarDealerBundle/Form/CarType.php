<?php


namespace CarDealerBundle\Form;

use CarDealerBundle\Entity\Part;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('make', TextType::class)
            ->add('model', TextType::class)
            ->add('travelledDistance', TextType::class)
            ->add('parts', EntityType::class, [
                'class' => Part::class,
                'choice_label' => 'name',
                'multiple' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class'
        => 'CarDealerBundle\Entity\Car',));
    }

    public function getName()
    {
        return 'carDealer_bundle_car_type';
    }

}
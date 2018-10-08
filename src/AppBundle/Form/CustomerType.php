<?php

namespace AppBundle\Form;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $trait_options = $options['trait_options'];
        /** @var Customer $customer */
        $customer = $trait_options['customer'];
        /** @var Cart $cart */
        $cart = $trait_options['cart'];

        $builder
            ->add('firstname', TextType::class, [
                'required' => false,
	            'label' => 'Jméno',
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
	            'label' => 'Příjmení',
            ])
            ->add('email', TextType::class, [
                'required' => false,
	            'label' => 'E-mail',
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
	            'label' => 'Telefonní číslo',
            ])
        ;

        if($cart->getTakeOverType()->getSlug() === 'necham-si-dovezt'){
            $builder->add('address', AddressType::class, [
            	'label' => 'Adresa doručení'
            ]);
        }
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Customer',
            'trait_options' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_customer';
    }


}

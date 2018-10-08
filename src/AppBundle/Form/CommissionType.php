<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommissionType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

	    $trait_options = $options['trait_options'];
	    /** @var \AppBundle\Entity\Commission $commission */
	    $commission = $trait_options['commission'];

	    $customer = $commission->getCustomer();
	    $cart = $commission->getCart();


        $builder
	        ->add('customer', CustomerType::class, [
		        'label' => false,
		        'trait_options' => [
		        	'customer' => $customer,
			        'cart' => $cart,
		        ]
	        ])
            ->add('cart', CartType::class, [
	            'label' => false,
	            'trait_options' => [
		            'customer' => $customer,
		            'cart' => $cart,
	            ]
            ])
	        ->add('paymentMethod', EntityType::class, [
		        'required' => true,
		        'label' => 'Způsob platby',
		        'class' => 'AppBundle\Entity\PaymentMethod',
		        'choices' => $commission->getCart()->getTakeOverType()->getPaymentMethods(),
		        'choice_label' => 'name',
	        ])
	        ->add('comment', TextareaType::class, [
		        'label' => 'Poznámka (nepovinné)',
		        'required' => false
	        ])
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commission',
            'trait_options' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commission';
    }


}

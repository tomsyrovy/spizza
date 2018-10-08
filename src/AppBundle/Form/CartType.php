<?php

namespace AppBundle\Form;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

	    $trait_options = $options['trait_options'];
	    /** @var \AppBundle\Entity\Cart $cart */
	    $cart = $trait_options['cart'];

	    if($cart->getTakeOverType()->getSlug() === 'vezmu-si-na-stanku'){

	        $builder
	            ->add('localBusiness', EntityType::class, [
	                'required' => true,
		            'label' => 'Stánek pro vyzvednutí',
		            'class' => 'AppBundle\Entity\LocalBusiness',
		            'query_builder' => function (EntityRepository $er) {
			            return $er->createQueryBuilder('lb')
			                      ->orderBy('lb.name', 'ASC');
		            },
		            'choice_label' => 'fullName',
	            ])
	        ;

	    }
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cart',
            'trait_options' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cart';
    }


}

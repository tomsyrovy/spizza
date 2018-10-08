<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends AbstractAdmin
{



    public function createQuery($context = 'list'){

        $proxyQuery = parent::createQuery($context);
        //Default alias is "o"
        $proxyQuery->leftJoin('o.productBase', 'productBase');
        $proxyQuery->leftJoin('o.productVariant', 'productVariant');
        $proxyQuery->leftJoin('o.productTakeoverType', 'productTakeoverType');
        $proxyQuery->addOrderBy('productBase.position', 'ASC');
        $proxyQuery->addOrderBy('productVariant.position', 'ASC');
        $proxyQuery->addOrderBy('productTakeoverType.position', 'ASC');

        return $proxyQuery;

    }

    protected $datagridValues = array(
        '_page' => 1,
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('productBase.name', null, [
                'label' => 'Základní produkt',
            ])
            ->add('productVariant.name', null, [
                'label' => 'Varianta produktu'
            ])
            ->add('productTakeoverType.name', null, [
                'label' => 'Typ převzetí'
            ])
            ->add('price', null, [
                'label' => 'Cena',
                'required' => false,
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('productBase.name', 'text', [
                'label' => 'Základní produkt'
            ])
            ->add('productVariant.name', 'text', [
                'label' => 'Varianta produktu'
            ])
            ->add('productTakeoverType.name', 'text', [
                'label' => 'Typ převzetí'
            ])
            ->add('price', 'number', [
                'label' => 'Cena',
                'required' => false,
            ])
            ->add('_action', null, array(
                'label' => 'Akce',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('productBase', 'entity', [
                'class' => 'AppBundle\Entity\ProductBase',
                'label' => 'Základní produkt',
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('productVariant', 'entity', [
                'class' => 'AppBundle\Entity\ProductVariant',
                'label' => 'Varianta produktu',
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('productTakeoverType', 'entity', [
                'class' => 'AppBundle\Entity\ProductTakeoverType',
                'label' => 'Typ převzetí',
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('price', 'number', [
                'label' => 'Cena',
                'required' => false,
            ])
            ->add('productAdditions', 'entity', [
                'class' => 'AppBundle\Entity\ProductAddition',
                'label' => 'Volitelná rozšíření',
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
                'required' => false,
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Product
            ? $object->getName()
            : 'Produkty'; // shown in the breadcrumb on the create view
    }

}

<?php
/**
 * Project: spizza-web
 * File: ProductAdmin.php
 * Author: Tomas SYROVY <tomas@syrovy.pro>
 * Date: 17.03.17
 * Version: 1.0
 */

namespace AppBundle\Admin;

use AppBundle\Entity\ProductBase;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ProductBaseAdmin extends AbstractAdmin {

	protected $datagridValues = array(
		'_page' => 1,
		'_sort_order' => 'ASC',
		'_sort_by' => 'position',
	);

	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('move', $this->getRouterIdParameter().'/move/{position}');
		$collection->add('generate-products', $this->getRouterIdParameter().'/generate-products');
	}

	/**
	 * @param DatagridMapper $datagridMapper
	 *
	 * @throws \RuntimeException
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('name', null, [
				'label' => 'Název'
			])
		;
	}

	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->with('Základní informace', [
				'class' => 'col-md-4'
			])
				->add('name', 'text', [
					'label' => 'Název',
					'required' => false,
				])
				->add('imageFile', 'file', [
					'label' => 'Obrázek',
					'required' => false,
				])
				->add('forSale', 'checkbox', [
					'label' => 'K prodeji (zobrazovat v nabídce obchodu)',
					'required' => false,
				])
				->add('productLabels', null, [
					'label' => 'Štítky',
					'expanded' => true,
					'by_reference' => false,
					'multiple' => true,
					'choice_label' => 'name',
					'required' => false,
				])
			->end()
			->with('Atributy, kategorie a alergeny', [
				'class' => 'col-md-4'
			])
				->add('productAttributes', null, [
					'label' => 'Atributy',
					'expanded' => true,
					'by_reference' => false,
					'multiple' => true,
					'choice_label' => 'name',
					'required' => false,
				])
				->add('productCategories', null, [
					'label' => 'Kategorie',
					'expanded' => true,
					'by_reference' => false,
					'multiple' => true,
					'choice_label' => 'name',
					'required' => false,
				])
				->add('productAllergens', null, [
					'label' => 'Alergeny',
					'expanded' => true,
					'by_reference' => false,
					'multiple' => true,
					'choice_label' => 'name',
					'required' => false,
				])
			->end()
			->with('Suroviny', [
				'class' => 'col-md-4'
			])
			->add('productMaterials', null, [
				'label' => false,
				'expanded' => true,
				'by_reference' => false,
				'multiple' => true,
				'choice_label' => 'name',
				'required' => false,
			])
			->end()
		;
	}

	protected function configureListFields( ListMapper $list ){

		$list
			->add('forSale', 'boolean', [
				'label' => 'K prodeji'
			])
			->add('imageFile', null, [
					'label' => 'Obrázek',
					'template' => 'AppBundle:ProductBaseAdmin:list__field_imageFile.html.twig'
				]
			)
			->addIdentifier('name', 'text', [
				'label' => 'Název'
			])
			->add('_action', null, [
				'label' => 'Akce',
				'actions' => [
					'show' => [],
					'edit' => [],
					'delete' => [],
					'generate-products' => [
						'template' => 'AppBundle:ProductBaseAdmin:list__action_generate-products.html.twig'
					],
					'move' => [
						'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
					],
				]
			])
		;
	}

	public function toString($object){

		return $object instanceof ProductBase ? $object->getName() : 'Základní produkt';

	}


}
<?php

    namespace AppBundle\Admin;
    
    use AppBundle\Entity\ProductVariant;
    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Sonata\AdminBundle\Route\RouteCollection;
    use Sonata\AdminBundle\Show\ShowMapper;

    class ProductVariantAdmin extends AbstractAdmin
    {

        protected $datagridValues = array(
            '_page' => 1,
            '_sort_order' => 'ASC',
            '_sort_by' => 'position',
        );


        protected function configureRoutes(RouteCollection $collection)
        {
            $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
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

        /**
         * @param ListMapper $listMapper
         *
         * @throws \RuntimeException
         */
        protected function configureListFields(ListMapper $listMapper)
        {

            $listMapper
                ->addIdentifier('name', 'text', [
                    'label' => 'Název'
                ])
                ->add('_action', null, [
                    'label' => 'Akce',
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                        'move' => [
                            'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
                        ],
                    ]
                ])
            ;
        }

        /**
         * @param FormMapper $formMapper
         */
        protected function configureFormFields(FormMapper $formMapper)
        {
            $formMapper
                ->add('name', 'text', [
                    'label' => 'Název',
                    'required' => false,
                ])
            ;
        }

        /**
         * @param ShowMapper $showMapper
         *
         * @throws \RuntimeException
         */
        protected function configureShowFields(ShowMapper $showMapper)
        {
            $showMapper
                ->add('name', 'text', [
                    'label' => 'Název'
                ])
            ;
        }

        public function toString($object)
        {
            return $object instanceof ProductVariant
                ? $object->getName()
                : 'Varianty produktů'; // shown in the breadcrumb on the create view
        }

    }

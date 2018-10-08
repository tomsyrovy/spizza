<?php
	/**
	 * Project: spizza-web
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 22.04.17
	 * Version: 1.0
	 */

	namespace AppBundle\Entity\Traits;

	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Mapping\Annotation as Gedmo;


	trait EnumerationTrait {

		/**
		 * @var string
		 *
		 * @ORM\Column(name="name", type="string", length=255)
		 */
		private $name;

		/**
		 * @Gedmo\Slug(fields={"name"})
		 * @ORM\Column(name="slug", type="string", length=128, unique=true)
		 */
		private $slug;

		/**
		 * @Gedmo\SortablePosition
		 * @ORM\Column(name="position", type="integer")
		 */
		private $position;

		/**
		 * @return string
		 */
		public function getName(){
			return $this->name;
		}

		/**
		 * @param $name
		 *
		 * @return $this
		 */
		public function setName( $name ){
			$this->name = $name;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getSlug(){
			return $this->slug;
		}

		/**
		 * @return mixed
		 */
		public function getPosition(){
			return $this->position;
		}

		/**
		 * @param $position
		 *
		 * @return $this
		 */
		public function setPosition( $position ){
			$this->position = $position;

			return $this;
		}

	}
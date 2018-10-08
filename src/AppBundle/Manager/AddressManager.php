<?php
	/**
	 * Project: spizza-web
	 * File: AddressManager.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 24.05.17
	 * Version: 1.0
	 */

	namespace AppBundle\Manager;


	use AppBundle\Entity\Cart;
	use AppBundle\Entity\Commission;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Cookie;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	class AddressManager {

		/** @var  ObjectManager */
		private $em;

		/** @var  Request */
		private $request;

		/**
		 * AddressManager constructor.
		 *
		 * @param \Doctrine\Common\Persistence\ObjectManager $em
		 * @param \Symfony\Component\HttpFoundation\Request  $request
		 */
		public function __construct( ObjectManager $em, Request $request ){
			$this->em      = $em;
			$this->request = $request;
		}

		public function getAddress(){

			$address = null;

			if($this->request->cookies->has('address')){
				$address = $this->request->cookies->get('address');
			}

			return $address;

		}

		public function saveAddress($address){

			$response = new Response();
			$cookie = new Cookie('address', $address, time()+3600);
			$response->headers->setCookie($cookie);
			$response->sendHeaders();

		}

		/**
		 * @return array|mixed|null
		 */
		public function tryParse(){

			$address = $this->getAddress();

			if($address === null){
				return [];
			}

			$parts = explode(',', $address);

			if(count($parts) >= 2){

				preg_match('/([\/1234567890]+)(?!.*\d)/', $parts[0], $output_array);

				if(count($output_array) === 0){
					return [];
				}

				$address = [
					'street' => $parts[0],
					'number' => $output_array[0],
					'city' => $parts[1]
				];

				return $address;
			}

			return [];

		}

	}
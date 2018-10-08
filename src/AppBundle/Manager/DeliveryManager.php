<?php
/**
 * Project: spizza-web
 * File: DeliveryManager.php
 * Author: Tomas SYROVY <tomas@syrovy.pro>
 * Date: 30.05.17
 * Version: 1.0
 */

namespace AppBundle\Manager;


use AppBundle\Entity\LocalBusiness;
use Doctrine\Common\Persistence\ObjectManager;
use Ivory\GoogleMap\Service\Base\Location\AddressLocation;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixElement;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixRow;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class DeliveryManager {

	private static $maxDistance = 15000; //metres

	private static $maxDuration = 900; //seconds

	/** @var ObjectManager */
	private $em;

	/** @var Request */
	private $request;

	/** @var ContainerInterface */
	private $container;

	/** @var AddressManager */
	private $addressManager;

	private $distanceMatrixService;

	/**
	 * DeliveryManager constructor.
	 *
	 * @param \Doctrine\Common\Persistence\ObjectManager                $em
	 * @param \Symfony\Component\HttpFoundation\Request                 $request
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 */
	public function __construct( ObjectManager $em, Request $request, ContainerInterface $container ){
		$this->em        = $em;
		$this->request   = $request;
		$this->container = $container;
		$this->distanceMatrixService = $this->container->get('ivory.google_map.distance_matrix');
		$this->addressManager = new AddressManager($em, $request);
	}


	/**
	 * @return array
	 */
	public function getBestLocalBusiness(){

		$result = [];

		$destinations = [];
		$destinations[] = new AddressLocation($this->addressManager->getAddress());

		$localBusinesses = $this->em->getRepository(LocalBusiness::class)->findAll();

		/** @var LocalBusiness $localBusiness */
		foreach($localBusinesses as $localBusiness){
			$origins = [];
			$origins[] = new AddressLocation($localBusiness->getAddress()->getFullAddress());

			$request = new DistanceMatrixRequest( $origins, $destinations );

			$response = $this->distanceMatrixService->process($request);

			/** @var DistanceMatrixRow $distanceMatrixRow */
			foreach($response->getRows() as $distanceMatrixRow){
				/** @var DistanceMatrixElement $distanceMatrixElement */
				foreach($distanceMatrixRow->getElements() as $distanceMatrixElement){
					if($distanceMatrixElement->getStatus() === 'OK' and $distanceMatrixElement->getDistance()->getValue() <= self::$maxDistance and $distanceMatrixElement->getDuration()->getValue() <= self::$maxDuration){

						$result[] = $localBusiness;

					}
				}
			}

		}

		return $result;

	}

}
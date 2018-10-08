<?php

namespace StaticBundle\Controller;

use AppBundle\Entity\LocalBusiness;
use AppBundle\Entity\ProductTakeoverType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
	/**
	 * @Route("/kontakty", name="static.default.kontakty")
	 *
	 * @Template()
	 */
	public function kontaktyAction(){

		$em = $this->getDoctrine()->getManager();

		$criteria = [];
		$orderBy = [
			'position' => 'ASC'
		];
		$localBusinesses = $em->getRepository(LocalBusiness::class)->findBy($criteria, $orderBy);

		$criteria = [];
		$orderBy = [
			'position' => 'ASC'
		];
		$takeOverTypes = $em->getRepository(ProductTakeoverType::class)->findBy($criteria, $orderBy);

		$data = [
			'localBusinesses' => $localBusinesses,
			'takeOverTypes' => $takeOverTypes
		];

		return $data;

	}

	/**
     * @Route("/{slug}", name="static.default.index", requirements={"page": "[A-Za-z0-9][_-A-Za-z0-9]*"})
     */
    public function indexAction($slug)
    {
        return $this->render('StaticBundle:Default:'.$slug.'.html.twig');
    }
}

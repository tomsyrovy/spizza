<?php
	/**
	 * Project: spizza-web
	 * File: AppExtension.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 08.09.17
	 * Version: 1.0
	 */

	namespace AppBundle\Twig;

	class AppExtension extends \Twig_Extension
	{
		public function getFilters()
		{
			return array(
				new \Twig_SimpleFilter('nicePrice', array($this, 'nicePriceFilter')),
			);
		}

		public function nicePriceFilter($number, $locale){

			switch($locale){
				case 'cs' : {
					$decimals = 2;
					$decPoint = ',';
					$thousandsSep = ' ';
					$currency = ' Kč';
					$positionAfter = true;
					$freeTitle = 'zdarma';
				}break;
				default: {
					$decimals = 2;
					$decPoint = ',';
					$thousandsSep = ' ';
					$currency = ' Kč';
					$positionAfter = true;
					$freeTitle = 'zdarma';
				}
			}

			if($number == round($number)){
				$nicePrice = number_format($number, 0, $decPoint, $thousandsSep);
			}else{
				$nicePrice = number_format($number, $decimals, $decPoint, $thousandsSep);
			}

			if(round($number) == 0){

				$nicePrice = $freeTitle;

			}else{

				if($positionAfter){

					$nicePrice = $nicePrice.$currency;

				}else{

					$nicePrice = $currency.$nicePrice;

				}

			}

			return $nicePrice;

		}
	}
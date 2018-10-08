<?php

	/**
	 * Project: spizza-web
	 * File: LoadData.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 22.03.17
	 * Version: 1.0
	 */
	namespace AppBundle\DataFixtures\ORM;

	use AppBundle\Entity\Product;
	use AppBundle\Entity\ProductAllergen;
	use AppBundle\Entity\ProductAttribute;
	use AppBundle\Entity\ProductBase;
	use AppBundle\Entity\ProductCategory;
	use AppBundle\Entity\ProductMaterial;
	use AppBundle\Entity\ProductVariant;
	use Doctrine\Common\DataFixtures\FixtureInterface;
	use Doctrine\Common\Persistence\ObjectManager;

	class LoadData implements FixtureInterface
	{
		private static $objects = [];

		private $manager;

		public function load(ObjectManager $manager)
		{

			$files = glob(__DIR__.'/../../../../web/uploads/product_bases/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
					unlink($file); // delete file
			}

			$this->manager = $manager;

			$this->loadFromJson();
			$this->loadFromExcel();

//			$this->persistAll($manager);
//			$manager->flush();
		}

		private function loadFromExcel(){

			$filename = __DIR__.'/data.xlsx';
			$phpExcelObject = \PHPExcel_IOFactory::load($filename);

			$sheet = $phpExcelObject->getActiveSheet();

			$this->loadFromExcel_ProductVariants($sheet);
			$this->loadFromExcel_ProductAttributes($sheet);
			$this->loadFromExcel_ProductMaterials($sheet);
			$this->loadFromExcel_ProductAllergens($sheet);
			$this->loadFromExcel_ProductBases($sheet);

		}

		private function loadFromExcel_ProductVariants(\PHPExcel_Worksheet $sheet){

			for($pCol = 4; $pCol <= 17; $pCol += 2){

				$name = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();

				if($name === null){
					dump($pCol);exit;
				}

				$object = new ProductVariant();
				$object->setName($name);

				$key = 'pv_'.$object->getName();

				self::$objects[$key] = $object;
				$this->manager->persist($object);
				$this->manager->flush();

			}

		}

		private function loadFromExcel_ProductAttributes(\PHPExcel_Worksheet $sheet){

			for($pCol = 19; $pCol <= 25; $pCol += 1){

				$name = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();

				if($name === null){
					dump($pCol);exit;
				}

				$object = new ProductAttribute();
				$object->setName($name);
				if($name == "Extra pálivá"){
					$object->setVisibleInMenu(false);
				}

				$key = 'pa_'.$object->getName();

				self::$objects[$key] = $object;
				$this->manager->persist($object);
				$this->manager->flush();

			}

		}

		private function loadFromExcel_ProductMaterials(\PHPExcel_Worksheet $sheet){

			for($pCol = 26; $pCol <= 87; $pCol += 1){

				$name = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();

				if($name === null){
					dump($pCol);exit;
				}

				$object = new ProductMaterial();
				$object->setName($name);

				$key = 'pm_'.$object->getName();

				self::$objects[$key] = $object;
				$this->manager->persist($object);
				$this->manager->flush();

			}

		}

		private function loadFromExcel_ProductAllergens(\PHPExcel_Worksheet $sheet){

			for($pCol = 88; $pCol <= 99; $pCol += 1){

				$name = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();

				if($name === null){
					dump($pCol);exit;
				}

				$object = new ProductAllergen();
				$object->setName($name);

				$key = 'pal_'.$object->getName();

				self::$objects[$key] = $object;
				$this->manager->persist($object);
				$this->manager->flush();

			}

		}

		private function loadFromExcel_ProductBases(\PHPExcel_Worksheet $sheet){

			for($pRow = 5; $pRow <= 64; $pRow++){

				if($pRow <= 50){
					$category = 'pizza';
				}else{
					if($pRow <= 54) {
						$category = 'gyros';
					}else{
						$category = 'nápoje';
					}
				}

				$name = $sheet->getCellByColumnAndRow(3, $pRow)->getValue();

				$object = new ProductBase();
				$object->setName($name);
				$object->addProductCategory(self::$objects[$category]);

				if(in_array($category, ['pizza'], true)){

					//ProductAttributes
					for($pCol = 19; $pCol <= 25; $pCol += 1){

						$value = $sheet->getCellByColumnAndRow($pCol, $pRow)->getValue();

						if($value == 1){
							$k = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();
							$object->addProductAttribute(self::$objects['pa_'.$k]);
						}

					}

				}

				if(in_array($category, ['pizza', 'gyros'], true)){

					//ProductMaterials
					for($pCol = 26; $pCol <= 87; $pCol += 1){

						$value = $sheet->getCellByColumnAndRow($pCol, $pRow)->getValue();

						if($value == 1){
							$k = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();
							$object->addProductMaterial(self::$objects['pm_'.$k]);
						}

					}

					//ProductAllergens
					for($pCol = 88; $pCol <= 99; $pCol += 1){

						$value = $sheet->getCellByColumnAndRow($pCol, $pRow)->getValue();

						if($value == 1){
							$k = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();
							$object->addProductAllergen(self::$objects['pal_'.$k]);
						}

					}

				}

				//Product images
				$extension = '.png';
				$originName = $object->getName().$extension;
				$filename = __DIR__.'/photos/'.$originName;
				if(file_exists($filename)){

					$now = new \DateTime();
					$newName = md5($originName.$now->format('Y-m-d H:i:s'));

					$data = file_get_contents($filename);

					//origin
					file_put_contents(__DIR__.'/../../../../web/uploads/product_bases/'.$newName.$extension, $data);

					//thumbnail
					list($width, $height) = getimagesize($filename);
					$newwidth = $width/2;
					$newheight = $height/2;
					$src = imagecreatefrompng($filename);
					$dst = imagecreatetruecolor($newwidth, $newheight);
					imagealphablending( $dst, false );
					imagesavealpha( $dst, true );
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagepng($dst, __DIR__.'/../../../../web/uploads/product_bases/thumbnails/'.$newName.$extension);

					$object->setImageUpdatedAt($now);
					$object->setImageName($newName.$extension);

				}


				$key = 'pb_'.$object->getName();

				self::$objects[$key] = $object;
				$this->manager->persist($object);
				$this->manager->flush();

				//Products
				for($pCol = 4; $pCol <= 17; $pCol += 2){

					$variant_value = $sheet->getCellByColumnAndRow($pCol, 3)->getValue();

					for($j = 0; $j <= 1; $j++){

						$delivery_value = $sheet->getCellByColumnAndRow($pCol+$j, 4)->getValue();
						$price_value = $sheet->getCellByColumnAndRow($pCol+$j, $pRow)->getValue();

						if($delivery_value and $price_value and (float)$price_value > 0){

							$product = new Product();
							$product->setProductBase($object);
							$product->setProductTakeoverType(self::$objects[$delivery_value]);
							$product->setPrice((float)$price_value);

							if($category === 'pizza'){

								$product->setProductVariant(self::$objects['pv_'.$variant_value]);

							}

							//ProductAdditions
							if($category === 'pizza' and $product->getProductBase()->getName() !== "Jablečný ŠPIZZA koláč s ořechy"){
								$product->addProductAddition(self::$objects['prisadaPizza']);
								$product->addProductAddition(self::$objects['poterka']);
								if(!$product->getProductBase()->getProductAttributes()->contains(self::$objects['pa_Veganská'])){ //Veganská pizza nemá plněné okraje
									if($variant_value == 'Rodinná'){
										$product->addProductAddition(self::$objects['plnenyokraj50']);
									}
									if($variant_value == 'Třicítka'){
										$product->addProductAddition(self::$objects['plnenyokraj30']);
									}
								}
								if($variant_value !== "1/4 pizzy" and $variant_value !== "1/8 (kousek pizzy)" and $variant_value !== "Kapsa"){ //pro 1/4 a 1/8 a kapsu není možné dětské zdobení
									$product->addProductAddition(self::$objects['detskezdobeni']);
								}
								if($variant_value !== "1/4 pizzy" and $variant_value !== "1/8 (kousek pizzy)"){ //pro 1/4 a 1/8 není možná změna základu
									$smetana = $sheet->getCellByColumnAndRow(18, $pRow)->getValue();
									if($smetana){
										if($variant_value == '1/4 pizzy'){
											$product->addProductAddition(self::$objects['smetanovyzaklad1/4']);
										}else{
											$product->addProductAddition(self::$objects['smetanovyzaklad']);
										}
									}
								}
							}
							if($category === 'gyros'){
								$product->addProductAddition(self::$objects['omacka']);
								$product->addProductAddition(self::$objects['omacka2']);
							}

							self::$objects[] = $product;
							$this->manager->persist($product);
							$this->manager->flush();

						}

					}


				}

			}

		}

		private function getJson(){

			$filename = __DIR__.'/data2.json';
			$json = file_get_contents($filename);

			return $json;

		}

		private function loadFromJson(){

			$array = json_decode($this->getJson());

			foreach($array as $entityClass => $entity){

				foreach($entity as $identifier => $item){

					$object = new $entityClass();

					foreach($item as $attr => $value){

						if(is_array($value)){

							$method_name = 'add'.$attr;
							if(method_exists($object, $method_name)){

								foreach($value as $value_item){

									if( $value_item[0] === '@'){

										$k = substr($value_item, 1);
										$object->{$method_name}(self::$objects[$k]);

									}else{

										//TODO - v poli nejsou odkazy na jiné entity

									}

								}
							}

						}else{

							$method_name = 'set'.$attr;
							if(method_exists($object, $method_name)){

								if( $value[0] === '@'){

									$k = substr($value, 1);
									$object->{$method_name}(self::$objects[$k]);

								}else{

									//Pokud $value je časový záznam ve formě string (hh:mm:ss)
									preg_match("/(\d{2}:){2}\d{2}/", $value, $output_array);
									if(array_key_exists(0, $output_array)){
										if($output_array[0] === $value){
											$value = new \DateTime($value); //tak jej převeď do formy DateTime
										}
									}

									$object->{$method_name}($value);

								}

							}

						}
					}

					$index = $identifier;

					self::$objects[$index] = $object;
					$this->manager->persist($object);
					$this->manager->flush();

				}

			}

		}

//		private function persistAll(ObjectManager $manager){
//
//			foreach(self::$objects as $object){
//				$manager->persist($object);
//			}
//
//		}
	}
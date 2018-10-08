<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * ProductBase
 *
 * @ORM\Table(name="product_base")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductBaseRepository")
 * @Vich\Uploadable
 */
class ProductBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductCategory", inversedBy="productBases", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productCategories;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductAttribute", inversedBy="productBases", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productAttributes;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductMaterial", inversedBy="productBases", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productMaterials;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductAllergen", inversedBy="productBases", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productAllergens;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductLabel", inversedBy="productBases", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productLabels;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="productBase", cascade={"persist"})
     */
    private $products;

    /**
     * @var boolean
     *
     * @ORM\Column(name="for_sale", type="boolean")
     */
    private $forSale = true;

    /**
    * NOTE: This is not a mapped field of entity metadata, just a simple property.
    *
    * @Vich\UploadableField(mapping="productBase_image", fileNameProperty="imageName")
    *
    * @var File
    */
    private $imageFile;

    /**
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(name="image_updated_at", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $imageUpdatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
        $this->productLabels = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->productMaterials = new ArrayCollection();
        $this->productAllergens = new ArrayCollection();
    }

    /**
     * @param $object
     *
     * @return string
     */
    public function getSlugs($object){

        $slugs = [];

        $items = $this->$object;

        foreach($items as $item){

            $slugs[] = $item->getSlug();

        }

        return implode(';', $slugs);

    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProductBase
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add productCategory
     *
     * @param \AppBundle\Entity\ProductCategory $productCategory
     *
     * @return ProductBase
     */
    public function addProductCategory(ProductCategory $productCategory)
    {
        $this->productCategories[] = $productCategory;

        return $this;
    }

    /**
     * Remove productCategory
     *
     * @param \AppBundle\Entity\ProductCategory $productCategory
     */
    public function removeProductCategory(ProductCategory $productCategory)
    {
        $this->productCategories->removeElement($productCategory);
    }

    /**
     * Get productCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * @return mixed
     */
    public function getPosition(){
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition( $position ){
        $this->position = $position;
    }


    /**
     * Add productAttribute
     *
     * @param \AppBundle\Entity\ProductAttribute $productAttribute
     *
     * @return ProductBase
     */
    public function addProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes[] = $productAttribute;

        return $this;
    }

    /**
     * Remove productAttribute
     *
     * @param \AppBundle\Entity\ProductAttribute $productAttribute
     */
    public function removeProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes->removeElement($productAttribute);
    }

    /**
     * Get productAttributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    /**
     * @return boolean
     */
    public function isForSale(){
        return $this->forSale;
    }

    /**
     * @param boolean $forSale
     */
    public function setForSale( $forSale ){
        $this->forSale = $forSale;
    }


    /**
     * Get forSale
     *
     * @return boolean
     */
    public function getForSale()
    {
        return $this->forSale;
    }

    /**
     * Add productLabel
     *
     * @param \AppBundle\Entity\ProductLabel $productLabel
     *
     * @return ProductBase
     */
    public function addProductLabel(ProductLabel $productLabel)
    {
        $this->productLabels[] = $productLabel;

        return $this;
    }

    /**
     * Remove productLabel
     *
     * @param \AppBundle\Entity\ProductLabel $productLabel
     */
    public function removeProductLabel(ProductLabel $productLabel)
    {
        $this->productLabels->removeElement($productLabel);
    }

    /**
     * Get productLabels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductLabels()
    {
        return $this->productLabels;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return ProductBase
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        $products = $this->products->toArray();
        uasort($products, function($a, $b){
            if($a->getProductVariant() === null or $b->getProductVariant() === null){
                return 0;
            }
            return $a->getProductVariant()->getPosition() < $b->getProductVariant()->getPosition() ? -1 : 1;
        });

        return new ArrayCollection($products);
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->imageUpdatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }


    /**
     * Set imageUpdatedAt
     *
     * @param \DateTime $imageUpdatedAt
     *
     * @return ProductBase
     */
    public function setImageUpdatedAt($imageUpdatedAt)
    {
        $this->imageUpdatedAt = $imageUpdatedAt;

        return $this;
    }

    /**
     * Get imageUpdatedAt
     *
     * @return \DateTime
     */
    public function getImageUpdatedAt()
    {
        return $this->imageUpdatedAt;
    }

    /**
     * Add productMaterial
     *
     * @param \AppBundle\Entity\ProductMaterial $productMaterial
     *
     * @return ProductBase
     */
    public function addProductMaterial(ProductMaterial $productMaterial)
    {
        $this->productMaterials[] = $productMaterial;

        return $this;
    }

    /**
     * Remove productMaterial
     *
     * @param \AppBundle\Entity\ProductMaterial $productMaterial
     */
    public function removeProductMaterial(ProductMaterial $productMaterial)
    {
        $this->productMaterials->removeElement($productMaterial);
    }

    /**
     * Get productMaterials
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductMaterials()
    {
        return $this->productMaterials;
    }

    /**
     * Add productAllergen
     *
     * @param \AppBundle\Entity\ProductAllergen $productAllergen
     *
     * @return ProductBase
     */
    public function addProductAllergen(\AppBundle\Entity\ProductAllergen $productAllergen)
    {
        $this->productAllergens[] = $productAllergen;

        return $this;
    }

    /**
     * Remove productAllergen
     *
     * @param \AppBundle\Entity\ProductAllergen $productAllergen
     */
    public function removeProductAllergen(\AppBundle\Entity\ProductAllergen $productAllergen)
    {
        $this->productAllergens->removeElement($productAllergen);
    }

    /**
     * Get productAllergens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductAllergens()
    {
        return $this->productAllergens;
    }
}

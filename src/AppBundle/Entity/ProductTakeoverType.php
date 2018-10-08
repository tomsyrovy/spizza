<?php

    namespace AppBundle\Entity;

    use AppBundle\Entity\Traits\EnumerationTrait;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use Gedmo\Mapping\Annotation as Gedmo;

    /**
     * ProductVariant
     *
     * @ORM\Table(name="product_takeover_type")
     * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductTakeoverTypeRepository")
     */
    class ProductTakeoverType
    {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        use EnumerationTrait;

        /**
         * @var ArrayCollection
         *
         * @ORM\OneToMany(targetEntity="Product", mappedBy="productTakeoverType", cascade={"persist"})
         */
        private $products;

	    /**
	     * @var \Doctrine\Common\Collections\ArrayCollection
	     *
	     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PaymentMethod", inversedBy="takeOverTypes", cascade={"persist"})
	     */
	    private $paymentMethods;

	    /**
	     * @var float
	     *
	     * @ORM\Column(name="price", type="decimal", scale=2, precision=6)
	     */
        private $price = 0;

        /**
         * Get id
         *
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }


        /**
         * Constructor
         */
        public function __construct()
        {
            $this->products = new ArrayCollection();
        }

        /**
         * Add product
         *
         * @param \AppBundle\Entity\Product $product
         *
         * @return ProductTakeoverType
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
            return $this->products;
        }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductTakeoverType
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return ProductTakeoverType
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add paymentMethod
     *
     * @param \AppBundle\Entity\PaymentMethod $paymentMethod
     *
     * @return ProductTakeoverType
     */
    public function addPaymentMethod(\AppBundle\Entity\PaymentMethod $paymentMethod)
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    /**
     * Remove paymentMethod
     *
     * @param \AppBundle\Entity\PaymentMethod $paymentMethod
     */
    public function removePaymentMethod(\AppBundle\Entity\PaymentMethod $paymentMethod)
    {
        $this->paymentMethods->removeElement($paymentMethod);
    }

    /**
     * Get paymentMethods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }
}

<?php

namespace Zoop\Inventory\DataModel;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Product\DataModel\AbstractProduct;
use Zoop\Store\DataModel\Store;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\CreatedByTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
use Zoop\Shard\SoftDelete\DataModel\SoftDeleteableTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document(collection="Inventory")
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField(fieldName="type")
 * @ODM\DiscriminatorMap({
 *     "discrete"         = "DiscreteInventory",
 *     "infinite"         = "InfiniteInventory"
 * })
 * @Shard\Serializer\Discriminator
 */
abstract class AbstractInventory
{
    use CreatedOnTrait;
    use CreatedByTrait;
    use UpdatedOnTrait;
    use SoftDeleteableTrait;

    /**
     * @ODM\Id(strategy="UUID")
     */
    protected $id;

    /**
     * Array. Stores that this product is part of.
     * The Zones annotation means this field is used by the Zones filter so
     * only products from the active store are available.
     *
     * @ODM\Collection
     * @Shard\Zones
     * @Shard\Validator\Required
     */
    protected $stores;

    /**
     * @ODM\ReferenceOne(targetDocument="Zoop\Product\DataModel\AbstractProduct", simple="true")
     */
    protected $product;

    /**
     * @ODM\String
     */
    protected $sku;

    /**
     * @ODM\String
     * @Shard\State
     */
    protected $state;

    /**
     * @ODM\Date
     */
    protected $stateExpiry;

    public function __construct()
    {
        $this->stores = new ArrayCollection;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return array
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     *
     * @param array $stores
     */
    public function setStores($stores)
    {
        $this->stores = $stores;
    }

    /**
     *
     * @param Store $store
     */
    public function addStore(Store $store)
    {
        $this->stores->add($store->getId());
    }

    /**
     *
     * @return AbstractProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     *
     * @param AbstractProduct $product
     */
    public function setProduct(AbstractProduct $product)
    {
        $this->product = $product;
    }

    /**
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     *
     * @return DateTime
     */
    public function getStateExpiry()
    {
        return $this->stateExpiry;
    }

    /**
     *
     * @param DateTime $stateExpiry
     */
    public function setStateExpiry(DateTime $stateExpiry)
    {
        $this->stateExpiry = $stateExpiry;
    }
}

<?php

namespace Zoop\Inventory\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class InfiniteInventory extends AbstractInventory
{
    /**
     * @ODM\ReferenceMany(
     *      targetDocument="Zoop\Order\DataModel\Order",
     *      simple="true",
     *      inversedBy="inventory"
     * )
     */
    protected $order;

    /**
     * @ODM\String
     * @Shard\State({
     *      "available"
     * })
     */
    protected $state;
}

<?php

namespace Magenest\Cybergame\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{
    protected $roomExtraOptionFactory;
    protected $collectionFactory;
    protected $attributeSet;
    public function __construct(\Magenest\Cybergame\Model\RoomExtraOptionFactory $roomExtraOptionFactory,
        \Magenest\Cybergame\Model\ResourceModel\RoomExtraOption\CollectionFactory $collectionFactory,
                                \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet
    )
    {
        $this->attributeSet = $attributeSet;
        $this->roomExtraOptionFactory = $roomExtraOptionFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $_product = $observer->getProduct();
        $data = $_product->getData();

        $attributeSetRepository = $this->attributeSet->get($_product->getAttributeSetId());
        $attributeSetName = $attributeSetRepository->getAttributeSetName();
        // check if product is cybergame product
        if(isset($attributeSetName) && $attributeSetName == "Cybergame")
        {
            $roomExtra = $this->roomExtraOptionFactory->create();
            $roomExtraCollection = $this->collectionFactory->create()->getData();
            foreach ($roomExtraCollection as $room)
            {
                //when edit product
                if ($room["product_id"] == $data["entity_id"])
                {
                    $roomExtra->setid($room["id"]);
                }
            }
            // validate
            if(!isset($data["number_pc"]))
                $data["number_pc"] = null;
            if(!isset($data["food_price"]))
                $data["food_price"] = null;
            if(!isset($data["drink_price"]))
                $data["drink_price"] = null;
            if(!isset($data["address"]))
                $data["address"] = null;
            $roomExtra->setname($data["name"]);
            $roomExtra->setprice($data["price"]);
            $roomExtra->setproduct_id($data["entity_id"]);
            $roomExtra->setnumber_pc($data["number_pc"]);
            $roomExtra->setfood_price($data["food_price"]);
            $roomExtra->setdrink_price($data["drink_price"]);
            $roomExtra->setaddress($data["address"]);
            $roomExtra->save();
        }
    }
}
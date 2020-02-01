<?php

namespace Magenest\Cybergame\Controller\RoomInfo;


class Save extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $productFactory;
    protected $productResourceModel;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product $productResourceModel
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->productFactory = $productFactory;
        $this->productResourceModel = $productResourceModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $paramsValue = $this->getRequest()->getParams();
        $product = $this->productFactory->create();
        $this->productResourceModel->load($product, $paramsValue["product_id"]);
        $product->setStoreId(0);
        $product->setCustomAttribute('number_pc', $paramsValue["number_pc"]);
        $product->setCustomAttribute('address', $paramsValue["address"]);
        $product->setCustomAttribute('food_price', $paramsValue["food_price"]);
        $product->setCustomAttribute('drink_price', $paramsValue["drink_price"]);
        $this->productResourceModel->save($product);
        return $this->resultRedirectFactory->create()->setPath('cybergame/roominfo');
    }
}
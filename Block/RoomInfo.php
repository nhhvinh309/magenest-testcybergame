<?php

namespace Magenest\Cybergame\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;

class RoomInfo extends \Magento\Framework\View\Element\Template
{
    protected $sessionFactory;
    protected $customerRepository;
    protected $collectionFactory;
    protected $urlBuilder;


    public function __construct(Template\Context $context, array $data = [],
                                \Magenest\Cybergame\Model\ResourceModel\RoomExtraOption\CollectionFactory $collectionFactory,
                                \Magento\Customer\Model\SessionFactory $sessionFactory,
                                \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
                                UrlInterface $urlBuilder)
    {
        $this->sessionFactory = $sessionFactory;
        $this->customerRepository = $customerRepository;
        $this->collectionFactory = $collectionFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }
    public function getRoomInfo(){
        $collection = $this->collectionFactory->create();
        return $collection->getData();
    }
    public function isManager(){
        $sessionData = $this->sessionFactory->create()->getData();
        $customerID = $sessionData["customer_id"];
        $customerData = $this->customerRepository->getById($customerID);
        $customerAttribute = $customerData->getCustomAttributes();
        $is_manager = 0;
        if(isset( $customerAttribute["is_manager"]) ) {
            $is_manager = $customerAttribute["is_manager"]->getValue();
        }
        return $is_manager;
    }
    public function myUrl($id){
        return $this->urlBuilder->getUrl(
            'cybergame/roominfo/edit',
            ['id' => $id]
        );
    }
}

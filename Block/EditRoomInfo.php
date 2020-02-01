<?php

namespace Magenest\Cybergame\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;

class EditRoomInfo extends \Magento\Framework\View\Element\Template
{
    protected $urlBuilder;
    protected $collectionFactory;



    public function __construct(Template\Context $context, array $data = [],
                                \Magenest\Cybergame\Model\ResourceModel\RoomExtraOption\CollectionFactory $collectionFactory,
                                UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
        $this->collectionFactory = $collectionFactory;


        parent::__construct($context, $data);
    }
    public function getRoomInfo(){
        $postedID = $this->getRequest()->getParam('id');
        return $this->collectionFactory->create()->getItemById($postedID);
    }
    public function myUrl(){
        return $this->urlBuilder->getUrl(
            'cybergame/roominfo/save'
        );
    }
}

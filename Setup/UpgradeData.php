<?php

namespace Magenest\Cybergame\Setup;

use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Customer\Model\ResourceModel\Attribute as CustomerAttributeResourceModel;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;
    private $eavConfig;
    private $customerAttributeResourceModel;
    private $eavSetupFactory;
    private $categorySetupFactory;
    protected $attributeSetFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        EavConfig $eavConfig,
        CustomerAttributeResourceModel $customerAttributeResourceModel,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttributeResourceModel = $customerAttributeResourceModel;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $this->createCustomerCustomAttribute($setup);
//            $this->createCustomAttributeSet($setup);
//            $this->createCustomAttributeSetValue($setup);
        }
    }

    public function createCustomerCustomAttribute($setup)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'is_manager',
            [

                'label' => 'is_manager',
                'input' => 'text',
                'required' => false,
                'sort_order' => 1000,
                'position' => 1000,
                'visible' => true,
                'system' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'is_manager');
        $attribute->setData('used_in_forms', ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']);

        $this->customerAttributeResourceModel->save($attribute);

        $setup->endSetup();
    }
//    public function createCustomAttributeSetValue($setup){
//        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
//        $eavSetup->addAttribute(
//            \Magento\Catalog\Model\Product::ENTITY,
//            'test_demo221',
//            [
//                'attribute_set' => 'HienVinh',
//                'type' => 'int',
//                'backend' => '',
//                'frontend' => '',
//                'label' => 'Test Attribute',
//                'input' => '',
//                'class' => '',
//                'source' => '',
//                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
//                'visible' => true,
//                'required' => false,
//                'user_defined' => false,
//                'default' => 0,
//                'searchable' => false,
//                'filterable' => false,
//                'comparable' => false,
//                'visible_on_front' => false,
//                'used_in_product_listing' => true,
//                'unique' => false,
//                'apply_to' => ''
//            ]
//        );
//    }

//    public function createCustomAttributeSet($setup)
//    {
//        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
//        $attributeSet = $this->attributeSetFactory->create();
//        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
//        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
//        $data = [
//            'attribute_set_name' => 'HienVinh',
//            'entity_type_id' => $entityTypeId,
//            'sort_order' => 200,
//        ];
//        $attributeSet->setData($data);
//        $attributeSet->validate();
//        $attributeSet->save();
//        $attributeSet->initFromSkeleton($attributeSetId);
//        $attributeSet->save();
//    }
}
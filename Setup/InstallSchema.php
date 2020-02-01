<?php
namespace Magenest\Cybergame\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableGamerAccount = $setup->getTable('gamer_account_list');
        $tableRoomExtraOption = $setup->getTable('room_extra_option');
        if($conn->isTableExists($tableGamerAccount) != true){
            $table = $conn->newTable($tableGamerAccount)
                ->addColumn('id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,[
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,['nullable' => false, 'unsigned' => true],
                    'Product ID'
                )->addColumn(
                    'account_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    ['nullable' => false],
                    'Account name'
                )->addColumn(
                    'password',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,['nullable' => false],
                    'Password'
                )->addColumn(
                    'hour',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,['nullable' => false, 'unsigned' => true],
                    'Hour'
                )->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,[
                    'nullable' => false,
                    'default' =>
                        \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                ],
                    'Created at'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Updated at'
                )->setOption('charset','utf8');
            $conn->createTable($table);
        }
        if($conn->isTableExists($tableRoomExtraOption) != true){
            $table = $conn->newTable($tableRoomExtraOption)
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [],
                    'Name'
                )
                ->addColumn('id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,[
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,[ 'unsigned' => true],
                    'Product ID'
                )->addColumn(
                    'number_pc',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,[ 'unsigned' => true],
                    'Number PC'
                )->addColumn(
                    'address',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,[],
                    'Address'
                )->addColumn(
                    'food_price',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,['unsigned' => true],
                    'Food Price'
                )->addColumn(
                    'price',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,['unsigned' => true],
                    'Price'
                )->addColumn(
                    'drink_price',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,['unsigned' => true],
                    'Drink price'
                )->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,[
                    'nullable' => false,
                    'default' =>
                        \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                ],
                    'Created at'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Updated at'
                )->setOption('charset','utf8');
            $conn->createTable($table);
        }
        $setup->endSetup();
    }
}
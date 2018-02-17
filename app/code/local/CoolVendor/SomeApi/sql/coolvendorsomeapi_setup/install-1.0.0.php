<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$tableBirrers = $installer->getTable('coolvendorsomeapi/table_birrers');

$installer->startSetup();
$installer->getConnection()->dropTable($tableBirrers);
$table = $installer->getConnection()
    ->newTable($tableBirrers)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,//значения управляются сервером и их нельзя изменить
        'auto_increment' => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();
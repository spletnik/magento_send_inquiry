<?php
$installer = $this;

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'product_buy_type', array(
    'frontend_input' => 'select',
    'default_value'  => 0,
    'source_model'   => 'inquiry/source',
));

$installer->endSetup();
?>
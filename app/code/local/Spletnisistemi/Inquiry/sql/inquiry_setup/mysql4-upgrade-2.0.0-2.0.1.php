<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('order_inquiries')}
	ADD article_name VARCHAR(255)
");

$installer->endSetup();
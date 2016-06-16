<?php

Mage::log("installing inquiry version 1.0.0");

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$setup->addAttribute('catalog_product', 'product_buy_type', array(
    'group'                   => 'General',
    'input'                   => 'boolean',
    'type'                    => 'int',
    'label'                   => 'Send inquiry?',
    'backend'                 => '',
    'visible'                 => 1,
    'required'                => 0,
    'user_defined'            => 1,
    'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'used_in_product_listing' => 1,
    'is_visible_on_front'     => 1,
));

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('order_inquiries')};
CREATE TABLE {$this->getTable('order_inquiries')} (
	`order_inquiries_id` int(10) unsigned NOT NULL auto_increment,
	`store_id` smallint(5) unsigned default NULL,
	`name` varchar(255) default NULL,
	`last_name` varchar(255) default NULL,
	`email` varchar(255) default NULL,
	`phone` varchar(255) default NULL,
	`content` text default NULL,
	`status`  varchar(255) default NULL,
	`created`  TIMESTAMP default CURRENT_TIMESTAMP,
	`article`  varchar(255) default NULL,
	PRIMARY KEY  (`order_inquiries_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$installer->endSetup();
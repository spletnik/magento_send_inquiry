<?php
require_once 'abstract.php';

/**
 * Mydons Inventoryupdate Shell Script
 *
 * @author     Spletnik
 */
class Spletnik_Shell_Catalogrules extends Mage_Shell_Abstract {
	private $allowd_values = array(0, 1, 2);

	/**
	 * Custom valudator
	 */
	protected function _validate() {

	}

	/**
	 * Run script
	 *
	 */
	public function run() {
		//Possible color value
		$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'product_buy_type');
		if (null !== $this->getArg('value')) {
			$_GET['value'] = $this->getArg('value');
		}
		//var_dump($this->getArg('value'));
		if (isset($_GET['value']) && is_numeric($_GET['value']) && in_array($_GET['value'], $this->allowd_values)) {
			$attribute->setDefaultValue($_GET['value']);
			$attribute->save();
		}
		echo $attribute->getDefaultValue();
	}

	/**
	 * Retrieve Usage Help Message
	 *
	 */
	public function usageHelp() {
		return <<<USAGE
Usage:  php product_buy_type_default.php -value [value]
USAGE;
	}

}

$shell = new Spletnik_Shell_Catalogrules();
$shell->run();
echo "\n";
?>


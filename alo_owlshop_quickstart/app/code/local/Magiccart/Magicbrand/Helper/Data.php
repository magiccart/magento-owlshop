<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:49:38
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicbrand_Helper_Data extends Mage_Core_Helper_Abstract
{
	
    const SECTIONS      = 'magicbrand';   // module name
    const GROUPS        = 'general';        // setup general

    public function getGeneralCfg($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

}


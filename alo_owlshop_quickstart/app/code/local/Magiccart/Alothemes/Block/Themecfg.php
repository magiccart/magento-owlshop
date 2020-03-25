<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-05 16:23:31
 * @@Modify Date: 2015-02-09 12:46:53
 * @@Function:
 */
 ?>

<?php
class Magiccart_Alothemes_Block_Themecfg extends Mage_Core_Block_Template
{
	public function __construct() {
		parent::__construct();
		$this->setConfig(Mage::helper('alothemes')->getConfig());
		
	}	

	protected function _prepareLayout()
	{
		//die(Mage::app()->getConfig()->getNode()->asXML());
	    //$this->getLayout()->getBlock('head')->removeItem('js', 'prototype/prototype.js');  // remove Javascript
	  
		$skin = Mage::getSingleton('core/design_package')->getSkinBaseDir();
		$exp 	= explode(DS, $skin);
		$count 	= count($exp);
		$package_theme = $exp[$count-2].'/'.$exp[$count-1];
		$cfg = 'abc'; // get in Config
		$expcfg = explode('_', $cfg);
		if($expcfg[0] == $package_theme){
	    	$this->getLayout()->getBlock('head')->addCss($expcfg[1]);
		}
	    parent::_prepareLayout();

	}

	public function getLayoutCfg()
	{
		$cfg = array();
		$cfg['controller'] = $this->getRequest()->getRouteName(). // '-'.$this->getRequest()->getModuleName().
							'/'.$this->getRequest()->getControllerName().
							'/'.$this->getRequest()->getActionName();

		$root = $this->getLayout()->getBlock('root');
		if ($root) {
		    $rootTpl = $root->getTemplate(); // For core/design_package calculated if absolute path use getTemplateFile();
		    switch ($rootTpl) {
		        case 'page/1column.phtml':
		            $cfg['page'] = 'page/1column.phtml';
		            break;		        
		        case 'page/2columns-left.phtml':
		            $cfg['page'] = 'page/2columns-left.phtml';
		            break;		        
		        case 'page/2columns-right.phtml':
		            $cfg['page'] = 'page/2columns-right.phtml';
		            break;		        
		        case 'page/3column3.phtml':
		            $cfg['page'] = 'page/3column3.phtml';
		            break;

		        //etc.
		    }
		}
		return $cfg;
	}

	public function getThemecfg()
	{
		$isSecure = $this->getRequest()->isSecure();
		$protocol = $isSecure ? 'https' : 'http';
		$cfg 	= $this->getConfig(); // config Style 
		$font 	= $cfg['font'];
		/* get Lib Font */
		$html  	= '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family='.str_replace(' ', '+', $font['google']).'" media="all" />';
		/* CssGenerator */
		$html  .= "\n"; // break line;
		$html  .= '<style type="text/css">';
		$html  .= '*, body, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{ font-size: '.$font['size'].'; font-family: '.$font['google'].';}';
		$backgroundcolor = array(
	            	'page_color', 'page_background',
	            	'link_color', 'link_color_hover', 'link_color_active',
	            	'button_color', 'button_color_hover', 'button_background', 'button_background_hover',
	            	'labelnew_color', 'labelnew_background', 'labelsale_color', 'labelsale_background',
				);
		$color 	= $cfg['color'];
		foreach ($backgroundcolor as $option) {
			$opts 	= explode('_', $option);
			$event 	= isset($opts[2]) ? ":$opts[2]" : '';
			if($opts[0] == 'page') 			$opts[0] = 'body';
			if($opts[0] == 'link') 			$opts[0] = 'a';
			if($opts[0] == 'button')		$opts[0] = 'button.button span';
			if($opts[0] == 'labelnew')  	$opts[0] = '.labelnew';
			if($opts[0] == 'labelsale') 	$opts[0] = '.labelsale';
			if($opts[1] == 'background')	$opts[1] = 'background-color';
			$html .= "$opts[0]$event{ $opts[1] : $color[$option];} ";
		}
		$html  .= '</style>';
		$html  .= "\n"; // break line;

		/* Ajax Loading */
		$image 		= isset($cfg['general']['ajaxloading']) ? $cfg['general']['ajaxloading'] : '';
		if($image){
			$link = Mage::getBaseUrl('media', array('_secure'=>$isSecure)).'magiccart/'.$image;
		}else {
			// Mage::app()->getFrontController()->getRequest()->isSecure();
			// $this->getUrl('my-page', array('_forced_secure' => $isSecure));
			$link = $this->getSkinUrl('images/opc-ajax-loader.gif', array('_secure'=>$isSecure));
		}
		$cfg['general']['ajaxloading'] = $link;
		$cfg['general']['baseUrl'] = Mage::getBaseUrl();
		unset($cfg['color']); unset($cfg['font']);
		$html .= '<script type="text/javascript"> Themecfg = '.json_encode($cfg).'</script>';  // json config theme

		return $html;

	}

}

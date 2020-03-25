<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-05 20:29:22
 * @@Modify Date: 2014-10-24 21:12:03
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Helper_Labels extends Mage_Core_Helper_Abstract
{	
	public function getLabels($product)
	{
		$html  = '';
		$percent = true; // get in Cfg;
		$isNew = $this->isNew($product);

		$isSale = $this->isOnSale($product);
		if($isNew){
			$html .= '<span class="sticker top-left"><span class="labelnew">' . $this->__('New') . '</span></span>';			
		}
		if($isSale){
			$price = $product->getPrice();
			$finalPrice = $product->getFinalPrice();
			$label = $percent ? floor(($finalPrice/$price)*100 - 100).'%' : $this->__('Sale');

			$html .= '<span class="sticker top-right"><span class="labelsale">' . $label . '</span></span>';
		}
		
		return $html;
	}

	public function isNew($product)
	{
		return $this->_nowIsBetween($product->getData('news_from_date'), $product->getData('news_to_date'));
	}

	public function isOnSale($product)
	{
		$specialPrice = number_format($product->getFinalPrice(), 2);
		$regularPrice = number_format($product->getPrice(), 2);
		
		if ($specialPrice != $regularPrice)
			return $this->_nowIsBetween($product->getData('special_from_date'), $product->getData('special_to_date'));
		else
			return false;
	}
	
	protected function _nowIsBetween($fromDate, $toDate)
	{
		if ($fromDate)
		{
			$fromDate = strtotime($fromDate);
			$toDate = strtotime($toDate);
			$now = strtotime(date("Y-m-d H:i:s"));
			
			if ($toDate)
			{
				if ($fromDate <= $now && $now <= $toDate)
					return true;
			}
			else
			{
				if ($fromDate <= $now)
					return true;
			}
		}
		
		return false;
	}

    public function getImageHover($product)
    {
	    return  $product->load('media_gallery')
	                    ->getMediaGalleryImages()
	                    ->getItemByColumnValue('position','2') //->getItemByColumnValue('label','Imagehover')
	                    ->getFile();
    }

}

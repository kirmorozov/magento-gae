<?php

class GAE_Catalog_Model_Product_Image extends Mage_Catalog_Model_Product_Image
{
    public function setBaseFile($file)
    {
        $this->_isBaseFilePlaceholder = false;

        if (($file) && (0 !== strpos($file, '/', 0))) {
            $file = '/' . $file;
        }
        $baseDir = Mage::getSingleton('catalog/product_media_config')->getBaseMediaPath();

        if ('/no_selection' == $file) {
            $isConfigPlaceholder = Mage::getStoreConfig("catalog/placeholder/{$this->getDestinationSubdir()}_placeholder");
            if ($isConfigPlaceholder) {
                // if configuration contains file, we trust
                $file = '/placeholder/' . $isConfigPlaceholder;
            } else {
                // I can do this because of materialized skin folder
                $baseDir     = Mage::getDesign()->getSkinBaseDir();
                $file = "/images/catalog/product/placeholder/{$this->getDestinationSubdir()}.jpg";
            }
            $this->_isBaseFilePlaceholder = true;
        }

        $this->_baseFile = $baseFile = $baseDir . $file;

        /**
         * Copy-paste starts here
         */

        // build new filename (most important params)
        $path = array(
            Mage::getSingleton('catalog/product_media_config')->getBaseMediaPath(),
            'cache',
            Mage::app()->getStore()->getId(),
            $path[] = $this->getDestinationSubdir()
        );
        if((!empty($this->_width)) || (!empty($this->_height)))
            $path[] = "{$this->_width}x{$this->_height}";

        // add misk params as a hash
        $miscParams = array(
            ($this->_keepAspectRatio  ? '' : 'non') . 'proportional',
            ($this->_keepFrame        ? '' : 'no')  . 'frame',
            ($this->_keepTransparency ? '' : 'no')  . 'transparency',
            ($this->_constrainOnly ? 'do' : 'not')  . 'constrainonly',
            $this->_rgbToString($this->_backgroundColor),
            'angle' . $this->_angle,
            'quality' . $this->_quality
        );

        // if has watermark add watermark params to hash
        if ($this->getWatermarkFile()) {
            $miscParams[] = $this->getWatermarkFile();
            $miscParams[] = $this->getWatermarkImageOpacity();
            $miscParams[] = $this->getWatermarkPosition();
            $miscParams[] = $this->getWatermarkWidth();
            $miscParams[] = $this->getWatermarkHeigth();
        }

        $path[] = md5(implode('_', $miscParams));

        // append prepared filename
        $this->_newFile = implode('/', $path) . $file; // the $file contains heading slash

        return $this;
    }

    public function isCached()
    {
        return true;
    }
}
<?php
class GAE_Core_Model_Design_Package extends Mage_Core_Model_Design_Package
{
    /**
     * Disabling failover because materialization is provided
     *
     * @param string $file
     * @param array $params
     * @return string
     */
    public function getSkinUrl($file = null, array $params = array())
    {
        $this->_shouldFallback = false;
        $url = parent::getSkinUrl($file, $params);
        $this->_shouldFallback = true;
        return $url;
    }

    /**
     * mkdir is not wrapped
     *
     * @return bool
     */
    public function cleanMergedJsCss()
    {
        return true;
    }

}
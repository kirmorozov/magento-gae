<?php

class GAE_Core_Model_Config extends Mage_Core_Model_Config
{
    /**
     * Class construct
     *
     * @param mixed $sourceData
     */
    public function __construct($sourceData = null)
    {

        $this->setCacheId('config_global');
        $this->_options = new GAE_Core_Model_Config_Options($sourceData);
        $this->_prototype = new Mage_Core_Model_Config_Base();
        $this->_cacheChecksum = null;
        Mage_Core_Model_Config_Base::__construct($sourceData);

    }

    /**
     * Load base system configuration (config.xml and local.xml files)
     *
     * @return Mage_Core_Model_Config
     */
    public function loadBase()
    {
        $etcDir = $this->getOptions()->getEtcDir();
        $files = $this->_getXmlFiles($etcDir);

        $this->loadFile(current($files));
        while ($file = next($files)) {
            $merge = clone $this->_prototype;
            $merge->loadFile($file);
            $this->extend($merge);
        }

        if (in_array($etcDir . DS . 'local.xml', $files)) {
            $this->_isLocalConfigLoaded = true;
        }

        // Inject GAE etc xml files
        $files = $this->_getXmlFiles(GAE_ROOT . '/etc');
        foreach ($files as $file) {
            $merge = clone $this->_prototype;
            $merge->loadFile($file);
            $this->extend($merge);
        }

        return $this;
    }


    /**
     * Retrive Declared Module file list
     *
     * @return array
     */
    protected function _getDeclaredModuleFiles()
    {
        $etcDir = $this->getOptions()->getEtcDir();
        $moduleFiles = $this->_getXmlFiles($etcDir . DS . 'modules');

        if (!$moduleFiles) {
            return false;
        }

        $collectModuleFiles = array(
            'base' => array(),
            'mage' => array(),
            'custom' => array()
        );

        foreach ($moduleFiles as $v) {
            $name = explode(DIRECTORY_SEPARATOR, $v);
            $name = substr($name[count($name) - 1], 0, -4);

            if ($name == 'Mage_All') {
                $collectModuleFiles['base'][] = $v;
            } else if (substr($name, 0, 5) == 'Mage_') {
                $collectModuleFiles['mage'][] = $v;
            } else {
                $collectModuleFiles['custom'][] = $v;
            }
        }

        return array_merge(
            $collectModuleFiles['base'],
            $collectModuleFiles['mage'],
            $collectModuleFiles['custom']
        );
    }

    /**
     * Utility function as a replacement for glob()
     *
     * @param string $path
     * @return array
     */
    protected function _getXmlFiles($path)
    {
        $files = array();
        $d = dir($path);
        while (false !== ($entry = $d->read())) {
            if (substr($entry, -4) == '.xml') {
                $files[] = $path . DS . $entry;
            }
        }
        $d->close();

        return $files;
    }
}
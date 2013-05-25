<?php

class GAE_Core_Model_Config extends Mage_Core_Model_Config
{
    /**
     * Class construct
     *
     * @param mixed $sourceData
     */
    public function __construct($sourceData=null)
    {
        $this->setCacheId('config_global');
        $this->_options         = new GAE_Core_Model_Config_Options($sourceData);
        $this->_prototype       = new Mage_Core_Model_Config_Base();
        $this->_cacheChecksum   = null;
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
        if (in_array($etcDir.DS.'local.xml', $files)) {
            $this->_isLocalConfigLoaded = true;
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
            'base'   => array(),
            'mage'   => array(),
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
     * Get default server variables values
     *
     * @return array
     */
    public function getDistroServerVars()
    {
        if (!$this->_distroServerVars) {

            if (isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['HTTP_HOST'])) {
                $secure = (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS']!='off')) ;
                $scheme = ($secure ? 'https' : 'http') . '://' ;
                $path = Mage::app()->getRequest()->getBasePath();

                $baseUrl = $scheme.$_SERVER['HTTP_HOST'].rtrim($path, '/').'/';
            } else {
                $baseUrl = 'http://localhost/';
            }

            $options = $this->getOptions();
            $this->_distroServerVars = array(
                'root_dir'  => $options->getBaseDir(),
                'app_dir'   => $options->getAppDir(),
                'var_dir'   => $options->getVarDir(),
                'base_url'  => $baseUrl,
            );

            foreach ($this->_distroServerVars as $k=>$v) {
                $this->_substServerVars['{{'.$k.'}}'] = $v;
            }
        }
        return $this->_distroServerVars;
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
            if (substr($entry,-4) == '.xml') {
                $files[] = $path.DS.$entry;
            }
        }
        $d->close();

        return $files;
    }
}

class GAE_Core_Model_Config_Options extends Varien_Object
{

    public function _construct()
    {
        $root = $this->_data['base_dir'];
        $appRoot = $root.DS.'app';
        $this->_data['app_dir']     = $appRoot;
        $this->_data['code_dir']    = $appRoot.DS.'code';
        $this->_data['design_dir']  = $appRoot.DS.'design';
        $this->_data['etc_dir']     = $appRoot.DS.'etc';
        $this->_data['lib_dir']     = $root.DS.'lib';
        $this->_data['locale_dir']  = $appRoot.DS.'locale';
        $this->_data['skin_dir']    = $root.DS.'skin';
        $this->_data['tmp_dir']     = $this->_data['var_dir'].DS.'tmp';
        $this->_data['cache_dir']   = $this->_data['var_dir'].DS.'cache';
        $this->_data['log_dir']     = $this->_data['var_dir'].DS.'log';
        $this->_data['session_dir'] = $this->_data['var_dir'].DS.'session';
        $this->_data['upload_dir']  = $this->_data['media_dir'].DS.'upload';
        $this->_data['export_dir']  = $this->_data['var_dir'].DS.'export';
    }


    public function getDir($type)
    {
        $name = $type.'_dir';
        return (isset($this->_data[$name]))?$this->_data[$name]:null;
    }
}

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

}


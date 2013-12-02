<?php


class GAE_Core_Model_Config_Options extends Varien_Object
{

    public function _construct()
    {
        $root = $this->_data['base_dir'];
        $appRoot = $root . DS . 'app';
        $this->_data['app_dir'] = $appRoot;
        $this->_data['code_dir'] = $appRoot . DS . 'code';
        $this->_data['design_dir'] = $appRoot . DS . 'design';
        $this->_data['etc_dir'] = $appRoot . DS . 'etc';
        $this->_data['lib_dir'] = $root . DS . 'lib';
        $this->_data['locale_dir'] = $appRoot . DS . 'locale';
        $this->_data['skin_dir'] = $root . DS . 'skin';
        $this->_data['tmp_dir'] = $this->_data['var_dir'] . DS . 'tmp';
        $this->_data['cache_dir'] = $this->_data['var_dir'] . DS . 'cache';
        $this->_data['log_dir'] = $this->_data['var_dir'] . DS . 'log';
        $this->_data['session_dir'] = $this->_data['var_dir'] . DS . 'session';
        $this->_data['upload_dir'] = $this->_data['media_dir'] . DS . 'upload';
        $this->_data['export_dir'] = $this->_data['var_dir'] . DS . 'export';
    }


    public function getDir($type)
    {
        $name = $type . '_dir';
        return (isset($this->_data[$name])) ? $this->_data[$name] : null;
    }
}

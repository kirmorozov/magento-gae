<?php

//Fix xml issue for Magento
libxml_disable_entity_loader(false);

// Add SCRIPT_NAME
if (!isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['SCRIPT_NAME'] = '/' . $_SERVER['SCRIPT_FILENAME'];
}

// Add lib to includes
set_include_path(__DIR__ . '/lib' . PATH_SEPARATOR . get_include_path());

//actual config
$gaeConfig = array(
    'config_model' => 'GAE_Core_Model_Config',
    'base_dir' => __DIR__ . '/magento',
    'var_dir' => 'gs://mage-gae/v1/var',
    'media_dir' => 'gs://mage-gae/v1/media',
);
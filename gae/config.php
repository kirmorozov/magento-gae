<?php
$gaeConfig = array(
    'config_model' => 'GAE_Core_Model_Config',
    'base_dir' => dirname(__DIR__),
    'var_dir' => 'gs://magento-gae/version/0/var',
    'media_dir' => 'gs://magento-gae/version/0/media',
);

$_SERVER['SCRIPT_NAME'] = substr($_SERVER['SCRIPT_NAME'],3); //Pretend you are in root location

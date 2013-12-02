<?php

include 'config.php';
require 'magento/app/Mage.php';

if (!Mage::isInstalled()) {
    echo "Application is not installed yet, please complete install wizard first.";
    exit;
}

// Only for urls
// Don't remove this
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__DIR__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__DIR__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app('admin', 'store', $gaeConfig )->setUseSessionInUrl(false);

umask(0);

try {
    Mage::getConfig()->init()->loadEventObservers('crontab');
    Mage::app()->addEventArea('crontab');
    Mage::dispatchEvent('default');
} catch (Exception $e) {
    Mage::printException($e);
}

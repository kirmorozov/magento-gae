<?php
//Fix xml issue
libxml_disable_entity_loader(false);

exec('rm -rf "'.__DIR__ . '/var/skin/'.'"');

$xml = simplexml_load_file('etc/materialize.xml');
$res = $xml->xpath('materialize/*');

echo "<pre>";
foreach ($res as $xmlElement) {
    foreach ($xmlElement->children() as $type) {
        $paths = explode(',', (string)$type);
        $last = end($paths);
        mkdir(dirname(__DIR__ . '/var/skin/' . $xmlElement->getName() . '/' . $last), 0777, true);
        foreach ($paths as $path) {
            echo exec('cp -rf "' .
                (__DIR__ . '/magento/skin/' . $xmlElement->getName() . '/' . $path) .
                '" "' .
                (__DIR__ . '/var/skin/' . $xmlElement->getName() . '/' . $last) .
            '"');

        }
        echo "Generated {$xmlElement->getName()}  \t: $last \n";
    }
}

echo "DONE!";
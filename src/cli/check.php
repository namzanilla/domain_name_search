<?php

declare(strict_types=1);

$domain = getopt('d:')['d'] ?? null;
require __DIR__.'/../../vendor/autoload.php';

use Helge\Loader\JsonLoader;
use Helge\Client\SimpleWhoisClient;
use Helge\Service\DomainAvailability;

$whoisClient = new SimpleWhoisClient();
$dataLoader = new JsonLoader(__DIR__.'/../../vendor/helgesverre/domain-availability/src/data/servers.json');

$service = new DomainAvailability($whoisClient, $dataLoader);

try {
  if ($service->isAvailable($domain)) {
    echo "Domain $domain is available",PHP_EOL;
  } else {
    echo "Domain $domain is already taken!",PHP_EOL;
  }
} catch (\Exception $e) {
  echo $e->getMessage(),PHP_EOL;
}

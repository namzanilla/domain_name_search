<?php

declare(strict_types=1);

$longopts  = array(
  "length::",     // Required value
  "prefix::",    // Optional value
  "tld::",    // Optional value
  "noNumbers",        // No value
//  "opt",           // No value
);

$options = getopt('', $longopts) ?? null;
$options = (object)$options;

if (isset($options->prefix)) {
  $options->length -= strlen($options->prefix);
}

require __DIR__.'./../../vendor/autoload.php';

use \drupol\phpermutations\Generators\Permutations;

$letters = range('a', 'z');
$numbers = range(0, 9);

if (isset($options->noNumbers)) {
  $dataset = array_merge($letters, $letters);
} else {
  $dataset = array_merge($letters, $numbers);
}

$permutations = new Permutations($dataset, $options->length);

foreach ($permutations->generator() as $permutation) {
  $domain = implode('', $permutation).'.'.$options->tld;

  if (isset($options->prefix)) {
    $domain = $options->prefix.$domain;
  }

  exec('php '.__DIR__.'/check.php -d'.$domain, $output);

  if ("Domain $domain is already taken!" !== $output[0]) {
    echo $domain,PHP_EOL;
  }

  unset($output);
}

<?php

declare(strict_types=1);

$longopts  = array(
  "length::",     // Required value
  "prefix::",    // Optional value
  "postfix::",    // Optional value
  "tld::",    // Optional value
  "noNumbers",        // No value
//  "opt",           // No value
);

$options = getopt('', $longopts) ?? null;
$options = (object)$options;

if (isset($options->prefix)) {
  $options->length -= strlen($options->prefix);
} elseif (isset($options->postfix)) {
  $options->length -= strlen($options->postfix);
}

$tmp_filename = date('Y-m-d_h:i:s').'.log';
$file = __DIR__.'/../../tmp/'.$tmp_filename;
exec("touch $file");

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
  $domain_name = implode('', $permutation);

  if (isset($options->prefix)) {
    $domain = $options->prefix.$domain_name.'.'.$options->tld;
  } elseif (isset($options->postfix)) {
    $domain = $domain_name.$options->postfix.'.'.$options->tld;
  } else {
    $domain = $domain_name.'.'.$options->tld;
  }

  exec('php '.__DIR__.'/check.php -d'.$domain, $output);

  if ("Domain $domain is already taken!" !== $output[0]) {
    echo $domain,PHP_EOL;
    exec("echo $domain >> ".$file);
  }

  unset($output);
}

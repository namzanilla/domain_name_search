<?php

declare(strict_types=1);

namespace Namzanilla\DomainNameSearch\Helpers;

require __DIR__.'/DomainIs.class.php';

use Namzanilla\DomainNameSearch\Helpers\DomainIs;

class Domain {
  public static function is(): object {
    return new DomainIs;
  }
}

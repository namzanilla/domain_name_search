<?php

declare(strict_types=1);

namespace Namzanilla\DomainNameSearch\Helpers;

class DomainIs {
  public function valid($domain): bool {
    if (!is_string($domain)) return false;

    return true;
  }
}

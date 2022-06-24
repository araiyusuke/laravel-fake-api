<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

class Guard 
{
    static function let(?string &$nullable): bool
    {

      if (is_null($nullable)) { return true; }

      (string) $nullable;
     
      return false;
    }

}

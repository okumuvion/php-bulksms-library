<?php

namespace App\Validation;

class PurifierRules
{
    public function purify_string(string $str, string $profile = 'relaxed'): string
    {
        $purifier = service('purifier', $profile);
        return $purifier->purify($str);
    }
}

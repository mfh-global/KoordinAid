<?php

namespace App\Boxtribute\Queries;

use App\Boxtribute\Queries\GraphQl;

class Locations extends GraphQl
{
    protected string $operationName = "locations";

    protected function getQuery(): string
    {
        return <<<'EOD'
            query locations {
                locations {
                id
                name
                defaultBoxState
                }
            }
        EOD;
    }
}

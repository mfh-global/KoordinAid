<?php

namespace App\Boxtribute\Queries;

use App\Boxtribute\Queries\GraphQl;

class Products extends GraphQl
{
    protected string $operationName = "products";

    protected function getQuery(): string
    {
        return <<<'EOD'
            query products($paginationInput: PaginationInput) {
                products(paginationInput: $paginationInput) {
                elements {
                    id
                    name
                    gender
                    comment
                    deletedOn
                    category {
                        id
                        name
                    }
                    sizeRange {
                        id
                        label
                        sizes {
                            id
                            label
                        }
                    }
                }
                pageInfo {
                    hasNextPage
                    endCursor
                }
                totalCount
                }
            }
        EOD;
    }
}
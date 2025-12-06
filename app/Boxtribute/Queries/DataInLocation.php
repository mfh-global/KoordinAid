<?php

namespace App\Boxtribute\Queries;

use App\Boxtribute\Queries\GraphQl;

class DataInLocation extends GraphQl
{
    protected string $operationName = "DataInLocation";

    protected function getQuery(): string {
        return <<<'EOD'
            query DataInLocation($id: ID!, $paginationInput: PaginationInput) {
                location(id: $id) {
                    id
                    name
                    base {
                        id
                        name
                    }
                    defaultBoxState
                    boxes(paginationInput: $paginationInput) {
                        elements {
                        id
                        product {
                            id
                            name
                            gender
                        }
                        size {
                            id
                            label
                        }
                        numberOfItems
                        comment
                        tags {
                            id
                            name
                        }
                        }
                        totalCount
                        pageInfo {
                            hasNextPage
                            endCursor
                          }
                    }
                }
            }
        EOD;
    }
}

<?php

namespace App\Boxtribute\Queries;

use App\Boxtribute\Queries\GraphQl;

class Location extends GraphQl
{
    protected string $operationName = "location";

    protected function getQuery(): string
    {
        return <<<'EOD'
        query location($id: ID!, $paginationInput: PaginationInput) {
            location(id: $id) {
              id
              name
              isShop
              isStockroom
              boxes(paginationInput: $paginationInput) {
                totalCount
                pageInfo {
                  hasNextPage
                  endCursor
                }
                elements {
                  size {
                    id
                  }
                  comment
                  labelIdentifier
                  state
                  id
                  numberOfItems
                  history {
                    changes
                  }
                  product {
                    id
                  }
                }
              }
              defaultBoxState
            }
        }
        EOD;
    }
}

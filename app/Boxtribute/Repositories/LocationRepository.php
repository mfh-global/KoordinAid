<?php

namespace App\Boxtribute\Repositories;

use App\Boxtribute\Queries\DataInLocation;
use App\Boxtribute\Queries\Locations;
use App\Boxtribute\BoxtributePaginationInput;


class LocationRepository
{
    public function __construct(
        private readonly DataInLocation $dataInLocation,
        private readonly Locations $locationsQuery
    ) {
    }

    public function getLocations()
    {
        return $this->locationsQuery->execute()['data']['locations']; 
    }

    public function getDataInLocation(int $id, BoxtributePaginationInput $paginationInput): array { 
        return $this->dataInLocation->execute(['id' => $id, ...($paginationInput)->getInput()])['data']['location']['boxes'];

    }
}

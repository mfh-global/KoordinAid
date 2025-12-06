<?php

namespace App\Boxtribute\Queries;

use App\Boxtribute\BoxtributeAuthenticator;
use Illuminate\Support\Facades\Http;

abstract class GraphQl
{
    private string $boxtributeEndpoint;

    protected string $operationName;

    abstract protected function getQuery(): string;

    public function __construct(private BoxtributeAuthenticator $authenticator)
    {
        $this->boxtributeEndpoint = config('boxtribute.api_endpoint');
    }

    protected function load(?array $variables): array {
        $query = [
            'query' => $this->getQuery(),
            'operationName' => $this->operationName
        ];

        if ($variables) {
            $query['variables'] = $variables;
        }
        
        return $query;
    }

    public function execute(?array $variables = null)
    {
        $response = Http::withHeaders($this->authenticator->getAuth())
            ->post($this->boxtributeEndpoint, $this->load($variables));
    
        if ($response->status() !== 200) {
            throw new \RuntimeException(
                "Error while getting data from Boxtribute status: {$response->status()} error: {$response->body()}"
            );
        }

        return $response->json();
    }
}

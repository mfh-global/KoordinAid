<?php

namespace App\Boxtribute;

class BoxtributePaginationInput
{
    public function __construct(
        public readonly int $first,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
        public readonly ?int $last = null
    ) {}

    public function getInput(): array
    {
        return [
            'paginationInput' => [
                'first' => $this->first,
                'after' => $this->after,
                'before' => $this->before,
                'last' => $this->last
            ]
        ];
    }
}

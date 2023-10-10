<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\State;

use ApiPlatform\State\Pagination\PaginatorInterface;
use IteratorAggregate;
use Traversable;


/**
 * @template T of object
 *
 * @implements PaginatorInterface<T>
 * @implements IteratorAggregate<T>
 */
final readonly class Paginator implements PaginatorInterface, IteratorAggregate
{

    /**
     * @param Traversable<T> $items
     */
    public function __construct(
        private Traversable $items,
        private float       $currentPage,
        private float       $itemsPerPage,
        private float       $lastPage,
        private float       $totalItems,
    ) {
    }
    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        return $this->items;
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->itemsPerPage;
    }

    public function getLastPage(): float
    {
       return $this->lastPage;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }
}
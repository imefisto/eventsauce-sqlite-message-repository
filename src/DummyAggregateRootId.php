<?php
namespace Imefisto\EventSauceSqliteMessageRepository;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

final class DummyAggregateRootId implements AggregateRootId
{
    private function __construct(private string $uuid)
    {
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }

    public static function generate(): DummyAggregateRootId
    {
        return new self(Uuid::uuid7()->toString());
    }
}

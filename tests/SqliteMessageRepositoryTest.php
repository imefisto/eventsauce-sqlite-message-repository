<?php
namespace Imefisto\EventSauceSqliteMessageRepository\Testing;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\MessageRepository\TestTooling\MessageRepositoryTestCase;
use Imefisto\EventSauceSqliteMessageRepository\DefaultConnectionManager;
use Imefisto\EventSauceSqliteMessageRepository\DummyAggregateRootId;
use Imefisto\EventSauceSqliteMessageRepository\SqliteMessageRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers SqliteMessageRepository
 */
class SqliteMessageRepositoryTest extends MessageRepositoryTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function messageRepository(): MessageRepository
    {
        $tableName = 'domain_messages_uuid';
        $connectionManager = new DefaultConnectionManager($tableName);
        $connectionManager->get()->exec('DELETE FROM ' . $tableName);

        return new SqliteMessageRepository(
            $connectionManager,
            $this->tableName,
            new ConstructingMessageSerializer()
        );
    }

    protected function aggregateRootId(): AggregateRootId
    {
        return DummyAggregateRootId::generate();
    }

    protected function eventId(): string
    {
        return Uuid::uuid7()->toString();
    }
}

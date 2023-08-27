<?php
namespace Imefisto\EventSauceSqliteMessageRepository;

class DefaultConnectionManager implements ConnectionManager
{
    private $db;

    public function __construct(string $tableName, string $filePath = '')
    {
        $path = !empty($filePath) ? $filePath : ':memory:';
        $this->db = new \PDO('sqlite:' . $path);
        $this->createTableIfNotExists($tableName);
    }

    private function createTableIfNotExists(string $tableName)
    {
        $sql = <<<END
CREATE TABLE IF NOT EXISTS $tableName (
    id INTEGER PRIMARY KEY,
    event_id BLOB,
    aggregate_root_id BLOB,
    version INTEGER,
    payload TEXT)
END ;

        $this->db->exec($sql);

        $sql = <<<END
CREATE INDEX IF NOT EXISTS reconstitution on $tableName(aggregate_root_id, version)
END;

        $this->db->exec($sql);
    }

    public function get(): \PDO
    {
        return $this->db;
    }

    public function done($conn): void
    {
        return;
    }
}

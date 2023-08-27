<?php
namespace Imefisto\EventSauceSqliteMessageRepository;

interface ConnectionManager
{
    public function get(): object;
    public function done(object $conn): void;
}

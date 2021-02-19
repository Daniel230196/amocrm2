<?php

namespace entities;


class Entity
{
    protected int $id;
    protected string $path;
    protected array $data;
    protected \ApiConnection $connection;

    public function __construct(\ApiConnection $connection)
    {
        $this->connection = $connection;
    }

    protected function embed(array $data, string $type): array
    {

    }

    public function getData() : array
    {
        return $this->data;
    }
    public function getPath() : string
    {
        return $this->path;
    }

    private function count(array &$data) : int
    {

    }
}
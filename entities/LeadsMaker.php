<?php


namespace entities;

/*
 * Создает сущности сделок и формирует из них список
 * */
class LeadsMaker extends EntityMaker
{
    /*
     * Список сделок
     * */
    protected array $data;
    protected string $path = '/api/v8/leads';

    public function __construct()
    {
        parent::__construct();
    }
    public function makeEntity(): Leads
    {
        return new Leads();
    }
    public function addComplex()
    {
        $res = $this->connection->add($this);
    }
}
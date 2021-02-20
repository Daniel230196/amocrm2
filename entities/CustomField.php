<?php


namespace entities;


use core\ApiConnection;

class CustomField
{
    public int $entityId;
    public int $id;
    public string $type;
    public array $data;
    public $paramsData;
    protected $fields;
    protected ApiConnection $api;

    public function __construct(array $params)
    {
        $this->entityId = $params['id'];
        $this->api= ApiConnection::getInstance();
        $this->type = $params['type'];
        $this->id = $this->fields[$this->type];
        $this->paramsData = $params['data'];
        $this->data = [[
            'id' => $this->entityId,
            'custom_fields_values' => [[
                'field_id' => $this->id,
                'values' => [[
                    'value' => $this->paramsData
                ]]
            ]]
        ]];
    }

    public function getData() : array
    {
        return $this->data;
    }

}
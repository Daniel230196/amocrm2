<?php


namespace entities;


use core\ApiConnection;
use core\FileCreatorInterface;

/*
 * Класс, реализующий экспорт сущностей сделок
 * */
class LeadsExporter implements ExporterInterface
{
    private array $data;
    private FileCreatorInterface $creator;
    private ApiConnection $api;
    private array $leadsId;
    private array $columns = [
        ['name', 'created', 'company','contact','tags','custom fields'],
    ];

    public function __construct(array $data, FileCreatorInterface $creator)
    {
        $this->leadsId = $data['id'];
        $this->creator = $creator;
        $this->api = ApiConnection::getInstance();
    }

    public function getAllData() : array
    {
       return $this->columns;
    }

    public function export()
    {
        $leads = $this->api->get('leads', $this->formUri());
        $leads = json_decode($leads, true)['_embedded']['leads'];
        $this->extract($leads);

        $this->creator->create($this);
        //return $leads;
    }

    private function formUri(): string
    {
        $uri = 'api/v4/leads?';

        foreach ($this->leadsId as $key => $item) {
            $uri .= 'filter[id][]=' . $item . '&';
        }
        return $uri . 'with=companies,contacts';
    }

    private function extract(array $leads)
    {
        for ($i = 0; $i < count($leads); ++$i) {
            $this->data[$i]['name'] = $leads[$i]['name'];
            $this->data[$i]['created'] = date("Y-m-d H:i:s", $leads[$i]['created_at']);
            $this->data[$i]['company'] = $leads[$i]['_embedded']['companies'][0]['id'];
            $this->data[$i]['contact'] = $leads[$i]['_embedded']['contacts'][0]['id'];
            $this->data[$i]['tags'] = $leads[$i]['_embedded']['tags'];
            if (!is_null($leads[$i]['custom_fields_values'])){
                $this->data[$i]['custom_fields'] = $this->extractCustomFields($leads[$i]['custom_fields_values']);
            }
        }
        $this->intersect();

        $j = 1;
       foreach ($this->data as $value){
           $x = count($value);
           for($i=1; $i <= $x; $i++){
               $res[$i] = array_shift($value);
           }
           $this->columns[$j] = $res;
           ++$j;

        }


    }

    private function extractCustomFields(array $customFields) : array
    {
        $fields = [];
        for ($i=0; $i<count($customFields); $i++){
            $fields[$i]['name'] = $customFields[$i]['field_name'];
            $fields[$i]['value'] = $customFields[$i]['values'][0]['value'];
        }
        return $fields;
    }

    private function entityList() : array
    {
        $comp = json_decode($this->api->get('companies'),true)['_embedded']['companies'];
        $contacts = json_decode($this->api->get('contacts'), true)['_embedded']['contacts'];
        $new = [];
        $callback = function ($value) use (&$new){
            return $new[$value['id']] = $value['name'];
        };

        array_map($callback,$comp);
        array_map($callback,$contacts);
        return $new;
    }

    private function intersect()
    {
        $boundEntities = $this->entityList();
        foreach($this->data as &$value){
            $value['company'] = $boundEntities[$value['company']];
            $value['contact'] = $boundEntities[$value['contact']];
        }
    }
}
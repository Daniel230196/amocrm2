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
        ['Name', 'Created', 'Company','Contact','Tags','Custom fields'],
    ];

    public function __construct(array $data, FileCreatorInterface $creator)
    {
        $this->leadsId = array_map('intval', $data['id']);
        $this->creator = $creator;
        $this->api = ApiConnection::getInstance();
    }

    /*
     * Метод возвращает отформатироанные данные для создания файла
     * */
    public function getAllData() : array
    {
       return $this->columns;
    }

    /*
     * Основной метод класса.
     * Создание файла через обращение к CsvCreator
     * */
    public function export()
    {
        $leads = $this->api->get('leads', $this->formUri());
        $leads = json_decode($leads, true)['_embedded']['leads'];
        $this->extract($leads);
        $this->creator->create($this);
    }

    /*
     * Метод, формирующий строку запроса для API
     * */
    private function formUri(): string
    {
        $uri = 'api/v4/leads?';

        foreach ($this->leadsId as $key => $item) {
            $uri .= 'filter[id][]=' . $item . '&';
        }
        return $uri . 'with=companies,contacts';
    }

    /*
     * Метод, "упаковывающий" данные в нужном формате
     * */
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

    /*
     * Вспомогательный метод, для форматирования
     * кастомных полей сущности
     * */
    private function extractCustomFields(array $customFields) : array
    {
        $fields = [];
        for ($i=0; $i<count($customFields); $i++){
            $fields[$i]['name'] = $customFields[$i]['field_name'];
            $fields[$i]['value'] = $customFields[$i]['values'][0]['value'];
        }

        return $fields;
    }

    /*
     * Метод возвращает список контактов и сделок
     * (только name & id)
     * */
    private function entityList() : array
    {
        $comp = json_decode($this->api->get('companies', 'api/v4/companies?limit=10000'),true)['_embedded']['companies'];
        $contacts = json_decode($this->api->get('contacts', 'api/v4/contacts?limit=10000'), true)['_embedded']['contacts'];
        $new = [];
        $callback = function ($value) use (&$new){
            return $new[$value['id']] = $value['name'];
        };

        array_map($callback,$comp);
        array_map($callback,$contacts);
        return $new;
    }

    /*
     * Метод вычисляет схождение седлок и контактов с основным массивом по ID
     * */
    private function intersect()
    {
        $boundEntities = $this->entityList();

        foreach($this->data as &$value){

            $value['company'] = $boundEntities[$value['company']];
            $value['contact'] = $boundEntities[$value['contact']];
            echo '<pre>';
            var_dump($value['company']);
            echo '</pre>';
        }
    }
}
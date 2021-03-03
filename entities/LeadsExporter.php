<?php


namespace entities;


use core\ApiConnection;
use core\FileCreatorInterface;


/*
 * Класс, реализующий экспорт сущностей сделок
 * */
class LeadsExporter implements ExporterInterface
{
    /*
     * Вспомогательный массив с Id и именами кастомных полей
     * */
    private static array $fields;

    /*
     * Массив с промежуточными данными
     * */
    private array $data;

    /*
     * Объект, генерирующий файл
     * */
    private FileCreatorInterface $creator;

    /*
     * Объект для подключения к АПИ
     * */
    private ApiConnection $api;

    /*
     * Массив id сделок для запроса
     * */
    private array $leadsId;

    /*
     * Основной массив данных для генерации файла
     * */
    private array $columns = [
        ['ID', 'Название сделки', 'Бюджет', 'Ответственный', 'Дата создания сделки', 'Кем создана сделка', 'Дата редактирования', 'Кем редактирована', 'Дата закрытия', 'Теги', 'Полное имя контакта', 'Компания контакта', 'Ответственный за контакт', 'Компания']
    ];
    const RESPONSABLE = 'Даниил';

    public function __construct(array $data, FileCreatorInterface $creator)
    {
        $this->leadsId = array_map('intval', $data['id']);
        $this->creator = $creator;
        $this->api = ApiConnection::getInstance();
    }

    /*
     * Метод возвращает отформатироанные данные для создания файла
     * */
    public function getAllData(): array
    {
        return $this->columns;
    }

    /*
     * Основной метод класса.
     * Делегирование создания файла объекту CsvCreator
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

            if ($i & 1) {
                usleep(200);
            }

            $this->data[$i]['ID'] = $leads[$i]['id'];
            $this->data[$i]['Название сделки'] = $leads[$i]['name'];
            $this->data[$i]['Бюджет'] = $leads[$i]['price'];
            $this->data[$i]['Ответственный'] = self::RESPONSABLE;
            $this->data[$i]['Дата создания сделки'] = date("Y-m-d H:i:s", $leads[$i]['created_at']);
            $this->data[$i]['Кем создана сделка'] = self::RESPONSABLE;
            $this->data[$i]['Дата редактирования'] = date('Y-m-d H:i:s', $leads[$i]['updated_at']);
            $this->data[$i]['Кем редактирована'] = self::RESPONSABLE;
            $this->data[$i]['Дата закрытия'] = is_null($leads[$i]['closed_at']) ? '' : date('Y-m-d H:i:s', $leads[$i]['closed_at']);
            $this->data[$i]['Теги'] = $this->extractTags($leads[$i]['_embedded']['tags']);
            $this->data[$i]['Полное имя контакта'] = $this->getName($leads[$i]['_embedded'], 'contacts');
            $this->data[$i]['Компания контакта'] = $this->getName($leads[$i]['_embedded'], 'companies');
            $this->data[$i]['Ответственный за контакт'] = self::RESPONSABLE;
            $this->data[$i]['Компания'] = $this->data[$i]['Компания контакта'];

            if (!is_null($leads[$i]['custom_fields_values'])) {
                $fieldsData = $this->extractCustomFields($leads[$i]['custom_fields_values']);
                foreach ($fieldsData as $field) {
                    $x = array_search($field['id'], $this->columns[0]);

                    $fieldName = $this->getCustomFieldName($field['id']);
                    self::$fields[$field['id']] = $fieldName;
                    $this->data = array_map('array_values', $this->data);

                    $this->data[$i][$x] = $field['value'];


                }

            }

            //$this->data = array_map('array_values', $this->data);

        }

        foreach ($this->columns[0] as &$value) {
            if (isset(self::$fields)) {
                $value = self::$fields[$value] ? self::$fields[$value] : $value;
            }
        }

        foreach ($this->data as &$item) {
            $headerCount = count($this->columns[0]);

            $res = [];
            for ($i = 0; $i < $headerCount; ++$i) {
                $res[$i] = empty($item[$i]) ? '' : $item[$i];
            }

            $item = $res;
        }

        $this->columns = array_merge($this->columns, $this->data);
    }

    /*
     * Метод возвращает имя сущности по указанному ID
     * */
    private function getName(array $contacts, string $type): string
    {
        $id = $contacts[$type][0]['id'];
        $entity = $this->api->get($type, 'api/v4/' . $type . '/' . $id);
        return json_decode($entity, true)['name'];
    }

    /*
     * Метод возвращает имя кастомного поля по ID
     * */
    private function getCustomFieldName(int $id)
    {
        $field = json_decode($this->api->get('leads', 'api/v4/leads/custom_fields/' . $id), true);
        return $field['name'];
    }

    /*
     * Метод для форматирования тегов сущности
     * */
    private function extractTags($tags): string
    {
        if (count($tags) < 1) {
            return '';
        }
        $result = '';
        foreach ($tags as $tag) {
            $result .= $tag['name'] . ',';
        }

        $result = substr($result, 0, -1);
        return $result;
    }

    /*
     * Вспомогательный метод, для форматирования
     * кастомных полей сущности
     * */
    private function extractCustomFields(array $customFields): array
    {
        $fields = [];

        for($i = 0; $i < count($customFields); $i++) {

            $fields[$i]['id'] = $customFields[$i]['field_id'];

            if($customFields[$i]['field_type'] == 'multiselect'){

                $fields[$i]['value'] = $this->extractMultiSelect($customFields[$i]);
            }else{
                $fields[$i]['value'] = $customFields[$i]['values'][0]['value'];
            }

            if (!in_array($fields[$i]['id'], $this->columns[0])) {

                array_push($this->columns[0], $fields[$i]['id']);

            }
        }
        return $fields;
    }

    /*
     * Вспомогательный метод для форматирования доп поля мультисписок
     * */
    private function extractMultiSelect(array $multi) : string
    {
        $values = $multi['values'];
        $res = [];
        foreach ($values as $value){
            $res[] = $value['value'];
        }
        return implode(',', $res);
    }

    private function getCustomValues()
    {

    }
}
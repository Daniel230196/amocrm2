<?php


namespace entities;

/*
 * Класс текстового примечания
 * */
class CommonNote extends BaseNote
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->data[0]['params']['text'] = 'common text note';
    }
}
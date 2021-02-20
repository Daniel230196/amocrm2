<?php


namespace core;


interface ApiRequestInterface
{
    public function addComplex();
    public function getBoundedList() : array;
    public function bindCustomers(array $response);
}
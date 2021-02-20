<?php


namespace core;


interface CustomerBinderInterface
{
    public function bindCustomers(array $apiResponse);
}
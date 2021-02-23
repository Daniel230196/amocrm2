<?php


namespace entities;

/*
 *
 * Интерфейс для полей, заполняемых методом PATCH
 * */
interface FIllableInterface
{
    public function getData() : array ;
    public function patch() ;
}
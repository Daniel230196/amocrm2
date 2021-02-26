<?php


namespace core;


use entities\ExporterInterface;


interface FileCreatorInterface
{
    public static function create(ExporterInterface $exporter);
}
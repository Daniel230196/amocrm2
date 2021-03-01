<?php


namespace core;


use entities\ExporterInterface;


interface FileCreatorInterface
{
    public function create(ExporterInterface $exporter);
}
<?php

namespace App\Contracts;

interface FilterRepositoryInterface
{
    public function filterBy1Prop($model, $query, $limit, $prop1);

    public function filterBy1PropWithCount($model, $query, $limit, $countObj, $prop1);

    public function filterBy4Prop($model, $query, $limit, $prop1, $prop2, $prop3, $prop4);

    public function filterBy4PropWithCount($model, $query, $limit, $countObj, $prop1, $prop2, $prop3, $prop4);

    // public function filterBy2Prop($model, $query, $limit, $prop1, $prop2);

    // public function filterBy2PropWithCount($model, $query, $limit, $countObj, $prop1, $prop2);

    // public function filterBy3Prop($model, $query, $limit, $prop1, $prop2, $prop3);

    // public function filterBy3PropWithCount($model, $query, $limit, $countObj, $prop1, $prop2, $prop3);
}
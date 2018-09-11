<?php

namespace Model;

class Employees extends \App\Core\Model\SimpleModel
{
    public function __construct(Resource\Employees $_resourceModel)
    {
        parent::__construct($_resourceModel);
    }
}
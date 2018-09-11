<?php

namespace Model;
class Student extends \App\Core\Model\SimpleModel
{
    public function __construct(Resource\Student $_resourceModel)
    {
        parent::__construct($_resourceModel);
    }
}
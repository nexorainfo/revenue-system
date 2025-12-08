<?php

namespace App\Http\Controllers;

use App\Traits\BaseControllerTrait;

abstract class Controller
{
    use BaseControllerTrait;
    public function __construct()
    {
        $this->constructionMethod();
    }
}

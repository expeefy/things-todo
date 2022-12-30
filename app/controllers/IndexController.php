<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->tasks = Tasks::find();
    }

}



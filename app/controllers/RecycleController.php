<?php

use Phalcon\Mvc\Controller;


class RecycleController extends Controller
{
    public function indexAction()
    {
        $this->view->tasks = Tasks::find();
    }
}
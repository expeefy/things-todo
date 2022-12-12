<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->tasks = Tasks::find();
        //$this->view->aCurrent = false;
    }

    public function deleteAction($id) {
        $taskId = $id;

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
                ],
            ]
        )->getFirst();



        $success = $task->status = 1;
        $task->delete();

            if ($success) {
                $this->response->redirect('index/');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
    }

    public function recycleAction($id) { //RECYCLE ACTION
        $taskId = $id;

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
                ],
            ]
        )->getFirst();



        $success = $task->status = 1;
        $task->save();

            if ($success) {
                $this->response->redirect('index/');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
    }

    public function restoreAction($id) {
        $taskId = $id;

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
                ],
            ]
        )->getFirst();



        $task->status = 0;
        $success = $task->save();

            if ($success) {
                $this->response->redirect('recycle/');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
    }

    public function updateAction($id) //func to upd data
    {
        $taskId = $id;
        //$id = $this->request->getPost('id');
        //$this->view->task = Tasks::findFirst($id);

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
                ],
            ]
        )->getFirst();

        if (($taskId != NULL) && ($task != NULL)) {
        $success = $task->save(
            $this->request->getPost(),
            ["task", ]);

            if ($success) {
                $this->response->redirect("index");
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        } else {
            echo "All fields must contain data.<br>";
            echo $this->tag->linkTo([
                    'taskmanage/taskedit',
                    'Return',
                ]);
        }



            $this->view->disable();
    }

}



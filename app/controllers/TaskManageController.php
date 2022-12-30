<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Http\Request;

class TaskManageController extends Controller
{
    public function indexAction()
    {
        $this->view->tasks = Tasks::find();
            //$this->view->idClicked;
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

    public function taskeditAction($id) {

        $this->view->task = Tasks::findFirst($id);
    }

    public function taskaddAction() {
        $this->view->pick("taskmanage/taskadd");
    }

    public function addAction()
    {

        $task = new Tasks;

        if ($task != NULL) {
        $success = $task->save(
            $this->request->getPost(),
            ["task", ],
        );

            if ($success) {
                $this->response->redirect('taskmanage/taskadd');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                    echo $this->tag->linkTo([
                        'taskmanage/taskadd',
                        'Return',
                    ]);
                }
           }
        } else {
            echo "Field cannot be empty.<br>";
            echo $this->tag->linkTo([
                    'taskmanage/taskadd',
                    'Return',
                ]);
        }

            $this->view->disable();
    }

    public function recycleAction() {
        $taskId = $this->request->getPost('id');

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
                ],
            ]
        )->getFirst();


        if ($taskId != NULL) {
        $task->status = 1;
        $success = $task->save();

            if ($success) {
                $this->response->redirect('index/');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        } else {
            echo "Field cannot be empty.<br>";
            echo $this->tag->linkTo([
                    'taskmanage',
                    'Return',
                ]);

        }



            $this->view->disable();
    }

    public function updateAction($id) //func to upd data
    {
        $taskId = $id;

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



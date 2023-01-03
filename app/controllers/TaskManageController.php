<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Http\Request;

class TaskManageController extends Controller
{
    public function indexAction()
    {
        $this->view->tasks = Tasks::find();
    }

    public function deleteAction($id) {

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $id,
                ],
            ]
        )->getFirst();

        $success = $task->delete();

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
        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $id,
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

        $success = $task->save(
            $this->request->getPost()
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



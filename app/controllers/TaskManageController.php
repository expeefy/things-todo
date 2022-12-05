<?php

use Phalcon\Mvc\Controller;

class TaskManageController extends Controller
{
    public function indexAction()
    {

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
                $this->response->redirect('taskmanage');
            } else {
                echo "Error: ";

                $messages = $task->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                    echo $this->tag->linkTo([
                        'taskmanage',
                        'Return',
                    ]);
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

    public function updateAction() //func to upd data
    {
        $taskId = $this->request->getPost('id');

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
            ["task", ],);

            if ($success) {
                $this->response->redirect('index/');
                // echo "Task updated successfully.<br>";
                // echo $this->tag->linkTo([
                //     'index',
                //     'Return',
                // ]);
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
                    'taskmanage',
                    'Return',
                ]);
        }



            $this->view->disable();
    }

}



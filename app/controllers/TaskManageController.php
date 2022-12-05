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

        $success = $task->save(
            $this->request->getPost(),
            ["task", ],
        );

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

    public function removeAction() {
        $taskId = $this->request->getPost('id');

        $task = Tasks::find(
            [
                'id = :id:',
                'bind' => [
                    'id' => $taskId,
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

            $this->view->disable();
    }

}



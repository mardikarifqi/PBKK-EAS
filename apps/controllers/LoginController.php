<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->get('email');
            $password = $this->request->get('password');

            $user = Users::query()
                ->where("email = :email:")
                ->andWhere("pass = :password:")
                ->bind([
                    "email" => $email,
                    "password" => $password
                ])
                ->execute();

            if (count($user->toArray()) < 1) {
                $this->view->showPesanError = true;
                $this->session->remove('loggedin');
            } else {
                $this->view->showPesanError = false;
                $this->session->set('loggedin', $user[0]->id);

                $r = new Response();
                $r->redirect("/dashboard");
                return $r;
            }
        } else {
            $current = $this->session->get('loggedin', false);

            if ($current) {
                $r = new Response();
                $r->redirect("/dashboard");

                return $r;
            }

            $this->view->pick('login/index');
            $this->view->showPesanError = false;
        }
    }

    public function logoutAction()
    {
        $this->session->remove('loggedin');

        $r = new Response();
        $r->redirect("/");
        return $r;
    }
}

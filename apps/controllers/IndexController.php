<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $current = $this->session->get('loggedin', false);

        if ($current) {
            $r = new Response();
            $r->redirect("/dashboard");

            return $r;
        }

        $this->view->pick('index/index');
    }
}

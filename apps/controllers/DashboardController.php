<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $current = $this->session->get('loggedin', false);

        if (!$current) {
            $r = new Response();
            $r->redirect("/");

            return $r;
        }

        $k = [];
        $a = BantuanData::query()
            ->groupBy('jenis')
            ->columns(['jenis'])
            ->execute();

        foreach ($a as $b) {
            $k[] = $b->jenis;
        }

        $this->view->jenis = $this->request->getQuery('filter') ?? 'nul';
        $this->view->kat = $k;
        $this->view->pick('dashboard/index');
        $this->view->data = Bantuan::query()
            ->execute();
    }

    public function newAction()
    {
        if ($this->request->isPost()) {
            $donatur = new Bantuan;
            $donatur->donatur = $this->request->get('donatur');
            $donatur->time = time();
            $donatur->save();

            $jenis_input = $this->request->get('jenis');
            $jumlah_input = $this->request->get('jumlah');

            foreach ($jenis_input as $i => $jenis) {
                $data = new BantuanData;
                $data->jenis = $jenis;
                $data->jumlah = $jumlah_input[$i];
                $data->bantuan_id = $donatur->id;
                $data->save();
            }

            $jenis = $this->request->get('jenis');

            return (new Response())->redirect("/dashboard");
        }
        $this->view->pick('dashboard/new');
    }
}

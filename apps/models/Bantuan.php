<?php

use Phalcon\Mvc\Model;

class Bantuan extends Model
{
    public $donatur;
    public $time;

    public function initialize()
    {
        $this->setSource("bantuan");
        $this->hasMany('id', BantuanData::class, 'bantuan_id', [
            'reusable' => true,
            'alias'    => 'data_bantuan'
        ]);
    }
}

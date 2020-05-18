<?php

use Phalcon\Mvc\Model;

class BantuanData extends Model
{
    public $jenis;
    public $jumlah;
    public $bantuan;

    public function initialize()
    {
        $this->setSource("bantuan_data");
        $this->belongsTo('bantuan_id', Bantuan::class, 'id',[
            'reusable' => true,
            'alias'    => 'bantuan'
        ]);
    }
}

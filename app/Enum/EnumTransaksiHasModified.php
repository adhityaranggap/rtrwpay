<?php

namespace App\Enum;
use \RouterOS\Client;
use \RouterOS\Query;
/**
 * @author Achmad Munandar
 */
class EnumTransaksiHasModified
{

    CONST CREATE              = '0'; //CREATE
    CONST UPDATE              = '1'; //UPDATE
    CONST DELETE              = '2'; //DELETE   
    CONST CANCEL_PAYMENT      = '3'; //CANCEL PAYMENT   
    CONST SYNC_DATA           = '4'; //SYNC   
   
    // public static function status($status)
    // {
    //     if($status == 0){
    //         return \Component::badgetLinkDanger("Belum Dibayar");
    //     }else if($status == 1){
    //         return \Component::badgetLinkDanger("Pembayaran Telat");
    //     }else if($status == 2){
    //         return \Component::badgetLinkDanger("Butuh Verifikasi");
    //     }else if($status == 3){
    //         return \Component::badgetLinkSuccess("Lunas");
    //     }else if($status == 4){
    //         return \Component::badgetLinkWarning("Belum Lunas");
    //     }
    // }
 

} 
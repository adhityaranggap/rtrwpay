<?php

namespace App\Enum;
/**
 * @author Achmad Munandar
 */
class EnumTicket
{

    CONST STATUS_OPEN               = '0'; //BELUM DIBALAS
    CONST STATUS_PENDING            = '1'; //WAITING FOR CUSTOMER
    CONST STATUS_HOLD               = '2'; //CHECKING  
    CONST STATUS_CLOSED             = '3'; //DONE    

    CONST PRIORITY_LOW              = '0'; //QUESTION    
    CONST PRIORITY_MEDIUM           = '1'; //TROUBLE    
    CONST PRIORITY_HIGH             = '2'; //DOWN    
  


    public static function status($status)
    {
        if($status == 0){
            return \Component::badgetLinkDanger("OPEN");
        }else if($status == 1){
            return \Component::badgetLinkDanger("PENDING");
        }else if($status == 2){
            return \Component::badgetLinkDanger("HOLD");
        }else if($status == 3){
            return \Component::badgetLinkSuccess("CLOSED");
        }
        // }else if($status == 4){
        //     return \Component::badgetLinkWarning("Belum Lunas");
        // }
    }

    public static function statusLists()
    {
        $arrData = [
            '0' =>  'Open',
            '1' =>  'Pending',
            '2' =>  'Hold',
            '3' =>  "Closed"
        ];

        return $arrData;
    }

} 
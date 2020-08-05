/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function toRp(bilangan)
{
    var	reverse = bilangan.toString().split('').reverse().join(''),
        ribuan 	= reverse.match(/\d{1,3}/g);

    ribuan	= ribuan.join('.').split('').reverse().join('');
    
    return 'Rp '+ribuan;
}

function renumberRows() {
    $('#tbody_nested tr').each(function(index, el){
        $(this).children('td').first().text(function(i,t){
            return index+1;
        });
    });
}


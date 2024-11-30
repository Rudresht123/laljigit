<?php

if (!function_exists('resetFields')) {
function resetFields($TrademarkUser)
{
    $TrademarkUser->rectification_no = null;
    $TrademarkUser->opposed_no = null;
    $TrademarkUser->opponent_applicant = null;
    $TrademarkUser->opponenet_applicant_name = null;
    $TrademarkUser->opponent_applicant_code = null;
    $TrademarkUser->hearing_date = null;
    $TrademarkUser->examination_report = null;
}
}
    

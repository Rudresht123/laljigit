<?php
if (!function_exists('setActiveAcademicSession')) {
 function handleStatusLogic($TrademarkUser, $status, $request)
    {
        switch ($status) {
            case 8:
                $TrademarkUser->rectification_no = $request->input('rectification_no');
                $TrademarkUser->opposed_no = null;
                handleOpponentApplicant($TrademarkUser, $request);
                break;
    
            case 7:
                $TrademarkUser->rectification_no = null;
                $TrademarkUser->opposed_no = $request->input('opposed_no');
               handleOpponentApplicant($TrademarkUser, $request);
                break;
    
            case 6:
                $sub_status = $request->input('sub_status');
                if($sub_status == 15) {
                    $TrademarkUser->examination_report = $request->input('examination_report');
                } elseif($sub_status == 2) {
                    $TrademarkUser->hearing_date = $request->input('hearing_date');
                }
                break;
    
            default:
                resetFields($TrademarkUser);
                break;
        }
    }
}
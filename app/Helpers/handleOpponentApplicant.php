<?php

if (!function_exists('handleOpponentApplicant')) {
     function handleOpponentApplicant($TrademarkUser, $request)
    {
        $opponent_applicant = $request->input('opponent_applicant');
        if ($opponent_applicant == 'Applicant') {
            $TrademarkUser->opponent_applicant = $opponent_applicant;
            $TrademarkUser->opponenet_applicant_name = $request->input('opponent_name');
            $TrademarkUser->opponent_applicant_code = $request->input('opponent_code');
        } elseif ($opponent_applicant == 'Opponent') {
            $TrademarkUser->opponent_applicant = $opponent_applicant;
            $TrademarkUser->opponenet_applicant_name = $request->input('applicant_name');
            $TrademarkUser->opponent_applicant_code = $request->input('applicant_code');
        }
    }
    
}
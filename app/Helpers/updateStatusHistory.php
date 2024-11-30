<?php
use App\Models\StatusHistory;
use Illuminate\Support\Facades\Session;

if (!function_exists('updateStatusHistory')) {
     function updateStatusHistory($applicationno,$file_name, $status, $sub_status)
    {
       
        $statusHistory = StatusHistory::where('application_no', $applicationno)->first();
       
        if(!$statusHistory){

                StatusHistory::create([
                    'application_no' => $applicationno,
                    'file_name'=>$file_name, 
                    'status_history' => json_encode([
                        [
                            'status' => $status,
                            'sub_status' => $sub_status,
                            'date' => now()->toDateTimeString(),
                        ]
                    ]),
                ]);
        }else{
            if ($statusHistory) {
                $statusData = json_decode($statusHistory->status_history, true) ?: [];
                $statusData[] = [
                    'status' => $status,
                    'sub_status' => $sub_status,
                    'date' => now()->toDateTimeString(),
                ];
                $statusHistory->update([
                    'status_history' => json_encode($statusData),
                    'updated_at' => now(),
                ]);
            }
        }
       
    }
    
}
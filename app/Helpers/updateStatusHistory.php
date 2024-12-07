<?php
use App\Models\StatusHistory;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

if (!function_exists('updateStatusHistory')) {
     function updateStatusHistory(array $data)
    {
        
    $applicationno = $data['application_no'];
    $status = $data['status'];
    $sub_status = $data['sub_status'];
    $fileName = $data['file_name'];
       
        $statusHistory = StatusHistory::where('application_no', $applicationno)->first();
       
        if(!$statusHistory){

                StatusHistory::create([
                    'application_no' => $applicationno,
                    'file_name'=>$file_name, 
                    'status_history' => json_encode([
                        [
                            'status' => $status,
                            'sub_status' => $sub_status,
                            'date' =>  Carbon::now('Asia/Kolkata')->toDateTimeString(),
                        ]
                    ]),
                ]);
        }else{
            if ($statusHistory) {
                $statusData = json_decode($statusHistory->status_history, true) ?: [];
                $statusData[] = [
                    'status' => $status,
                    'sub_status' => $sub_status,
                    'date' =>Carbon::now('Asia/Kolkata')->toDateTimeString(),
                ];
                
                $statusHistory->update([
                    'status_history' => json_encode($statusData),
                    'updated_at' => Carbon::now('Asia/Kolkata'),
                ]);
            }
        }
       
    }
    
}
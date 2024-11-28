<?php

// In a helper file, e.g., app/Helpers/StatusHelper.php

use App\Models\TrademarkUserModel;

function updateStatus($table, $id, $newStatus)
{
    switch ($table) {
        case 'trademark':
            TrademarkUserModel::where('id', $id)->update(['sub_category' => $newStatus]);
            break;
    }
}

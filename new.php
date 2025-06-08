<?php
if ($row_fleet['condition_sundays'] === 'Excluding Sundays' && date('D', strtotime($row['date'])) === 'Sun') {
    $overtime = ($row['closed_hmr'] - $row['start_hmr']) + ($row['night_close_hmr'] - $row['night_start_hmr']);
} else {
    if (($row['closed_hmr'] - $row['start_hmr']) + ($row['night_close_hmr'] - $row['night_start_hmr']) > $row_hmr['hours_shift']) {
        $overtime = ($row['closed_hmr'] - $row['start_hmr']) + ($row['night_close_hmr'] - $row['night_start_hmr']) - $row_hmr['hours_shift'];
    } else {
        $overtime = 0;
    }
}
?>
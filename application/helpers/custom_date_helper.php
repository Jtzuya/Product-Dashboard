<?php
date_default_timezone_set('Asia/Manila');

// Helper helpful docs: t.ly/gCxf (shortened link)
if(!function_exists('custom_date')) {
    function custom_date($created_at) {
        $split_date_and_time = explode(' ', $created_at);
        $today = date('Y-m-d h:i:s', TIME());
        $date = $split_date_and_time[0]; // get's the first array which is the date only
        $created_at = date("Y-m-d h:i:s", strtotime($created_at));

        $diff_min = date_diff(date_create($created_at), date_create($today));
        
        // if($diff_min->format('%d') >= 8) {
        //     return date('F jS Y', strtotime($date));
        // } else 

        if($diff_min->format('%d') == 7) {
            return $diff_min->format('%d') > 7 ? date('F jS Y', strtotime($date)) : '1 week ago';
        } else if ($diff_min->format('%d') >= 1) {
            return $diff_min->format('%d') == 1 ? $diff_min->format('%d day ago') : $diff_min->format('%d days ago');
        } else if ($diff_min->format('%h') >= 1) {
            return $diff_min->format('%h') == 1 ? $diff_min->format('%h hour ago') : $diff_min->format('%h hours ago');
        } else if ($diff_min->format('%i') >= 1) {
            return $diff_min->format('%i') == 1 ? $diff_min->format('%i minute ago') : $diff_min->format('%i minutes ago');
        } else if ($diff_min->format('%s') >= 1) {
            return $diff_min->format('%s') == 1 ? $diff_min->format('%s second ago') : $diff_min->format('%s seconds ago');
        }
    }
}
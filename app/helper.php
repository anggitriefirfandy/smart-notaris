<?php
if (! function_exists('getIconClass')) {
    function getIconClass($nama_proses)
    {
        if (stripos($nama_proses, 'upload') !== false) {
            return ['icon' => 'ti ti-upload', 'bgColor' => 'bg-info'];
        } elseif (stripos($nama_proses, 'menambahkan') !== false) {
            return ['icon' => 'ti ti-file-plus', 'bgColor' => 'bg-success'];
        } else {
            return ['icon' => 'ti ti-activity', 'bgColor' => 'bg-gray-500'];
        }
    }
}

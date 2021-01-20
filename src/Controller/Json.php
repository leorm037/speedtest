<?php

namespace PaginaEmConstrucao\Controller;

use PaginaEmConstrucao\Models\Speedtest;

class Json
{

    /** @return void */
    public function days(array $data): void
    {
        $days = filter_var($data['days'], FILTER_SANITIZE_NUMBER_INT);

        if ($days) {
            $speedtests = (new Speedtest())->readLastDays($days);
        } else {
            $speedtests = (new Speedtest())->readLastDays();
        }

        header('Content-Type: application/json');
        
        $data = [];

        foreach ($speedtests as $speedtest) {
            $timestamp = $speedtest->timestamp;
            $download = (float) $speedtest->download;
            $upload = (float) $speedtest->upload;
            $data[] = array($timestamp, $download, $upload);
        }
        
        echo json_encode($data);
    }

}

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
        
        $json = [];

        foreach ($speedtests as $speedtest) {
            $timestamp = $speedtest->timestamp;
            $download = (float) $speedtest->download;
            $upload = (float) $speedtest->upload;
            $json[] = array($timestamp, $download, $upload);
        }
        
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
    /** @return void */
    public function statistics(): void {
        $json = [];

        $statistics = (new Speedtest())->statistics();
        
        $sumReg = 0;

        for ($i = 0;$i <= 9;$i++) {
            $reg = $statistics[$i]['reg']; 
            
            if(isset($reg)){
                $json['qtd'][] = (float)$reg;
                $sumReg += $reg;
            } else {
                $json['qtd'][] = 0;
            }
        }
        
        for ($i = 0;$i <= 9;$i++) {
            $reg = $statistics[$i]['reg']; 
            
            if(isset($reg)){
                $json['percent'][] = round($reg * 100 / $sumReg, 2);
            } else {
                $json['percent'][] = 0;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }
}

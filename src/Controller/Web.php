<?php

namespace PaginaEmConstrucao\Controller;

use PaginaEmConstrucao\Core\Controller;
use PaginaEmConstrucao\Models\Speedtest;

class Web extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function days(?array $data): void
    {
        if (isset($data['days'])) {
            $days = filter_var($data['days'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $days = 1;
        }
        echo $this->view->render("index", ["urlJson" => $days]);
    }

    public function measure(): void
    {       
        ini_set('max_execution_time', 300);
        
        $server = filter_input(INPUT_SERVER, "SERVER_ADDR");
        $remote = filter_input(INPUT_SERVER, "REMOTE_ADDR");

        $ip_diff = array_diff(explode('.', $server), explode('.', $remote));

        if ($ip_diff[3] == 2) {
            $exec = shell_exec(__DIR__ . '/../../speedtest-meter.sh');
            
            var_dump($exec);
            exit;

            redirect(url_back());
        } else {
            redirect("/error/401");
        }
    }
    
    public function statistics(): void {
        echo $this->view->render("statistics", []);
    }

    /**
     * 
     * @param array $data
     * @return void
     */
    public function error(array $data): void
    {
        echo $data['errorCode'];
    }

}

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
    
    public function days(?array $data): void {
        if(isset($data['days'])) {
            $days = filter_var($data['days'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $days = 1;
        }
        echo $this->view->render("index", ["urlJson" => $days]);
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

<?php

namespace PaginaEmConstrucao\Models;

use PaginaEmConstrucao\Core\Model;

class Speedtest extends Model
{
    public function __construct()
    {
        parent::__construct("speedtest", ["id"], ["sponsor", "servername", "timestamp", "distance", "ping", "download", "upload", "ipaddress"]);
    }
    
    /**
     * 
     * @param string $sponsor
     * @param string $servername
     * @param int $timestamp
     * @param float $distance
     * @param float $ping
     * @param float $download
     * @param float $upload
     * @param string $share
     * @param string $ipaddress
     * @return Speedtest
     */
    public function boot (string $sponsor, string $servername, int $timestamp, float $distance, float $ping, float $download, float $upload, string $share, string $ipaddress): Speedtest {
        $this->sponsor = $sponsor;
        $this->servername = $servername;
        $this->timestamp = $timestamp;
        $this->distance = $distance;
        $this->ping = $ping;
        $this->download = $download;
        $this->upload = $upload;
        $this->share = $share;
        $this->ipaddress = $ipaddress;
        
        return $this;
    }
    
    public function find(?string $columns = "*", ?string $terms = null, ?string $params = null) {
        $this->orderBy("timestamp ASC");
        return parent::find($columns, $terms, $params);
    }
    
    /**
     * SELECT CONVERT_TZ(timestamp,'+00:00','-03:00') as timestamp, download, upload FROM speedtest where timestamp <= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY timestamp DESC
     * @param int $days
     * @param string $columns
     * @return \stdClass|mixed
     */
    public function readLastDays(int $days = 1, string $columns="*") {
        $readLastDays = $this->find("CONVERT_TZ(timestamp,'+00:00','-03:00') as timestamp, download, upload", "timestamp >= DATE_SUB(NOW(), INTERVAL :days DAY)", "days={$days}");
        return $readLastDays->fetch(true);
    }
    
    /**
     * 
     * @return array
     */
    public function statistics() {
        $statistics = parent::find("COUNT(*) as reg")
                ->groupBy("ROUND(download/10000000,0)")
                ->orderBy("ROUND(download/10000000,0) DESC");
        return $statistics->fetch(true, true);
    }
}

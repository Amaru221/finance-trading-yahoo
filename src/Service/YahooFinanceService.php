<?php

// src/Service/YahooFinanceService.php
namespace App\Service;

use Scheb\YahooFinanceApi\ApiClientFactory;

class YahooFinanceService
{
    private $client;

    public function __construct()
    {
        $this->client = ApiClientFactory::createApiClient();
    }

    /**
     * Obtiene datos históricos de un símbolo.
     *
     * @param string $symbol Símbolo del activo (e.g., "AAPL").
     * @param string $interval Intervalo (e.g., "1d", "1h").
     * @param \DateTime $start Fecha inicial.
     * @param \DateTime $end Fecha final.
     * @return array Datos históricos.
     */
    public function getHistoricalData(string $symbol, string $interval, \DateTime $start, \DateTime $end): array
    {
        return $this->client->getHistoricalQuoteData($symbol, $interval, $start, $end);
    }
}

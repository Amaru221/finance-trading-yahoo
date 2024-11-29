<?php

namespace App\Service;

class IndicatorService
{
    /**
     * Calcula el RSI de una serie de precios.
     * @param array $prices Array de precios cerrados.
     * @param int $period Período para el cálculo (por defecto 14).
     * @return array RSI calculado para cada punto.
     */
    public function calculateRSI(array $prices, int $period = 14): array
    {
        $gains = [];
        $losses = [];

        // Calcular ganancias y pérdidas
        for ($i = 1; $i < count($prices); $i++) {
            $change = $prices[$i] - $prices[$i - 1];
            $gains[] = max($change, 0);
            $losses[] = abs(min($change, 0));
        }

        // Inicializar arrays para RSI
        $rsi = [];
        $averageGain = array_sum(array_slice($gains, 0, $period)) / $period;
        $averageLoss = array_sum(array_slice($losses, 0, $period)) / $period;

        // Calcular RSI por iteración
        for ($i = $period; $i < count($prices); $i++) {
            $averageGain = (($averageGain * ($period - 1)) + $gains[$i]) / $period;
            $averageLoss = (($averageLoss * ($period - 1)) + $losses[$i]) / $period;

            $rs = $averageLoss == 0 ? 0 : $averageGain / $averageLoss;
            $rsi[] = 100 - (100 / (1 + $rs));
        }

        return $rsi;
    }

    public function calculateSMA(array $prices, int $period): array
    {
        $sma = [];
        for ($i = $period - 1; $i < count($prices); $i++) {
            $sma[] = array_sum(array_slice($prices, $i - $period + 1, $period)) / $period;
        }
        return $sma;
    }

    public function calculateEMA(array $prices, int $period): array
    {
        $ema = [];
        $multiplier = 2 / ($period + 1);
        $ema[0] = array_sum(array_slice($prices, 0, $period)) / $period;

        for ($i = $period; $i < count($prices); $i++) {
            $ema[] = ($prices[$i] - end($ema)) * $multiplier + end($ema);
        }
        return $ema;
    }

    public function calculateMACD(array $prices, int $shortPeriod = 12, int $longPeriod = 26, int $signalPeriod = 9): array
    {
        $shortEMA = $this->calculateEMA($prices, $shortPeriod);
        $longEMA = $this->calculateEMA($prices, $longPeriod);
        $macd = array_map(fn($s, $l) => $s - $l, $shortEMA, array_slice($longEMA, count($longEMA) - count($shortEMA)));

        $signal = $this->calculateEMA($macd, $signalPeriod);
        return ['macd' => $macd, 'signal' => $signal];
    }


    

}
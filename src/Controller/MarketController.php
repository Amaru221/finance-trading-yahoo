<?php
namespace App\Controller;

use App\Service\IndicatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarketController extends AbstractController {

    private $indicatorService;

    public function __construct(IndicatorService $indicatorService)
    {
        $this->indicatorService = $indicatorService;
    }

    #[Route("/api/indicators/{symbol}", methods:["GET"])]
    public function getIndicators(string $symbol): JsonResponse
    {
        // Simulamos precios obtenidos de una API externa
        $prices = [150, 152, 149, 151, 153, 154, 155, 150, 148, 147, 149, 151, 152, 153];

        $rsi = $this->indicatorService->calculateRSI($prices);
        $sma = $this->indicatorService->calculateSMA($prices, 5);
        $macd = $this->indicatorService->calculateMACD($prices);

        return $this->json([
            'symbol' => $symbol,
            'RSI' => $rsi,
            'SMA' => $sma,
            'MACD' => $macd,
        ]);
    }


    
}
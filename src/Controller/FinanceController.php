<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class FinanceController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/actions', name: 'app_list_actions')]
    public function listActions(): Response
    {
        return $this->render('finance/list.html.twig', [
            'actions' => [
                ['symbol' => 'AAPL', 'label' => 'Apple Inc. (USA)'],
                ['symbol' => 'MSFT', 'label' => 'Microsoft Corp. (USA)'],
                ['symbol' => 'GOOGL', 'label' => 'Alphabet Inc. (USA)'],
                ['symbol' => 'AMZN', 'label' => 'Amazon.com Inc. (USA)'],
                ['symbol' => 'FB', 'label' => 'Meta Platforms Inc. (USA)'],
                ['symbol' => 'TSLA', 'label' => 'Tesla Inc. (USA)'],
                ['symbol' => 'BRK.B', 'label' => 'Berkshire Hathaway Inc. (USA)'],
                ['symbol' => 'JPM', 'label' => 'JPMorgan Chase & Co. (USA)'],
                ['symbol' => 'V', 'label' => 'Visa Inc. (USA)'],
                ['symbol' => 'JNJ', 'label' => 'Johnson & Johnson (USA)'],
                ['symbol' => 'SAN.PA', 'label' => 'Société Générale (France)'],
                ['symbol' => 'OR.PA', 'label' => 'L’Oréal (France)'],
                ['symbol' => 'DAI.DE', 'label' => 'Daimler AG (Allemagne)'],
                ['symbol' => 'BMW.DE', 'label' => 'BMW AG (Allemagne)'],
                ['symbol' => 'NESN.SW', 'label' => 'Nestlé S.A. (Suisse)'],
                ['symbol' => 'BTC-USD', 'label' => 'Bitcoin (Crypto)'],
                ['symbol' => 'ETH-USD', 'label' => 'Ethereum (Crypto)'],
                ['symbol' => 'BNB-USD', 'label' => 'Binance Coin (Crypto)'],
                ['symbol' => 'ADA-USD', 'label' => 'Cardano (Crypto)'],
                ['symbol' => 'XRP-USD', 'label' => 'Ripple (Crypto)'],
            ],
        ]);
    }

    #[Route('/actions/{symbol}', name: 'action_chart')]
    public function showChart(string $symbol): Response
    {
        $apiKey = 'd1i3b1pr01qhsrhd2sjgd1i3b1pr01qhsrhd2sk0';
        $url = "https://finnhub.io/api/v1/quote?symbol=$symbol&token=$apiKey";

        try {
            $response = $this->client->request('GET', $url);
            $data = $response->toArray();
            $price = $data['c'] ?? null;
            $open = $data['o'] ?? null;
            $high = $data['h'] ?? null;
            $low = $data['l'] ?? null;
            $previousClose = $data['pc'] ?? null;
        } catch (\Throwable $e) {
            $price = $open = $high = $low = $previousClose = null;
        }

        return $this->render('finance/tradingview_widget.html.twig', [
            'symbol' => strtoupper($symbol),
            'price' => $price,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'previousClose' => $previousClose,
        ]);
    }
}

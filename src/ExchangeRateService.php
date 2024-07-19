// src/ExchangeRateService.php
namespace CommissionCalculator;

class ExchangeRateService {
    private $apiUrl = 'https://api.exchangeratesapi.io/latest';

    public function getRate($baseCurrency, $targetCurrency) {
        // Simulate fetching exchange rates for simplicity
        $rates = [
            'EUR' => ['USD' => 1.1497, 'JPY' => 129.53],
            'USD' => ['EUR' => 0.87, 'JPY' => 112.56],
            'JPY' => ['EUR' => 0.0077, 'USD' => 0.0089],
        ];

        return $rates[$baseCurrency][$targetCurrency];
    }
}

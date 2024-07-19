// src/CommissionFeeCalculator.php
namespace CommissionCalculator;

class CommissionFeeCalculator {
    private $exchangeRateService;

    public function __construct() {
        $this->exchangeRateService = new ExchangeRateService();
    }

    public function calculate(Operation $operation, $weeklyTransactions) {
        $commission = 0;

        if ($operation->operationType === 'deposit') {
            $commission = $operation->amount * 0.0003;
        } elseif ($operation->operationType === 'withdraw') {
            if ($operation->userType === 'private') {
                $commission = $this->calculatePrivateWithdraw($operation, $weeklyTransactions);
            } elseif ($operation->userType === 'business') {
                $commission = $operation->amount * 0.005;
            }
        }

        return ceil($commission * 100) / 100;
    }

    private function calculatePrivateWithdraw(Operation $operation, $weeklyTransactions) {
        $freeLimit = 1000.00;
        $freeWithdrawals = 3;
        $commissionRate = 0.003;

        $weeklyAmount = $this->getWeeklyAmount($operation->userId, $operation->currency, $weeklyTransactions);

        if (count($weeklyTransactions) < $freeWithdrawals && $weeklyAmount + $operation->amount <= $freeLimit) {
            return 0;
        }

        $exceededAmount = max(0, $weeklyAmount + $operation->amount - $freeLimit);
        if ($weeklyAmount < $freeLimit) {
            $exceededAmount = max(0, $exceededAmount - ($freeLimit - $weeklyAmount));
        }

        return $exceededAmount * $commissionRate;
    }

    private function getWeeklyAmount($userId, $currency, $weeklyTransactions) {
        $amount = 0;
        foreach ($weeklyTransactions as $transaction) {
            if ($transaction['userId'] === $userId && $transaction['currency'] === $currency) {
                $amount += $transaction['amount'];
            }
        }
        return $amount;
    }
}

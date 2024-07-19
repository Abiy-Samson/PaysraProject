// tests/CommissionFeeCalculatorTest.php
use PHPUnit\Framework\TestCase;
use CommissionCalculator\Operation;
use CommissionCalculator\CommissionFeeCalculator;

class CommissionFeeCalculatorTest extends TestCase {
    public function testCalculateCommission() {
        $calculator = new CommissionFeeCalculator();

        $operation = new Operation('2024-01-01', 1, 'private', 'deposit', 200.00, 'EUR');
        $commission = $calculator->calculate($operation, []);
        $this->assertEquals(0.06, $commission);

        $operation = new Operation('2024-01-01', 1, 'private', 'withdraw', 200.00, 'EUR');
        $commission = $calculator->calculate($operation, []);
        $this->assertEquals(0.00, $commission);

        $operation = new Operation('2024-01-01', 2, 'business', 'withdraw', 200.00, 'EUR');
        $commission = $calculator->calculate($operation, []);
        $this->assertEquals(1.00, $commission);
    }
}

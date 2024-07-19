
namespace CommissionCalculator;

class Operation {
    public $date;
    public $userId;
    public $userType;
    public $operationType;
    public $amount;
    public $currency;

    public function __construct($date, $userId, $userType, $operationType, $amount, $currency) {
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->operationType = $operationType;
        $this->amount = $amount;
        $this->currency = $currency;
    }
}

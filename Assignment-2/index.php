<?php

class FinanceTracker {
    private $incomeFile = 'income.txt';
    private $expenseFile = 'expense.txt';
    private $categoryFile = 'categories.txt';

    public function __construct() {
        if (!file_exists($this->incomeFile)) {
            file_put_contents($this->incomeFile, "");
        }
        if (!file_exists($this->expenseFile)) {
            file_put_contents($this->expenseFile, "");
        }
        if (!file_exists($this->categoryFile)) {
            file_put_contents($this->categoryFile, "Salary\nGift\nInvestment\nFood\nTransport\nEntertainment\nOthers\n");
        }
    }

    public function addIncome($amount, $category) {
        $data = $amount . '|' . $category . "\n";
        file_put_contents($this->incomeFile, $data, FILE_APPEND);
    }

    public function addExpense($amount, $category) {
        $data = $amount . '|' . $category . "\n";
        file_put_contents($this->expenseFile, $data, FILE_APPEND);
    }

    public function viewIncomes() {
        return file($this->incomeFile, FILE_IGNORE_NEW_LINES);
    }

    public function viewExpenses() {
        return file($this->expenseFile, FILE_IGNORE_NEW_LINES);
    }

    public function viewCategories() {
        return file($this->categoryFile, FILE_IGNORE_NEW_LINES);
    }

    public function calculateSavings() {
        $totalIncome = 0;
        $totalExpense = 0;
        
        foreach ($this->viewIncomes() as $line) {
            list($amount, $category) = explode('|', $line);
            $totalIncome += (float) $amount;
        }

        foreach ($this->viewExpenses() as $line) {
            list($amount, $category) = explode('|', $line);
            $totalExpense += (float) $amount;
        }

        return $totalIncome - $totalExpense;
    }

    public function menu() {
        while (true) {
            echo "1. Add income\n";
            echo "2. Add expense\n";
            echo "3. View incomes\n";
            echo "4. View expenses\n";
            echo "5. View savings\n";
            echo "6. View categories\n";
            echo "7. Exit\n";
            echo "Enter your option: ";

            $handle = fopen("php://stdin", "r");
            $option = trim(fgets($handle));

            switch ($option) {
                case 1:
                    echo "Enter amount: ";
                    $amount = trim(fgets($handle));
                    echo "Enter category: ";
                    $category = trim(fgets($handle));
                    $this->addIncome($amount, $category);
                    echo "Income added successfully!\n";
                    break;

                case 2:
                    echo "Enter amount: ";
                    $amount = trim(fgets($handle));
                    echo "Enter category: ";
                    $category = trim(fgets($handle));
                    $this->addExpense($amount, $category);
                    echo "Expense added successfully!\n";
                    break;

                case 3:
                    echo "Incomes:\n";
                    echo "----------------\n";
                    foreach ($this->viewIncomes() as $income) {
                        echo $income . "\n";
                    }
                    echo "----------------\n";
                    break;

                case 4:
                    echo "Expenses:\n";
                    echo "----------------\n";
                    foreach ($this->viewExpenses() as $expense) {
                        echo $expense . "\n";
                    }
                    echo "----------------\n";
                    break;

                case 5:
                    $savings = $this->calculateSavings();
                    echo "----------------\n";
                    echo "Total Savings: $savings\n";
                    echo "----------------\n";
                    break;

                case 6:
                    echo "Categories:\n";
                    echo "----------------\n";
                    foreach ($this->viewCategories() as $category) {
                        echo $category . "\n";
                    }
                    echo "----------------\n";
                    break;
                case 7:
                    return;
                default:
                    echo "Invalid option!\n";
                    break;
            }
        }
    }
}

$tracker = new FinanceTracker();
$tracker->menu();
?>

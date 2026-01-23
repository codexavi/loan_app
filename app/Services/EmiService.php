<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDO;

class EmiService
{
    public function process()
    {
        // First, let's find the overall start and end dates for all loans in one go
        $dates = DB::table('loan_details')
            ->selectRaw('MIN(first_payment_date) as start, MAX(last_payment_date) as end')
            ->first();

        // If there are no loans in the system, we stop here and return nothing
        if (!$dates->start || !$dates->end) {
            return [];
        }

        // We'll generate a list of labels for every month in that range, like "2024_Jan"
        $columns = []; // Initialize an empty array to store the formatted month strings
        $current = Carbon::parse($dates->start)->startOfMonth(); // Set the start date to the first of the earliest month
        $finish = Carbon::parse($dates->end)->startOfMonth(); // Set the end date to the first of the latest month

        // We iterate through the entire date range to generate a column name for every month 
        // that exists between the earliest and latest loan payments across all records.
        while ($current <= $finish) {
            $columns[] = $current->format('Y_M');
            $current->addMonth();
        }

        // Now we clear and recreate the EMI table to match these specific months
        $this->createEmiTable($columns);

        // We loop through every loan and calculate how the money is split across the timeline
        DB::table('loan_details')->get()->each(function ($loan) use ($columns) {
            $this->processLoan($loan, $columns);
        });
    }

    private function createEmiTable(array $columns)
    {
        // Drop if exists
        DB::statement('DROP TABLE IF EXISTS emi_details');

        // Start building the raw SQL query to create the emi_details table
        $sql = "CREATE TABLE emi_details (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each record
            clientid BIGINT UNSIGNED NOT NULL, -- ID of the client associated with the loan";

        // Add dynamic columns for each month in the loan range to store EMI amounts
        foreach ($columns as $col) {
            $sql .= " `$col` DECIMAL(10, 2) DEFAULT 0.00,";
        }

        // Add standard Laravel timestamp columns and execute the query
        $sql .= " created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL)";

        // Execute the raw SQL query to create the table
        DB::statement($sql);
    }

    private function processLoan($loan, $columns)
    {
        // Extract the total number of installments from the loan record
        $numPayments = $loan->num_of_payment;
        // Extract the total principal loan amount from the loan record
        $loanAmount = $loan->loan_amount;
        
        // Calculate the base EMI amount by dividing total loan by number of payments, rounded to 2 decimals
        $emi = round($loanAmount / $numPayments, 2);
        
        // Determine the sum of all payments except the final one to handle rounding discrepancies
        $totalPaidBeforeLast = $emi * ($numPayments - 1);
        // Calculate the final payment amount as the remaining balance of the loan to ensure total accuracy
        $lastPayment = round($loanAmount - $totalPaidBeforeLast, 2);

        // Prepare the initial data array for the database insert, including the client ID and current timestamps
        $paymentData = ['clientid' => $loan->clientid, 'created_at' => now(), 'updated_at' => now()];

        // Parse the start date of the first payment using Carbon for date manipulation
        $startDate = Carbon::parse($loan->first_payment_date);
        
        // Iterate through the total number of payments to map each installment to its respective month
        for ($i = 0; $i < $numPayments; $i++) {
            // Calculate the specific payment date for the current installment index by adding months
            $currentPaymentDate = $startDate->copy()->addMonths($i);
            // Format the date into 'YYYY_Mon' string to match the dynamic column names in the emi_details table
            $columnName = $currentPaymentDate->format('Y_M');

            // Verify if the calculated month column exists within the predefined dynamic columns list
            if (in_array($columnName, $columns)) {
                // Assign the last payment amount for the final installment, otherwise assign the standard EMI
                $paymentData[$columnName] = ($i == $numPayments - 1) ? $lastPayment : $emi;
            }
        }
        
        // Execute the database insertion for the current loan's EMI distribution across the dynamic table
        DB::table('emi_details')->insert($paymentData);
    }

    public function getEmiData()
    {
        // Step 1: Retrieve the minimum and maximum payment dates from the loan_details table
        $dates = DB::table('loan_details')
            ->selectRaw('MIN(first_payment_date) as start, MAX(last_payment_date) as end')
            ->first();

        // Step 2: Return empty arrays if no loan data is available to prevent errors
        if (!$dates->start || !$dates->end) {
            return ['columns' => [], 'rows' => []];
        }

        // Step 3: Generate the dynamic month columns (e.g., 2024_Jan) based on the date range
        $columns = [];
        $current = Carbon::parse($dates->start)->startOfMonth();
        $finish = Carbon::parse($dates->end)->startOfMonth();

        while ($current <= $finish) {
            $columns[] = $current->format('Y_M');
            $current->addMonth();
        }

        // Step 4: Attempt to fetch all rows from the emi_details table, defaulting to an empty collection if the table doesn't exist
        try {
            $rows = DB::table('emi_details')->get();
        } catch (\Exception $e) {
            $rows = collect();
        }

        // Step 5: Return the prepared columns and rows for display in the view
        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }
}

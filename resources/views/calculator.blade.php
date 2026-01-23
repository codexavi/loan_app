<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); width: 350px; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .5rem; font-weight: bold; }
        input { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-bottom: 1rem; }
        button:hover { background-color: #059669; }
        .result { padding: 1rem; background-color: #e5e7eb; border-radius: 4px; text-align: center; display: none; }
        .result strong { display: block; font-size: 1.5rem; color: #111827; }
        .back-link { display: block; text-align: center; margin-top: 1rem; text-decoration: none; color: #6b7280; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align: center; margin-top: 0;">Loan Calculator</h2>
        
        <div class="form-group">
            <label for="amount">Loan Amount</label>
            <input type="number" id="amount" step="0.01" placeholder="Enter amount">
        </div>

        <div class="form-group">
            <label for="months">Duration (Months)</label>
            <input type="number" id="months" placeholder="Enter months">
        </div>

        <button onclick="calculate()">Calculate EMI</button>

        <div class="result" id="result-box">
            <div>Monthly Payment</div>
            <strong id="emi-amount">0.00</strong>
        </div>

        <a href="{{ route('loan.details') }}" class="back-link">Back to Dashboard</a>
    </div>

    <script>
        function calculate() {
            const amount = parseFloat(document.getElementById('amount').value);
            const months = parseInt(document.getElementById('months').value);
            
            if (amount && months) {
                const emi = (amount / months).toFixed(2);
                document.getElementById('emi-amount').innerText = emi;
                document.getElementById('result-box').style.display = 'block';
            } else {
                alert('Please enter valid amount and months');
            }
        }
    </script>
</body>
</html>

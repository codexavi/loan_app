<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background-color: #f3f4f6; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: 600; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: bold; }
        .btn-primary { background-color: #2563eb; color: white; }
        .btn-secondary { background-color: #db1010ff; color: white; float: right; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('logout') }}" class="btn btn-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <h1>Welcome {{ Auth::user()->username }},</h1>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <h3>Loan Details</h3>

        <table>
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Num of Payment</th>
                    <th>First Payment Date</th>
                    <th>Last Payment Date</th>
                    <th>Loan Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanDetails as $loan)
                <tr>
                    <td>{{ $loan->clientid }}</td>
                    <td>{{ $loan->num_of_payment }}</td>
                    <td>{{ $loan->first_payment_date }}</td>
                    <td>{{ $loan->last_payment_date }}</td>
                    <td>{{ $loan->loan_amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Steps 7: Page with Process Data button -->
        <!-- I will link this to a route that shows the EMI processing page -->
        <!-- Requirement 7: Create a page that initially has a button named Process Data. -->
        <!-- Requirement 7a: Initially the page will be blank. -->
        <!-- Requirement 7d: Display data of table emi_details in the page. -->
        
        <a href="{{ route('emi.index') }}" class="btn btn-primary">Go to EMI Processing</a>
        <a href="{{ route('calculator') }}" class="btn btn-primary" style="margin-left: 10px;">Loan Calculator</a>
    </div>
</body>
</html>

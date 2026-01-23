<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMI Details</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background-color: #f3f4f6; }
        .container { overflow-x: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; white-space: nowrap; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: 600; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: bold; }
        .btn-primary { background-color: #2563eb; color: white; }
        .btn-secondary { background-color: #4b5563; color: white; margin-right: 1rem; }
        .btn:hover { opacity: 0.9; }
        .actions { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="actions">
            <a href="{{ route('loan.details') }}" class="btn btn-secondary">Back to Loan Details</a>
            <form action="{{ route('emi.process') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary">Process Data</button>
            </form>
        </div>

        <h1>EMI Details</h1>

        @if(empty($columns))
            <p>No data processed yet. Click "Process Data" to generate EMI details.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Client ID</th>
                        @foreach($columns as $col)
                            <th>{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td>{{ $row->clientid }}</td>
                        @foreach($columns as $col)
                            <td>{{ $row->$col ?? 0.00 }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>

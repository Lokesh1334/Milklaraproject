<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Entries</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #333;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
        }
        .navbar-custom .nav-link:hover {
            color: #ddd;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">MilKyman</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="http://127.0.0.1:8000/milk-entry">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://127.0.0.1:8000/members">Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://127.0.0.1:8000/milk-entries">DailyRecord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Milk Entries</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Total Dates -->
        <h2>Total Dates: {{ $totalDates }}</h2>

        <!-- Detailed Milk Entries Table -->
        <h2>Detailed Milk Entries</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member Name</th>
                    <th>Quantity (Liters)</th>
                    <th>Date</th>
                    <th>Price per Liter</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailedMilkEntries as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        @php
                            $member = $members[$entry->member_id] ?? null;
                        @endphp
                        <td>{{ $member->name ?? 'Unknown' }}</td>
                        <td>{{ $entry->quantity }}</td>
                        <td>{{ $entry->date }}</td>
                        <td>{{ $entry->price_per_liter }}</td>
                        <td>{{ number_format($entry->quantity * $entry->price_per_liter, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Aggregated Data Table -->
        <h2>Aggregated Milk Entries</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Total Liters</th>
                    <th>Total Amount (₹)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aggregatedMilkEntries as $entry)
                    @php
                        $member = $members[$entry->member_id] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $member->name ?? 'Unknown' }}</td>
                        <td>{{ number_format($entry->total_quantity, 2) }}</td>
                        <td>{{ number_format($entry->total_amount, 2) }}</td>
                        <td>{{ $entry->date ?? 'N/A' }}</td> <!-- Assuming date is available for aggregated entries -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

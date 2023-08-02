<!DOCTYPE html>
<html>
<head>
    <title>Dillon - Invite Affiliates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th, tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@if ($fileNotFound)
    <h1>Affiliates input file not found.</h1>
@else
    <h1>Matching Affiliates within 100km of Dublin Office (Sorted)</h1>
    <table>
        <thead>
        <tr>
            <th>Affiliate ID</th>
            <th>Affiliate Name</th>
            <th>Distance From Office</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($matchingAffiliates as $affiliate)
            <tr>
                <td>{{ $affiliate->getID() }}</td>
                <td>{{ $affiliate->getName() }}</td>
                <td>{{ $affiliate->getDistanceFromDublinOffice() }}km</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
</body>
</html>

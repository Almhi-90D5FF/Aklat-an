<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Reservations List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Room</th>
                <th>Date</th>
                <th>Time Slot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->user_name }}</td>
                <td>{{ $reservation->room }}</td>
                <td>{{ $reservation->date }}</td>
                <td>{{ $reservation->time_slot }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Reservations: {{ $reservations->count() }}</p>
</body>
</html>
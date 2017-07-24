<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>The last added car is {{ $car->model }}</h1>

    <ul>
        <li>Color: {{ $car->color }}</li>
        <li>Registration number: {{ $car->registration_number }}</li>
        <li>Year: {{ $car->year }}</li>
        <li>Mileage: {{ $car->mileage }}</li>
        <li>Price: {{ $car->price }}</li>
    </ul>
</body>
</html>
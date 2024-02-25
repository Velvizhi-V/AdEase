<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Welcome to Admin Dashboard</h1>

    @if(isset($imagePath))
    <img src="{{ asset($imagePath) }}" alt="Final Image">
    <a href="{{ asset($imagePath) }}" download="final_image.png">Download Image</a>
    @endif
</body>

</html>
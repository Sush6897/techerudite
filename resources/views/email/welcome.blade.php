<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TechReudite</title>
    <!-- Include Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Welcome {{ $user['first_name'] }} {{ $user['last_name'] }}</div>

                <div class="card-body">
                    <p>Welcome to Techerudite!</p>
                    <p>Please click the following link to verify your email address and complete the registration process:</p>

                    <a href="{{ route('verify.email', ['id' => $user['id']]) }}" class="btn btn-primary">Verify Email</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap 5 JS and Popper.js for Bootstrap components (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

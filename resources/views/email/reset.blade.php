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
                
                <div class="card-header">

                
                </div>

                <div class="card-body">
                <h2>Password Reset Link</h2>
                <p>Hello {{ $user->first_name ." ". $user->last_name }},</p>
                <p>You are receiving this email because we received a password reset request for your account.</p>
                <p>
                    Click the following link to reset your password:
                    <a href="{{ url('reset-password', ['email' => $user->email, 'token' => $token]) }}">Reset Password</a>
                </p>
                <p>If you did not request a password reset, no further action is required.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap 5 JS and Popper.js for Bootstrap components (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

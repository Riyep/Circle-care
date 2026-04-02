<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="mt_username">Name:</label>
                <input type="text" name="mt_username" id="mt_username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mt_useremail">Email:</label>
                <input type="email" name="mt_useremail" id="mt_useremail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mt_departements_id" class="form-label">Departement</label>
                <select name="mt_departements_id" id="mt_departements_id" class="form-control" required>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->mt_departements_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="mt_positions_id" class="form-label">Position</label>
                <select name="mt_positions_id" id="mt_positions_id" class="form-control" required>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->mt_positions_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="mt_userpass">Password:</label>
                <input type="password" name="mt_userpass" id="mt_userpass" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p class="mt-3 text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</body>

</html>

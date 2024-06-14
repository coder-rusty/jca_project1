<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .registration-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .registration-form {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        .registration-form h4 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-form">
            <h4>{{ $category }} Judging Event</h4>
            <form action="{{ route('judges.login', ['event' => $event]) }}" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="accessCode" class="form-label">Access Code</label>
                    <input type="text" class="form-control" id="accessCode" name="accessCode" value="{{ $accessCode }}" required>
                </div>
                <input type="hidden" name="category" value="{{ $category }}" required>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</i></button>
                </div>
            </form>
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-eZvLbTMpPwV5By6K/iU6T6sGpH5Xfqt7WGPLbNnj6Hcg1JZ/6KLrGveJZY3fm3nF" crossorigin="anonymous"></script>
</body>
</html>

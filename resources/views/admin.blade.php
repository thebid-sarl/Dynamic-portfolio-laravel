<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>login</title>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex bg-secondary justify-content-center align-items-center mb-5">
                            <h5 class="text-light">Connexion</h5>
                        </div>
                        <form action="{{ route('login.post') }}" method="post">
                            @csrf

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <ul class="list-unstyled" style="width:max-content">
                                        <li class="alert alert-danger">{{ $error }}</li>
                                    </ul>
                                @endforeach
                            @endif

                            <div class="col-md-5">
                                <label class="labels" for="id">Id administrateur</label>
                                <input class="form-control" type="text" name="id">
                            </div>
                            <div class="col-md-5 mt-5">
                                <label class="labels" for="password">Mot de passe</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="col-md-6 mt-5">
                                <button class="btn btn-success" type="submit">se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

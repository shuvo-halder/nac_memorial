@php
    $errorPage = App\Models\ErrorPage::where('error_code', '419')->first();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Not Found</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/error.css') }}">
</head>

<body>
    <section id="hero">
        <div class="container position-relative">



            <div class="row">
                <div class="col-md-4 mx-auto justify-content-center align-items-center text-center">
                    <div class="image">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('assets/frontend/images/hero/logo1.png') }}" style="height: 130px"
                                alt="Logo1">
                        </a>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="hero-text">
                        <h1>{{ $errorPage->error_title ?? '404' }}</h1>
                        <h2>{{ $errorPage->error_message ?? 'Not Found!' }}
                        </h2>

                        <a class="backtohome" href="{{ route('index') }}">
                            <i class="fa-solid fa-arrow-left-long me-2"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>

            <!-- Shape -->
            <div class="shape">
                <img src="{{ asset('assets/frontend/images/hero/2.png') }}" alt="Background" class="bg1 plant">
                <img src="{{ asset('assets/frontend/images/hero/3.png') }}" alt="Background" class="bg2 plant">
                <img src="{{ asset('assets/frontend/images/hero/4.png') }}" alt="Background" class="bg3 plant">
                <img src="{{ asset('assets/frontend/images/hero/1.png') }}" alt="Background" class="bg4 star">
                <img src="{{ asset('assets/frontend/images/hero/1.png') }}" alt="Background" class="bg5 star">
                <img src="{{ asset('assets/frontend/images/hero/1.png') }}" alt="Background" class="bg6 star">
                <img src="{{ asset('assets/frontend/images/hero/1.png') }}" alt="Background" class="bg7 star">
            </div>
        </div>
    </section>

</body>

</html>

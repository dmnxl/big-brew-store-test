<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css"
        integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&display=swap" />
    <link rel="icon" type="image/png" href="{{ asset('img/big_brew_logo.png') }}">


    <title>Big Brew Store</title>

    <style>
        body {
            font-family: 'Lalezar';
            background: url('{{ asset('img/coffee_bg.png') }}');
            background-size: cover;
            height: 100%;
            position: absolute;
            width: 100%;
        }

        .kameron{
            font-family: 'Kameron', sans-serif;
        }
    </style>
</head>

<body>

    <div class="container pt-5 pb-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card shadow-lg" style="border-radius: 2rem; overflow: hidden;">
                    <div class="row g-0">
                        <!-- Left Image Section -->
                        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center"
                             style="background-color: #B46A1F; height: 500px; border-radius: 2rem 0 0 2rem;">
                            <div class="text-center">
                                <img src="{{ asset('img/big_brew.png') }}" alt="Support Image" class="img-fluid"
                                     style="height: 250px; border-radius: 1rem; margin-bottom: 20px;">
                                <h2 class="kameron text-white" style="padding: 0 20px;">
                                    Big in Taste, Bit in Price
                                </h2>
                            </div>
                        </div>

                        <!-- Right Login Section -->
                        <div class="col-md-6 d-flex align-items-center bg-light">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form action="{{ route('login.submit') }}" method="POST">
                                    @csrf
                                    <h3 class="text-center mb-4 font-weight-bold">Big Brew Store</h3>

                                    <!-- Username Input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" />
                                    </div>

                                    <!-- Password Input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" />
                                    </div>

                                    <!-- Login Button -->
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-lg btn-block text-white" style="background-color: #B46A1F">Log In</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

</body>

</html>

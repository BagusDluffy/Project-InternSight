<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InternSight | Login</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE/dist/css/adminlte.min.css?v=3.2.0">
  <style>
    body {
      /* background: linear-gradient(to bottom right, #6a11cb, #2575fc); */
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1081%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='rgba(0%2c 0%2c 0%2c 1)'%3e%3c/rect%3e%3cpath d='M1560 560L0 560 L0 327.99Q33.92 241.91%2c 120 275.84Q149.44 233.27%2c 192 262.71Q275.56 226.26%2c 312 309.82Q382.69 260.51%2c 432 331.2Q451.66 278.86%2c 504 298.51Q524.43 246.94%2c 576 267.37Q621.54 240.91%2c 648 286.45Q690.96 257.41%2c 720 300.37Q784.47 292.84%2c 792 357.31Q839.07 284.38%2c 912 331.45Q939.4 286.85%2c 984 314.25Q1014.41 272.66%2c 1056 303.08Q1101.99 229.07%2c 1176 275.07Q1257.59 236.65%2c 1296 318.24Q1318.44 268.68%2c 1368 291.12Q1397.26 248.38%2c 1440 277.64Q1533.7 251.34%2c 1560 345.04z' fill='rgba(39%2c 39%2c 39%2c 1)'%3e%3c/path%3e%3cpath d='M1464 560L0 560 L0 383.4Q43.2 354.6%2c 72 397.8Q122.68 376.48%2c 144 427.15Q157.85 321%2c 264 334.85Q310.26 309.11%2c 336 355.37Q425.89 325.26%2c 456 415.15Q475.99 363.13%2c 528 383.12Q573.84 356.96%2c 600 402.79Q642 324.78%2c 720 366.78Q773.01 299.79%2c 840 352.8Q868.07 308.88%2c 912 336.95Q968.67 321.63%2c 984 378.3Q1008.47 330.77%2c 1056 355.24Q1112.47 339.72%2c 1128 396.19Q1176.9 325.1%2c 1248 374Q1264.71 318.71%2c 1320 335.42Q1368.19 311.61%2c 1392 359.8Q1454.12 349.92%2c 1464 412.04z' fill='rgba(68%2c 68%2c 68%2c 1)'%3e%3c/path%3e%3cpath d='M1512 560L0 560 L0 481.38Q26.14 435.52%2c 72 461.67Q153.98 423.65%2c 192 505.64Q193.97 435.61%2c 264 437.58Q287.68 389.26%2c 336 412.94Q378.99 383.93%2c 408 426.92Q504.07 402.99%2c 528 499.06Q546.65 397.72%2c 648 416.37Q717.59 365.96%2c 768 435.55Q856.05 403.61%2c 888 491.66Q918.85 450.5%2c 960 481.35Q1013.64 415%2c 1080 468.64Q1110.86 379.5%2c 1200 410.36Q1266.76 357.12%2c 1320 423.87Q1368.97 400.84%2c 1392 449.8Q1446.73 384.53%2c 1512 439.27z' fill='rgba(89%2c 89%2c 89%2c 1)'%3e%3c/path%3e%3cpath d='M1488 560L0 560 L0 574.95Q41.05 544%2c 72 585.06Q90.16 531.22%2c 144 549.39Q194.3 479.69%2c 264 529.99Q312.03 458.02%2c 384 506.06Q412.6 462.66%2c 456 491.27Q554.32 469.59%2c 576 567.91Q580.16 500.07%2c 648 504.23Q700.04 436.27%2c 768 488.31Q826.35 474.66%2c 840 533.01Q921.39 494.4%2c 960 575.8Q988.67 484.47%2c 1080 513.15Q1103.43 464.58%2c 1152 488.02Q1234.42 450.44%2c 1272 532.87Q1329.07 517.94%2c 1344 575.01Q1365.28 524.28%2c 1416 545.56Q1434.64 492.2%2c 1488 510.85z' fill='rgba(128%2c 128%2c 128%2c 1)'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1081'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");
      background-size: cover;
      color: #fff;
      font-family: 'Nunito', sans-serif;
    }

    .register-box {
      width: 400px;
      margin: 50px auto;
    }

    .register-logo a {
      font-size: 2rem;
      font-weight: bold;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
      padding: 30px;
    }

    .btn-primary {
      background: #2575fc;
      border: none;
      font-weight: bold;
    }

    .btn-primary:hover {
      background: #1a5bb8;
    }

    .form-control {
      border-radius: 20px;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
      border-radius: 0 20px 20px 0;
      background: #2575fc;
      color: #fff;
    }

    .alert {
      border-radius: 10px;
    }
  </style>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="#" style="pointer-events:none; text-shadow:3px 3px 5px black" class="">InternSight</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Login Terlebih Dahulu</p>

        @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('dologin') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <a href="{{ route('welcome') }}" class="btn btn-secondary btn-block">Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>
  <script src="/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/AdminLTE/dist/js/adminlte.min.js"></script>
</body>

</html>
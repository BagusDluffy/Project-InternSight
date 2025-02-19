<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Pelanggaran Siswa | Register</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE/dist/css/adminlte.min.css?v=3.2.0">
  <style>
    body {
      background: linear-gradient(to bottom right, #6a11cb, #2575fc);
      font-family: 'Nunito', sans-serif;
      color: #fff;
    }

    .register-box {
      width: 400px;
      margin: 50px auto;
    }

    .register-logo a {
      color: #fff;
      font-size: 2rem;
      font-weight: bold;
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
      transition: background-color 0.3s ease-in-out;
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
      <a href="#" style="pointer-events:none">InternSight</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Daftar Akun Baru</p>

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

        <form action="{{ route('doregister') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
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
            <div class="col-12 text-center">
              <a href="{{ route('login') }}" class="text-secondary">Sudah punya akun? Login</a>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .dataTables_filter{
        margin-bottom: 15px !important;
      }
      .dt-input{
        margin-right: 15px !important;
      }
      .alert {
      position: fixed;
      top: 50px;
      right:: 50%;
      width: max-content;
      z-index: 9999; /* pastikan z-index lebih tinggi dari elemen lain */
      }

      .alert {
          position: relative;
      }
    </style>
  </head>
  <body>
    @if ($error = Session::get('error'))
    <div class="alert text-center m-auto" id="alert">
      <h3 class="text-black bg-danger p-3 rounded">{{ $error }}</h3>
    </div>
    @endif
    <div class="container w-25">
        <h1 class="text-center">Login</h1>
        <form action="{{ route('login.sso') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password" name="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      // Membuat alert menghilang setelah 1 detik
      setTimeout(function() {
          var alertContainer = document.getElementById('alert');
          if (alertContainer) {
              alertContainer.style.display = 'none';
          }
      }, 2000); // 1000 milidetik = 1 detik
    </script>
  </body>
</html>
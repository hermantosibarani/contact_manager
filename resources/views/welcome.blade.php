<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="../agent/">Contact List Management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../agent/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin') }}">Admin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('user') }}">User</a>
      </li>
    </ul>
    <span class="navbar-text">

    </span>
  </div>
</nav>

<div class="container-fluid mt-5">

</div>
<script type="text/javascript" src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
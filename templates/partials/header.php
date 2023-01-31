<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
  crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
    <div class="container">
      <a class="navbar-brand" href="#">ЕлеваторЮА</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php if (empty($_SESSION['user'])):?>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Дім</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Посилання</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Вимкнено</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false">Список таблиць</a>
              <ul class="dropdown-menu" aria-labelledby="dropdown07">
                <li><a class="dropdown-item" href="#">Список поставок</a></li>
                <li><a class="dropdown-item" href="#">Зерно на складах</a></li>
                <li><a class="dropdown-item" href="#">Елеватори</a></li>
                <li><a class="dropdown-item" href="#">Стандарти якості</a></li>
                <li><a class="dropdown-item" href="#">Постачальники</a></li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false">Звіти</a>
              <ul class="dropdown-menu" aria-labelledby="dropdown07">
                <li><a class="dropdown-item" href="#">Звіт 1</a></li>
                <li><a class="dropdown-item" href="#">Звіт 2</a></li>
                <li><a class="dropdown-item" href="#">Звіт 3</a></li>
              </ul>
            </li>

          <?php endif; ?>
          
        </ul>
      </div>
    </div>
  </nav>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
  crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
    <div class="container">
      <a class="navbar-brand" href="../index.php">ЕлеваторЮА</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php if ((!empty($_SESSION['logined']))&&($_SESSION['logined']===1))  :?>
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Crop" href="/tables/crop.php">Зберігання</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Standard" href="/tables/standard.php">Стандарти</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Warehouse" href="/tables/warehouse.php">Склади</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Consignment_OUT" href="/tables/consignment.php">Відправка</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Supplier" href="/tables/supplier.php">Постачальники</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" aria-current="page" id="Reports" href="../report.php">Звіти</a>
            </li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </nav>
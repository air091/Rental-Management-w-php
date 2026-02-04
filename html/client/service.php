<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../../style//style.css" />
  <title>Rental | Service</title>
</head>

<body>
  <div class="main-wrapper flex">
    <nav class="sidebar border border-blue-500">
      <a href="./dashboard.php" class="side <?= basename($_SERVER["PHP_SELF"]) == "dashboard.php" ? "active" : "" ?> block px-4 py-1">Dashboard</a>
      <a href="./service.php" class="side <?= basename($_SERVER["PHP_SELF"]) == "service.php" ? "active" : "" ?> block px-4 py-1">Service</a>
    </nav>

    <main class="border border-red-500 w-full">
      <header>
        <h1>Service</h1>
      </header>
      <div class="add service border">
        <h4>Add Service</h4>
        <div>
          <label for="service">Service</label>
          <input id="service" type="text" name="service" class="border block">
        </div>
        <div class="calendard modal">
          <header>
            <?php
            $year = date("Y");
            $month = date("m");
            $firstDay = strtotime("$year-$month-01");
            $totalDays = date("t", $firstDay);
            $startDay = date("w", $firstDay);
            ?>
            <span>
              <?= date("F j, Y") ?>
            </span>
          </header>
          <table>
            <thead>
              <tr>
                <?php
                $days = array("Sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "Saturday");
                foreach ($days as $day):
                ?>
                  <th class="days"><?= $day ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>

              <?php for ($i = 0; $i < $startDay; $i++): ?>
                <?= "<td></td>" ?>
              <?php endfor ?>
              <?php for ($day = 1; $day <= $totalDays; $day++): ?>
                <td class="text-red-500"><?= $day ?></td>

                <?php if ((($day + $startDay) % 7) == 0): ?>
                  <tr></tr>
                <?php endif ?>
              <?php endfor ?>

            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
  <script src="../../js//script.js"></script>
</body>

</html>
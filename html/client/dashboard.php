<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../../style/style.css" />
  <title>Rental | Dashboard</title>
</head>

<body>
  <div class="main-wrapper flex">
    
    <nav class="sidebar border border-blue-500">
      <a href="./dashboard.php" class="side <?= basename($_SERVER["PHP_SELF"]) == "dashboard.php" ? "active" : "" ?> block px-4 py-1">Dashboard</a>
      <a href="./service.php" class="side <?= basename($_SERVER["PHP_SELF"]) == "service.php" ? "active" : "" ?> block px-4 py-1">Service</a>
    </nav>

    <main class="w-full border border-red-500">
      <header>
        <h1>DASHBOARD</h1>
      </header>
      <a class="border px-4 py-1 rounded-sm cursor-pointer" href="./profile.php">Profile</a>
    </main>
  </div>
  <script src="../../js//script.js"></script>
</body>

</html>
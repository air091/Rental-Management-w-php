<?php require_once("../handlers/register-handler.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../style/style.css" />
  <title>Rental | Login</title>
</head>

<body>
  <div class="h-screen flex items-center justify-center">
    <div class="border border-stone-400 p-4 rounded-xl w-full max-w-72">
      <h1 class="text-2xl text-2xl text-center mb-2 font-medium">Login your Account</h1>
      <form method="POST" class="grid gap-y-2">
        <div>
          <label for="email" class="text-base mb-1 block">Email</label>
          <input id="email" type="text" name="email" class="block border border-stone-400 px-2 py-1 w-full rounded-sm">
        </div>
        <div>
          <label for="password" class="text-base mb-1 block">Password</label>
          <input id="password" type="password" name="password" class="block border border-stone-400 px-4 py-1 w-full rounded-sm">
        </div>
        <input type="submit" value="Login" class="block border border-stone-400 px-2 py-1 w-full mb-2 mt-2 rounded-sm font-medium cursor-pointer">
      </form>
      <p class="text-center">Don't have an account? <a href="./register.php" class="text-blue-600">Register</a></p>
    </div>

  </div>
</body>
</html>
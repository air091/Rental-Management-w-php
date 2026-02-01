

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../../custom-styles//style.css" />
    <title>Rental | Login</title>
  </head>
  <body>
    <div class="flex h-screen justify-center items-center">
      <div class="border w-full max-w-90 px-6 py-4 rounded-lg text-color">
        <h1 class="block text-2xl font-bold text-center mb-2">
          Login Your Account
        </h1>
        <form
          method="POST"
          action="../../phps/auth/loginForm.php"
          class="grid gap-y-1"
        >

        <!-- AUTH STATUS -->
        <?php if ($success): ?>
          <p class="text-green-600 text-center"><?= htmlspecialchars(
            $success,
          ) ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
          <p class="text-red-600 text-center"><?= htmlspecialchars(
            $error,
          ) ?></p>
        <?php endif; ?>

          <div>
            <label for="email">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              class="block w-full px-3 py-1 border rounded-sm"
            />
          </div>
          <div>
            <label for="password">Password</label>
            <input
              id="password"
              type="password"
              name="password"
              class="block px-3 py-1 border rounded-sm w-full"
            />
          </div>
          <div class="flex justify-center">
            <button
              type="submit"
              class="block border px-3 py-1 w-full max-w-40 cursor-pointer rounded-sm mt-2 mb-2 font-medium"
            >
              Login
            </button>
          </div>
        </form>
        <p class="text-center">
          Don't have an account?
          <a href="./register.html" class="text-blue-700">Register</a>
        </p>
      </div>
    </div>
  </body>
</html>

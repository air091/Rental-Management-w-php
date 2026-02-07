<?php require realpath(__DIR__ . "/../../services/auth/register.service.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./auth-style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Rental | Register</title>
</head>

<body>
  <div>
    <h1>Register your Account</h1>
    <form id="registration-form">
      <!-- STATUS -->
      <div id="error-container"></div>
      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email">
      </div>
      <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password">
      </div>
      <div>
        <button type="submit">Register</button>
      </div>
    </form>
    <p>Already have an account? <a href="./login.view.php">Login here</a></p>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const form = document.getElementById("registration-form");
      const errContainer = document.getElementById("error-container");

      form.addEventListener("submit", async (e) => {
        const errMsg = document.createElement("p");
        errMsg.classList = "err__message";
        e.preventDefault();
        errContainer.innerHTML = "";
        try { 
          const formData = new FormData(form);
          const response = await fetch("/rental-management/src/services/auth/register.service.php", {
            method: "POST",
            body: formData
          });
          const result = await response.json();
          if (result.success) {
            sucDiv.textContent = "User logged";
            form.reset();
          } else {
            errMsg.innerHTML = result.error;
            errContainer.prepend(errMsg);
          }
        } catch (error) {
          console.log("Register failed Script:", error);
        }

      });
    })
  </script>
</body>

</html>
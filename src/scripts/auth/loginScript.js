document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("login-form");
  const errContainer = document.getElementById("err-container");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    errContainer.textContent = "";

    try {
      const response = await fetch(
        "/rental-management/src/services/auth/login.service.php",
        {
          method: "POST",
          body: new FormData(form),
        },
      );
      const results = await response.json();
      if (results.success) {
        console.log(results.message);
        form.reset();
      } else {
        const strArr = results.error.split(", ");
        strArr.forEach((error) => {
          const errMessage = document.createElement("p");
          errMessage.classList = "err__message";
          errMessage.textContent = error;
          errContainer.appendChild(errMessage);
        });
      }
    } catch (error) {
      console.error("Login failed:", error);
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registration-form");
  const errContainer = document.getElementById("error-container");

  form.addEventListener("submit", async (e) => {
    const errMsg = document.createElement("p");
    errMsg.classList = "err__message";
    e.preventDefault();
    errContainer.innerHTML = "";
    try {
      const response = await fetch(
        "/rental-management/src/services/auth/register.service.php",
        {
          method: "POST",
          body: new FormData(form),
        },
      );
      const results = await response.json();
      if (results.success) {
        form.reset();
      } else {
        errMsg.innerHTML = results.error;
        errContainer.prepend(errMsg);
      }
    } catch (error) {
      console.error("Register failed Script:", error);
    }
  });
});

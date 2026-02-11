const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", async (event) => {
  event.preventDefault();

  try {
    const formData = new FormData(loginForm);

    const email = formData.get("email");
    const password = formData.get("password");

    const response = await fetch("http://localhost:8888/api/auth/login", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, password }),
    });
    const data = await response.json();
    if (!data.success) throw new Error(data.message);
    console.log(data.message);
    loginForm.reset();
  } catch (error) {
    console.error(`Login Form Failed: ${error}`);
  }
});

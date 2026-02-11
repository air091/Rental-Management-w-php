import React, { useState } from "react";
import type { IUserCredentials } from "../../interfaces/User";

export default function Login() {
  const [user, setUser] = useState<IUserCredentials>({
    email: "",
    password: "",
  });

  const loginAPI = async (email: string, password: string) => {
    try {
      const response = await fetch("http://localhost:8888/api/auth/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({ email, password }),
      });
      const data = await response.json();
      if (!data.success) throw new Error(data?.message);
      console.log(data.message);
      setUser({ email: "", password: "" });
    } catch (error) {
      console.error(`Login API Failed: ${error}`);
    }
  };

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setUser((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    await loginAPI(user.email, user.password);
  };

  return (
    <div>
      <header>
        <h1>Login your Account</h1>
      </header>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="email">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            onChange={handleChange}
            value={user.email || ""}
            className="block border"
          />
        </div>
        <div>
          <label htmlFor="password">Password</label>
          <input
            id="password"
            type="password"
            name="password"
            onChange={handleChange}
            value={user.password || ""}
            className="block border"
          />
        </div>
        <button type="submit" className="block border px-4">
          Login
        </button>
      </form>
    </div>
  );
}

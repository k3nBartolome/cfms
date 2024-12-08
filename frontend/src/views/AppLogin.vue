<template>
  <div
    class="flex items-center justify-center min-h-full px-4 pb-64 sm:px-6 lg:px-8"
  >
    <div class="w-full max-w-md space-y-8">
      <div class="items center">
        <img
          class="w-auto h-12 mx-auto"
          src="https://cdn.contactcenterworld.com/images/company/vxi-global-solutions-1200px-logo.png"
          alt="Your Company"
        />
        <h2
          class="mt-6 text-3xl font-bold tracking-tight text-center text-gray-900"
        >
          Sign in
        </h2>
      </div>

      <form class="mt-8 space-y-6" @submit.prevent="login">
        <div class="-space-y-px rounded-md shadow-sm">
          <div class="flex items center">
            <label for="email-address" class="sr-only">Email address</label>
            <input
              id="email-address"
              v-model="email"
              type="email"
              autocomplete="email"
              required="true"
              class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:z-10 focus:border-orange-600 focus:outline-none focus:ring-orange-600 sm:text-sm"
              placeholder="Email address"
            />
          </div>
          <div class="flex items center">
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              v-model="password"
              type="password"
              autocomplete="current-password"
              required="true"
              class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:z-10 focus:border-orange-600 focus:outline-none focus:ring-orange-600 sm:text-sm"
              placeholder="Password"
            />
          </div>
        </div>
        <span v-if="successMessage" class="text-red-500">{{
          successMessage
        }}</span>

        <div class="flex items center">
          <button
            type="submit"
            class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 border border-transparent rounded-md group hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
          >
            Sign in
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { mapMutations } from "vuex";

export default {
  data: () => ({
    email: "",
    password: "",
    successMessage: "",
  }),
  methods: {
    ...mapMutations([
      "setUser",
      "setToken",
      "setRole",
      "setUserId",
      "setPermissions",
      "setUserName",
    ]),
   async login(e) {
  e.preventDefault();

  try {
    // Step 1: Fetch CSRF token
    await axios.get("https://10.109.2.112/sanctum/csrf-cookie", {
      withCredentials: true,
    });

    // Step 2: Send login request
    const response = await axios.post(
      "https://10.109.2.112/api/login",
      {
        email: this.email,
        password: this.password,
      },
      { withCredentials: true }
    );

    // Step 3: Extract response data
    const { user, token, role, user_id, permissions } = response.data;

    // Log the token for debugging
    console.log("Token:", token);

    // Step 4: Save user info to Vuex store
    this.setUser(user);
    this.setToken(token);
    this.setRole(role);
    this.setUserId(user_id);
    this.setPermissions(permissions);

    // Step 5: Store token in localStorage
    localStorage.setItem("token", token);

    // Step 6: Set global Axios header
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    console.log("Logged in successfully with role:", role);

    // Step 7: Log role for debugging
    console.log("User role:", role);

    // Step 8: Redirect based on role
    if (role === "admin") {
      console.log("Redirecting to /onboarding_dashboard");
      await this.$router.push({ path: "/onboarding_dashboard" });
    } else if (role === "user") {
      console.log("Redirecting to /capfile");
      await this.$router.push({ path: "/capfile" });
    } else if (["remx", "sourcing", "budget"].includes(role)) {
      console.log("Redirecting to /dashboard_manager/request");
      await this.$router.push({ path: "/dashboard_manager/request" });
    }
  } catch (error) {
    console.error("Login Error:", error.response?.data || error.message);
    this.successMessage =
      error.response?.data?.message || "Invalid Credentials!";
  }
}


  },
};
</script>

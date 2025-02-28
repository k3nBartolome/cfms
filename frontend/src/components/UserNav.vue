<template>
  <div>
    <nav class="bg-white">
      <div class="max-w-full mx-auto sm:px-2 lg:px-4">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="w-8 h-8" src="logo.png" alt="Logo" />
            </div>
            <div class="flex-grow hidden ml-10 md:block">
              <div class="flex items-baseline justify-center space-x-4">
                <router-link
                  to="/capfile"
                  class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
                  v-if="isUser || isSourcing"
                  >Capacity File</router-link
                >
                <router-link
                  v-if="isUser || isBudget || isRemx || isSourcing"
                  to="/staffing"
                  class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
                  >Staffing Tracker</router-link
                >
                <!-- <router-link
                  to="/sr_compliance"
                  class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
                  >SR Pending Movements</router-link
                > -->
                <router-link
                  to="/h&s"
                  class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
                  v-if="isUser"
                  >H&S Tool</router-link
                >

                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    v-if="isUser || isBudget || isRemx || isSourcing"
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                  >
                    Inventory Tracker
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/dashboard_manager/request"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Dashboard</router-link
                    >
                    <router-link
                      to="/remx/supply_manager"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >REMX Supply</router-link
                    >
                    <router-link
                      to="/site_supply_manager/stocks"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Sourcing Supply</router-link
                    >
                    <router-link
                      to="/site_request_manager/request"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Request Manager</router-link
                    >
                    <router-link
                      to="/award_manager/normal"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Release Item</router-link
                    >
                  </div>
                </div>
                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                    v-if="isUser || isBudget || isRemx || isSourcing"
                  >
                    Sourcing
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/perx"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >PERX Tool</router-link
                    >
                    <router-link
                      to="/perxv2"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >PERX Tool SRv2</router-link
                    >
                    <router-link
                      to="/leads"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Leads</router-link
                    >
                    <router-link
                      to="/applicants"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Applicant Tool</router-link
                    >
                    <router-link
                      to="/referrals"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Referrals</router-link
                    >
                    <router-link
                      to="/referralsv1"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >OSS Referr</router-link
                    >
                  </div>
                </div>
                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                    v-if="isUser || isSourcing"
                  >
                    H&S
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/classes_information"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Classes</router-link
                    >
                  </div>
                </div>
                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                    v-if="isUser || isOnboarding"
                  >
                    Onboarding
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/onboarding_dashboard"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Onboarding Tool</router-link
                    > <router-link
                      to="/onboarding_list"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Employee List</router-link
                    >
                    <router-link
                      to="/onboarding_user_management"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >User Management</router-link
                    >
                  </div>
                </div>
                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                    v-if="isUser || isFrontdesk || isOnboarding"
                  >
                    Frontdesk
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/applicant_attendance_list"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Applicant Checker</router-link
                    >
                  </div>
                </div>
                <div
                  class="dropdown"
                  @mouseover="openDropdown"
                  @mouseleave="closeDropdown"
                  @click="toggleDropdown"
                >
                  <button
                    v-if="isUser || isBudget || isRemx || isSourcing"
                    class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
                  >
                    Admin
                  </button>
                  <div v-show="dropdownOpen" class="dropdown-content">
                    <router-link
                      to="/site_management"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Sites</router-link
                    >
                    <router-link
                      to="/program_management"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      >Programs</router-link
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="flex -mr-2 md:hidden">
              <button
                @click="toggleMobileMenu"
                class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
              >
                <span class="sr-only">Open main menu</span>
                <svg
                  class="block w-6 h-6"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                </svg>
              </button>
            </div>
          </div>
          <div class="flex items-center justify-end">
            <!-- <div
              class="dropdown"
              @mouseover="openDropdown"
              @mouseleave="closeDropdown"
              @click="toggleDropdown"
            >
              <button
                class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white"
              >
                Country
              </button>
              <div v-show="dropdownOpen" class="dropdown-content">
                <router-link
                  to="/capfile"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                  role="menuitem"
                  >Philippines</router-link
                >
                <router-link
                  to="/capfileguatemala"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                  role="menuitem"
                  >Guatemala</router-link
                >
                <router-link
                  to="/capfilejamaica"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                  role="menuitem"
                  >Jamaica</router-link
                >
              </div>
            </div> -->
            <router-link
              to="/profile"
              class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
              >{{ userName }}</router-link
            >
            <router-link
              to="/login"
              @click="logout"
              class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white link-button truncate"
              >Logout</router-link
            >
          </div>
        </div>
      </div>
      <div :class="{ block: mobileMenuOpen, hidden: !mobileMenuOpen }" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <!-- Capacity File -->
          <router-link
            to="/capfile"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white link-button"
            v-if="isUser || isSourcing"
          >
            Capacity File
          </router-link>
          <!-- Staffing Tracker -->
          <router-link
            to="/staffing"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white link-button"
          >
            Staffing Tracker
          </router-link>
          <!-- H&S Tool -->
          <router-link
            to="/h&s"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white link-button"
            v-if="isUser"
          >
            H&S Tool
          </router-link>
          <!-- Inventory Tracker Dropdown -->
          <div class="pt-2" v-if="isUser || isBudget || isRemx || isSourcing">
            <span class="block px-3 py-2 text-base font-medium text-gray-600"
              >Inventory Tracker</span
            >
            <router-link
              to="/dashboard_manager/request"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Dashboard</router-link
            >
            <router-link
              to="/remx/supply_manager"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >REMX Supply</router-link
            >
            <router-link
              to="/site_supply_manager/stocks"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Sourcing Supply</router-link
            >
            <router-link
              to="/site_request_manager/request"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Request Manager</router-link
            >
            <router-link
              to="/award_manager/normal"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Release Item</router-link
            >
          </div>
          <!-- Sourcing Dropdown -->
          <div class="pt-2" v-if="isUser || isBudget || isRemx || isSourcing">
            <span class="block px-3 py-2 text-base font-medium text-gray-600"
              >Sourcing</span
            >
            <router-link
              to="/perx"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >PERX Tool</router-link
            >
            <router-link
              to="/perxv2"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >PERX Tool SRv2</router-link
            >
            <router-link
              to="/leads"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Leads</router-link
            >
            <router-link
              to="/applicants"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Applicant Tool</router-link
            >
            <router-link
              to="/referrals"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Referrals</router-link
            >
            <router-link
              to="/referralsv1"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >OSS Referr</router-link
            >
          </div>

          <div class="pt-2" v-if="isUser || isOnboarding">
            <span class="block px-3 py-2 text-base font-medium text-gray-600 link-button"
              >Onboarding</span
            >
            <router-link
              to="/onboarding_dashboard"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
              role="menuitem"
              >Onboarding Tool</router-link
            >

            <router-link
              to="/onboarding_user_management"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              role="menuitem"
              >User Management</router-link
            >
            <router-link
              to="/onboarding_list"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              role="menuitem"
              >Employee List</router-link
            >
          </div>
          <div class="pt-2" v-if="isUser || isFrontdesk || isOnboarding">
            <span class="block px-3 py-2 text-base font-medium text-gray-600 link-button"
              >Frontdesk</span
            >
            <router-link
              to="/applicant_attendance_list"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              role="menuitem"
              >Applicant Checker</router-link
            >
          </div>

          <!-- Admin Dropdown -->
          <div class="pt-2" v-if="isUser || isBudget || isRemx || isSourcing">
            <span class="block px-3 py-2 text-base font-medium text-gray-600">Admin</span>
            <router-link
              to="/site_management"
              class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
            >
              Sites
            </router-link>
            <router-link
              to="/program_management"
              class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 link-button"
            >
              Programs
            </router-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dropdownOpen: false,
      mobileMenuOpen: false,
    };
  },
  computed: {
    userName() {
      const userName = this.$store.state.name;
      return userName;
    },
    isUser() {
      const userRole = this.$store.state.role;
      return userRole === "user";
    },
    isRemx() {
      const userRole = this.$store.state.role;
      return userRole === "remx";
    },
    isBudget() {
      const userRole = this.$store.state.role;
      return userRole === "budget";
    },
    isSourcing() {
      const userRole = this.$store.state.role;
      return userRole === "sourcing";
    },
    isOnboarding() {
      const userRole = this.$store.state.role;
      return userRole === "onboarding";
    },
    isFrontdesk() {
      const userRole = this.$store.state.role;
      return userRole === "frontdesk";
    },
  },

  methods: {
    logout() {
      try {
        this.$store.dispatch("logout"); // Dispatch the logout action
      } catch (error) {
        console.error("Error during logout:", error);
      }
    },
    openDropdown() {
      if (window.innerWidth > 768) {
        this.dropdownOpen = true;
      }
    },
    closeDropdown() {
      if (window.innerWidth > 768) {
        this.dropdownOpen = false;
      }
    },
    toggleDropdown() {
      if (window.innerWidth <= 768) {
        this.dropdownOpen = !this.dropdownOpen;
      }
    },
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    },
  },
};
</script>

<style>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 14px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
.link-button {
  text-decoration: none;
}
</style>

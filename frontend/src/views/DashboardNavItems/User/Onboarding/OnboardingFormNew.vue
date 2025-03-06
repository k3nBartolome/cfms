<template>
  <div class="px-1 py-1 mx-auto">
    <!-- Filter Section -->
    <div class="grid grid-cols-1 gap-2 mb-6 sm:grid-cols-2 md:grid-cols-4">
      <!-- Employee Status -->
      <div>
        <label
          for="employee_status"
          class="block mb-1 text-sm font-medium text-gray-600"
          >Employee Status</label
        >
        <select
          v-model="employee_status"
          id="employee_status"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Select Employee Status</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
          <option value="Separated">Separated</option>
        </select>
      </div>

      <!-- Employment Status -->
      <div>
        <label
          for="employment_status"
          class="block mb-1 text-sm font-medium text-gray-600"
          >Employment Status</label
        >
        <select
          v-model="employment_status"
          id="employment_status"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Select Employment Status</option>
          <option value="Hired">Hired</option>
          <option value="To be Hired">To be Hired</option>
        </select>
      </div>

      <!-- Hired Date Range -->
      <div>
        <label
          for="hired_date_from"
          class="block mb-1 text-sm font-medium text-gray-600"
          >Hired Date From</label
        >
        <input
          v-model="hired_date_from"
          type="date"
          id="hired_date_from"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div>
        <label
          for="hired_date_to"
          class="block mb-1 text-sm font-medium text-gray-600"
          >Hired Date To</label
        >
        <input
          v-model="hired_date_to"
          type="date"
          id="hired_date_to"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Region and Site -->
      <div>
        <label for="region" class="block mb-1 text-sm font-medium text-gray-600"
          >Region</label
        >
        <select
          v-model="selectedRegion"
          id="region"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Select Region</option>
          <option
            v-for="regionOption in regions"
            :key="regionOption"
            :value="regionOption"
          >
            {{ regionOption }}
          </option>
        </select>
      </div>
      <div>
        <label for="sites" class="block mb-1 text-sm font-medium text-gray-600"
          >Site</label
        >
        <select
          v-model="selectedSites"
          id="site"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Select Site</option>
          <option
            v-for="siteOption in sites"
            :key="siteOption.id"
            :value="siteOption.id"
          >
            {{ siteOption.name }}
          </option>
        </select>
      </div>

      <!-- Added By -->
      <div>
        <label
          for="employee_added_by"
          class="block mb-1 text-sm font-medium text-gray-600"
        >
          Added By
        </label>
        <div class="relative">
          <!-- Dropdown Trigger -->
          <div
            @click="toggleDropdown"
            class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer flex items-center justify-between"
          >
            <span>{{ selectedUsersLabel }}</span>
            <svg
              class="w-4 h-4 ml-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              ></path>
            </svg>
          </div>

          <!-- Dropdown Menu -->
          <div
            v-if="isDropdownOpen"
            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto"
          >
            <!-- Dropdown Options -->
            <div
              v-for="added in users"
              :key="added.user_id"
              class="p-2 hover:bg-gray-100 cursor-pointer flex items-center"
              @click="toggleUserSelection(added.user_id)"
            >
              <input
                type="checkbox"
                :value="added.user_id"
                v-model="employee_added_by"
                class="mr-2 rounded text-blue-500 focus:ring-blue-500"
              />
              <span class="text-sm text-gray-700">{{ added.name }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter and Export Buttons -->
      <div class="flex items-end space-x-2">
        <button
          @click="getEmployees"
          class="w-full p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 mx-auto"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
            />
          </svg>
        </button>
        <button
          @click="exportToExcel"
          class="w-full p-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 mx-auto"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
            />
          </svg>
        </button>
      </div>
    </div>

    <!-- Search Bar -->
    <div class="flex justify-end mb-4">
      <input
        v-model="searchTerm"
        type="text"
        class="w-full max-w-sm px-4 py-2 text-sm font-medium transition duration-300 ease-in-out border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 hover:shadow-md"
        placeholder="Search Employees"
        @input="getEmployees"
      />
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center py-4 space-x-2">
      <svg
        class="w-5 h-5 text-blue-500 animate-spin"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 4V2m0 20v-2m8-8h2M4 12H2m16.24-7.76l-1.42-1.42M5.18 18.36l-1.42 1.42M18.36 18.36l1.42-1.42M5.18 5.18L3.76 3.76"
        />
      </svg>
      <span class="text-gray-600">Loading...</span>
    </div>

    <!-- Employee Table -->
    <div class="overflow-x-auto rounded-lg shadow-sm">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-50">
          <tr>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
            >
              Action
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('site')"
            >
              Site
              <span v-if="sortColumn === 'site'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('employee_id')"
            >
              Employee ID
              <span v-if="sortColumn === 'employee_id'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('workday_id')"
            >
              Workday ID
              <span v-if="sortColumn === 'workday_id'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('last_name')"
            >
              Last Name

              <span v-if="sortColumn === 'last_name'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('first_name')"
            >
              First Name
              <span v-if="sortColumn === 'first_name'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('middle_name')"
            >
              Middle Name
              <span v-if="sortColumn === 'middle_name'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('birthdate')"
            >
              Date of Birth
              <span v-if="sortColumn === 'birthdate'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('contact_number')"
            >
              Contact Number
              <span v-if="sortColumn === 'contact_number'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('email')"
            >
              Email
              <span v-if="sortColumn === 'email'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('hired_date')"
            >
              Hired Date
              <span v-if="sortColumn === 'hired_date'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('hired_month')"
            >
              Hired Month
              <span v-if="sortColumn === 'hired_month'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('employee_status')"
            >
              Employee Status
              <span v-if="sortColumn === 'employee_status'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('employment_status')"
            >
              Employment Status
              <span v-if="sortColumn === 'employment_status'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('account_associate')"
            >
              Position
              <span v-if="sortColumn === 'last_name'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('account_associate')"
            >
              Account Type
              <span v-if="sortColumn === 'account_associate'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate cursor-pointer"
              @click="sortTable('employee_added_by')"
            >
              Added By
              <span v-if="sortColumn === 'last_name'">
                {{ sortOrder === "asc" ? "↑" : "↓" }}
              </span>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr
            v-for="employee in employees"
            :key="employee.id"
            class="transition-colors hover:bg-gray-50"
          >
            <td class="px-3 py-2">
              <button
                @click="goToUpdate(employee.id)"
                class="text-blue-500 hover:text-blue-600"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
              </button>
            </td>

            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.site }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_id }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.workday_id }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_last_name }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_first_name }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_middle_name }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_birth_date }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_contact_number }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_email }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_hired_date }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_hired_month }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_employee_status }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_employment_status }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_position }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_account_type }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-700 truncate">
              {{ employee.employee_added_by || "N/A" }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-center mt-6 space-x-2">
      <button
        @click="goToPage(pagination.first_page)"
        :disabled="!pagination.prev_page"
        class="p-2 text-gray-600 hover:text-blue-500 disabled:text-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"
          />
        </svg>
      </button>
      <button
        @click="goToPage(pagination.prev_page)"
        :disabled="!pagination.prev_page"
        class="p-2 text-gray-600 hover:text-blue-500 disabled:text-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
      </button>
      <span class="text-sm text-gray-600"
        >Page {{ pagination.current_page }} of
        {{ pagination.total_pages }}</span
      >
      <button
        @click="goToPage(pagination.next_page)"
        :disabled="!pagination.next_page"
        class="p-2 text-gray-600 hover:text-blue-500 disabled:text-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          />
        </svg>
      </button>
      <button
        @click="goToPage(pagination.last_page)"
        :disabled="!pagination.next_page"
        class="p-2 text-gray-600 hover:text-blue-500 disabled:text-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 5l7 7-7 7M5 5l7 7-7 7"
          />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      searchTerm: "",
      employees: [],
      selectedRegion: "", // Stores the selected region
      selectedSites: [], // Stores the selected sites
      regions: [], // All regions fetched from the API
      sites: [], // All sites fetched from the API
      filteredSites: [], // Sites filtered based on the selected region
      loading: false,
      scannedValue: "",
      extractedId: "",
      employee_status: "",
      employment_status: "",
      filterSite: "",
      hired_date_from: "",
      hired_date_to: "",
      filterContact: "",
      users: [],
      employee_added_by: [],
      isDropdownOpen: false,
      employee_statusError: "",
      filterContactError: "",
      earchQuery: "",
      debounceTimeout: null,
      sortColumn: "hired_date", // Default sort column
      sortOrder: "asc", // Default order
      pagination: {
        current_page: 1,
        total: 0,
        first_page: null,
        last_page: null,
        next_page: null,
        prev_page: null,
        per_page: 10,
        total_pages: 1,
      },
      selectedEmployee: null,
    };
  },
  watch: {
    employee_added_by(newValue) {
      console.log("Selected employee_added_by:", newValue);
    },
    sortOrder(newVal) {
      console.log("Sort Order Updated:", newVal);
    },
  },

  computed: {
    formattedFilterDate() {
      return this.filterDate
        ? new Date(this.filterDate).toLocaleDateString("en-CA")
        : "";
    },
    selectedUsersLabel() {
      if (this.employee_added_by.length === 0) {
        return "Added By";
      }
      return this.users
        .filter((user) => this.employee_added_by.includes(user.user_id))
        .map((user) => user.name)
        .join(", ");
    },
  },
  mounted() {
    this.getEmployees();
    this.getSites(); // Fetch sites when the component mounts
    this.getRegion();
    this.getUsers();
  },
  methods: {
    sortTable(column) {
      if (this.sortColumn === column) {
        // Toggle between 'asc' and 'desc' if the same column is clicked
        this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
      } else {
        // If a different column is clicked, reset to 'asc'
        this.sortColumn = column;
        this.sortOrder = "asc";
      }

      console.log(`Sorting ${this.sortColumn} in ${this.sortOrder} order`); // Debugging
      this.getEmployees();
    },

    goToProfile(employeeId) {
      this.$router.push({
        name: "OnboardingEmployeeProfile",
        params: { id: employeeId },
      });
    },
    goToUpdate(employeeId) {
      this.$router.push({
        name: "OnboardingUpdateForm",
        params: { id: employeeId },
      });
    },
    async getUsers() {
      this.loading = true;
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          `https://10.109.2.112/api/added_users`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.users = response.data.data;
        } else {
          console.error("Error fetching users");
        }
      } catch (error) {
        console.error("Error fetching users:", error);
      } finally {
        this.loading = false;
      }
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    toggleUserSelection(userId) {
      const index = this.employee_added_by.indexOf(userId);
      if (index === -1) {
        this.employee_added_by.push(userId);
      } else {
        this.employee_added_by.splice(index, 1);
      }
    },

    goToPage(page) {
      if (!page || page < 1 || page > this.pagination.total_pages) {
        console.warn("Invalid page navigation:", page);
        return;
      }
      this.pagination.current_page = page;
      this.getEmployees();
    },
    async getRegion() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get("https://10.109.2.112/api/regions", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.regions = response.data.data;
        }
      } catch (error) {
        console.error("Error fetching regions:", error);
      }
    },
    async getSites() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/index_sites",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.sites = response.data.data;
          // Initialize filteredSites
        }
      } catch (error) {
        console.error("Error fetching sites:", error);
      }
    },
    filterSitesByRegion() {
      if (this.selectedRegion) {
        // Filter sites based on the selected region
        this.filteredSites = this.sites.filter(
          (site) => site.region_id === this.selectedRegion
        );
      } else {
        // If no region is selected, show all sites
        this.filteredSites = this.sites;
      }

      // Clear selected sites when the region changes
      this.selectedSites = [];
    },
    async getEmployees() {
      clearTimeout(this.debounceTimeout);
      this.debounceTimeout = setTimeout(async () => {
        this.loading = true;
        try {
          const token = this.$store.state.token;

          // Prepare the params object
          const params = {
            region: this.selectedRegion,
            site: this.selectedSites,
            search_term: this.searchTerm,
            employee_status: this.employee_status,
            employment_status: this.employment_status,
            hired_date_from: this.hired_date_from,
            hired_date_to: this.hired_date_to,
            sort_by: this.sortColumn, // Add sort_by parameter
            sort_order: this.sortOrder, // Add sort_order parameter
            page: this.pagination.current_page,
          };

          // Add employee_added_by to params if it has values
          if (this.employee_added_by && this.employee_added_by.length > 0) {
            params.employee_added_by = this.employee_added_by.join(","); // Convert array to comma-separated string
          }

          // Get site IDs from the store
          const siteIds = this.$store.state.site_id.join(",");

          // Make the API request
          const response = await axios.get(
            `https://10.109.2.112/api/employees_data/${siteIds}`,
            {
              params,
              headers: { Authorization: `Bearer ${token}` },
            }
          );

          // Handle the response
          if (response.status === 200) {
            this.employees = response.data.employees || [];
            this.pagination = response.data.pagination || {};
          } else {
            console.error("Failed to fetch employees:", response.statusText);
          }
        } catch (error) {
          console.error("Error fetching employees:", error);
        } finally {
          this.loading = false;
        }
      }, 500);
    },
    async checkEmployeeExists(employeeId) {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          `https://10.109.2.112/api/employees/${employeeId}`,
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        if (response.status === 200 && response.data.employee) {
          this.navigateToUpdateForm(employeeId);
        } else {
          alert("Employee not found.");
        }
      } catch (error) {
        if (error.response && error.response.status === 404) {
          alert("Employee not found.");
        } else {
          console.error("Error fetching employee:", error);
          alert("An error occurred. Please try again.");
        }
      }
    },
    navigateToUpdateForm(employeeId) {
      this.$router.push({
        name: "OnboardingUpdateSelection",
        params: { id: employeeId },
      });
    },
    updatehired_date_from(event) {
      this.hired_date_from = event.target.value;
    },

    updateFilterEndDate(event) {
      this.hired_date_to = event.target.value;
    },
    async exportToExcel() {
      try {
        const token = this.$store.state.token;
        const siteIds = Array.isArray(this.$store.state.site_id)
          ? this.$store.state.site_id.join(",")
          : "";

        console.log("Exporting data for site IDs:", siteIds);

        // Prepare the params object
        const params = {
          region: this.selectedRegion,
          site: this.selectedSites,
          search_term: this.searchTerm,
          employee_status: this.employee_status,
          employment_status: this.employment_status,
          hired_date_from: this.hired_date_from,
          hired_date_to: this.hired_date_to,
          sort_by: this.sortColumn, // Add sort_by parameter
          sort_order: this.sortOrder, // Add sort_order parameter
          page: this.pagination.current_page,
        };

        // Add employee_added_by to params if it has values
        if (this.employee_added_by && this.employee_added_by.length > 0) {
          params.employee_added_by = this.employee_added_by.join(","); // Convert array to comma-separated string
        }

        // Make the API request
        const response = await axios.get(
          `https://10.109.2.112/api/employees_export/${siteIds}`,
          {
            params,
            headers: {
              Authorization: `Bearer ${token}`,
            },
            responseType: "blob", // Ensure the response is treated as a binary file
          }
        );

        // Handle the response (download the Excel file)
        const blob = new Blob([response.data], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "employees_data.xlsx";
        link.click();

        // Clean up the URL object
        window.URL.revokeObjectURL(url);
      } catch (error) {
        console.error("Error exporting filtered data to Excel", error);
      } finally {
        this.exportLoading = false;
      }
    },
  },
};
</script>

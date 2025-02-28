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
          >Added By</label
        >
        <select
          v-model="employee_added_by"
          id="employee_added_by"
          class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled selected>Added By</option>
          <option
            v-for="added in users"
            :key="added.user_id"
            :value="added.user_id"
          >
            {{ added.name }}
          </option>
        </select>
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
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Action
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Site
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Employee ID
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Workday ID
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Last Name
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              First Name
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Middle Name
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Date of Birth
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Contact Number
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Email
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Hired Date
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Hired Month
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Employee Status
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Employment Status
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Position
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Account Type
            </th>
            <th
              class="px-3 py-2 text-sm font-medium text-left text-gray-600 truncate"
            >
              Added By
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
      employee_added_by: "",
      users: [],
      employee_statusError: "",
      filterContactError: "",
      earchQuery: "",
      debounceTimeout: null,
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
  },

  computed: {
    formattedFilterDate() {
      return this.filterDate
        ? new Date(this.filterDate).toLocaleDateString("en-CA")
        : "";
    },
  },
  mounted() {
    this.getEmployees();
    this.getSites(); // Fetch sites when the component mounts
    this.getRegion();
    this.getUsers();
  },
  methods: {
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
      this.loading = true; // Set loading to true
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
        this.loading = false; // Set loading to false when done
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
          const params = {
            region: this.selectedRegion,
            site: this.selectedSites,
            search_term: this.searchTerm,
            employee_status: this.employee_status,
            employment_status: this.employment_status,
            hired_date_from: this.hired_date_from,
            hired_date_to: this.hired_date_to,
            employee_added_by: this.employee_added_by, // Make sure this is added
            page: this.pagination.current_page,
          };

          const siteIds = this.$store.state.site_id.join(",");

          const response = await axios.get(
            `https://10.109.2.112/api/employees_data/${siteIds}`,
            {
              params,
              headers: { Authorization: `Bearer ${token}` },
            }
          );

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
        const response = await axios.get(
          `https://10.109.2.112/api/employees_export/${siteIds}`,
          {
            params: {
              region: this.selectedRegion,
              site: this.selectedSites,
              search_term: this.searchTerm,
              employee_status: this.employee_status,
              employment_status: this.employment_status,
              hired_date_from: this.hired_date_from,
              hired_date_to: this.hired_date_to,
              employee_added_by: this.employee_added_by,
              page: this.pagination.current_page,
            },
            headers: {
              Authorization: `Bearer ${token}`,
            },
            responseType: "blob",
          }
        );
        const blob = new Blob([response.data], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "employees_data.xlsx";
        link.click();
      } catch (error) {
        console.error("Error exporting filtered data to Excel", error);
      } finally {
        this.exportLoading = false;
      }
    },
  },
};
</script>

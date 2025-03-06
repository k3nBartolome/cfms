<template>



    <div class="px-4 py-4">
      <form @submit.prevent="postUser">
        <div class="mb-4">
          <div class="px-4 py-4 border rounded-lg bg-gray-50">
            <div
              class="grid grid-cols-5 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-6"
            >
              <!-- Name Input -->
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">
                  Name
                </label>
                <input
                  v-model="name"
                  type="text"
                  class="w-full p-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Email Input -->
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">
                  Email
                </label>
                <input
                  v-model="email"
                  type="email"
                  class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  required
                />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">
                  Sites</label
                >

                <select
                  v-model="sites_selected"
                  class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  required
                  @change="getSites"
                >
                  <option disabled value="" selected>Please select one</option>
                  <option v-for="site in sites" :key="site.id" :value="site.id">
                    {{ site.name }}
                  </option>
                </select>
              </div>

              <!-- Roles Dropdown -->
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">
                  Roles</label
                >
                <select
                  v-model="roles_selected"
                  class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  required
                  @change="getRoles"
                >
                  <option disabled value="" selected>Please select one</option>
                  <option
                    v-for="role in roles"
                    :key="role.id"
                    :value="role.name"
                  >
                    {{ role.name }}
                  </option>
                </select>
              </div>

              <!-- Password Input -->
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">
                  Password
                </label>
                <input
                  v-model="password"
                  type="password"
                  class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  required
                />
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                class="flex items-center justify-center px-2 py-2 font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
              >
                <i class="mr-2 fa fa-building"></i> Add User
              </button>
            </div>
          </div>
        </div>
      </form>

    <div class="">
      <div class="flex justify-end mb-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search users..."
            class="w-full max-w-sm px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            @input="debouncedSearch"
          />
        </div>
        <div v-if="loading" class="flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4V2m0 20v-2m8-8h2M4 12H2m16.24-7.76l-1.42-1.42M5.18 18.36l-1.42 1.42M18.36 18.36l1.42-1.42M5.18 5.18L3.76 3.76" />
          </svg>
          <span class="ml-2 text-blue-500">Loading...</span>
        </div>
        <div class="overflow-x-auto">
          <table v-if="!loading" class="min-w-full border border-collapse border-gray-200 table-auto">
          <thead class="bg-blue-50">
            <tr>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Name
              </th>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Email
              </th>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Roles
              </th>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Created At
              </th>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Updated At
              </th>
              <th
                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase truncate"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr
              v-for="user in users.data"
              :key="user.user_id"
              class="hover:bg-gray-50"
            >
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                {{ user.name }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                {{ slicedEmail(user.email) }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                {{ slicedRoles(user.roles) }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                {{ user.created_at }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                {{ user.updated_at }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 truncate">
                <button
                  @click="editUser(user)"
                  class="px-3 py-1 text-sm font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                  <i class="fa fa-edit"></i>
                </button>
                <button
                  @click="deleteUser(user.user_id)"
                  class="px-3 py-1 ml-2 text-sm font-semibold text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between mt-4">
          <button
            @click="changePage(currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg disabled:opacity-50"
          >
            Previous
          </button>
          <span class="px-4 py-2 text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
          <button
            @click="changePage(currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
  </div>

</div>
    <!-- Edit User Modal -->
    <div
      v-if="showEditModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50"
    >
      <div class="w-full max-w-md p-6 bg-white rounded-lg">
        <h3 class="mb-4 text-lg font-semibold">Edit User</h3>
        <form @submit.prevent="saveEditedUser">
          <!-- Name Input -->
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-600">
              Name
            </label>
            <input
              v-model="selectedUser.name"
              type="text"
              class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>

          <div>
            <label class="block mt-4"> Email </label>
            <input
              v-model="selectedUser.email"
              type="email"
              class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
          <div>
            <label class="block mt-4"> Password </label>
            <input
              v-model="selectedUser.password"
              type="password"
              class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Leave blank to keep current password"
            />
          </div>
          <label class="block mt-4">
            Role
            <select
              v-model="selectedUser.role"
              class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option disabled value="">Select a role</option>
              <option v-for="role in roles" :key="role.id" :value="role.name">
                {{ role.name }}
              </option>
            </select>
          </label>

          <!-- Single Site Dropdown -->
          <label class="block mt-4">
            Assigned Site
            <select
              v-model="selectedUser.site_id"
              class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option disabled value="">Select a site</option>
              <option v-for="site in sites" :key="site.id" :value="site.id">
                {{ site.name }}
              </option>
            </select>
          </label>

          <!-- Save and Cancel Buttons -->
          <div class="flex justify-end mt-4">
            <button
              type="submit"
              class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600"
            >
              Save
            </button>
            <button
              @click="showEditModal = false"
              class="px-4 py-2 ml-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
</template>

<script>
import "font-awesome/css/font-awesome.min.css";
import axios from "axios";
import debounce from "lodash/debounce";

export default {
  data() {
    return {
      users: {
        data: [],
        meta: {},
      },
      roles_selected: "",
      sites_selected: "",
      name: "",
      roles: [],
      sites: [],
      email: "",
      password: "",
      searchQuery: "",
      currentPage: 1,
      perPage: 5, // Default perPage value matching backend
      totalPages: 1,
      loading: false,
      showEditModal: false, // Controls the edit modal
      selectedUser: {
        user_id: null,
        name: "",
        email: "",
        password: "",
        role: "",
        site_id: "", // Single site ID
      },
    };
  },
  mounted() {
    this.getUsers();
    this.getRoles();
    this.getSites();
  },
  methods: {
    // Fetch users with pagination and search
    async getUsers(page = 1) {
      this.loading = true;
      try {
        const token = this.$store.state.token;
        const params = {
          page: page,
          perPage: this.perPage,
          search: this.searchQuery,
        };

        const response = await axios.get(
          "https://10.109.2.112/api/list_user",
          {
            params,
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.users = response.data;
          this.totalPages = response.data.meta.last_page;
          this.currentPage = page;
        }
      } catch (error) {
        console.error("Error fetching users:", error);
      } finally {
        this.loading = false;
      }
    },
    slicedRoles(roles) {
      return roles.toString().toUpperCase();
    },
    slicedEmail(roles) {
      return roles.toLowerCase();
    },
    debouncedSearch: debounce(function () {
      this.getUsers(1); // Reset to page 1 on new search
    }, 300),

    // Change the page and fetch users for the selected page
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.getUsers(page);
      }
    },

    // Fetch all sites for the modal
    async getSites() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get("https://10.109.2.112/api/sites", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.sites = response.data.data;
        }
      } catch (error) {
        console.error("Error fetching sites:", error);
      }
    },

    // Fetch all roles
    async getRoles() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/list_role",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.roles = response.data.data;
        }
      } catch (error) {
        console.error("Error fetching roles:", error);
      }
    },

    // Add a new user
    async postUser() {
      try {
        const token = this.$store.state.token;
        const response = await axios.post(
          "https://10.109.2.112/api/create_user",
          {
            name: this.name,
            role: this.roles_selected,
            email: this.email,
            site_id: this.sites_selected,
            password: this.password,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.getUsers(this.currentPage); // Refresh the user list
          this.resetForm();
        }
      } catch (error) {
        console.error("Error adding user:", error);
      }
    },

    // Delete a user
    async deleteUser(user_id) {
      try {
        const token = this.$store.state.token;
        const response = await axios.delete(
          `https://10.109.2.112/api/delete_user/${user_id}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.getUsers(this.currentPage); // Refresh the user list
        }
      } catch (error) {
        console.error("Error deleting user:", error);
      }
    },

    // Open the edit modal
    editUser(user) {
      this.selectedUser = {
        user_id: user.user_id,
        name: user.name,
        email: user.email,
        password: "", // Reset password field
        role: user.roles[0] || "", // Assuming a user has only one role
        site_id: user.assigned_sites[0]?.id || "", // Single site ID
      };
      this.showEditModal = true;
    },

    // Save the edited user
    async saveEditedUser() {
      try {
        const token = this.$store.state.token;
        const response = await axios.put(
          `https://10.109.2.112/api/update_user/${this.selectedUser.user_id}`,
          {
            name: this.selectedUser.name,
            email: this.selectedUser.email,
            password: this.selectedUser.password || undefined, // Only send if provided
            role: this.selectedUser.role,
            site_id: this.selectedUser.site_id, // Single site ID
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.showEditModal = false; // Close the modal
          this.getUsers(this.currentPage); // Refresh the user list
        }
      } catch (error) {
        console.error("Error updating user:", error);
      }
    },

    // Reset the form
    resetForm() {
      this.name = "";
      this.email = "";
      this.sites_selected = "";
      this.roles_selected = "";
      this.password = "";
    },
  },
};
</script>

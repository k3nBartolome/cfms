<template>
  <header class="w-full bg-white shadow">
    <div class="flex items-center w-full max-w-screen-xl py-2 sm:px-2 lg:px-2">
      <h2 class="pl-8 text-3xl font-bold tracking-tight text-gray-900">
        Program Manager
      </h2>
    </div>
  </header>
  <div class="py-8">
    <div
      class="px-4 py-6 mx-auto bg-white border-2 border-orange-600 max-w-7xl sm:px-6 lg:px-8"
    >
      <form
        @submit.prevent="addProgram"
        class="grid grid-cols-1 gap-4 font-semibold sm:grid-cols-2 md:grid-cols-5"
      >
        <label class="block">
          Name
          <input
            type="text"
            v-model="name"
            class="block w-full mt-1 border rounded-md focus:border-orange-600 focus:ring focus:ring-orange-600 focus:ring-opacity-100"
            required
          />
        </label>
        <label class="block">
          Description
          <input
            type="text"
            v-model="description"
            class="block w-full mt-1 border rounded-md focus:border-orange-600 focus:ring focus:ring-orange-600 focus:ring-opacity-100"
            required
          />
        </label>
        <label class="block">
          Program Group
          <input
            type="text"
            v-model="program_group"
            class="block w-full mt-1 border rounded-md focus:border-orange-600 focus:ring focus:ring-orange-600 focus:ring-opacity-100"
            required
          />
        </label>
        <label class="block">
          Site
          <select
            v-model="sites_selected"
            class="block w-full mt-1 border rounded-md focus:border-orange-600 focus:ring focus:ring-orange-600 focus:ring-opacity-100"
            required
            @change="getSites"
          >
            <option disabled value="" selected>Please select one</option>
            <option v-for="site in sites" :key="site.id" :value="site.id">
              {{ site.name }}
            </option>
          </select>
        </label>
        <button
          type="submit"
          class="px-4 py-1 font-bold text-white bg-orange-500 rounded hover:bg-gray-600"
        >
          <i class="fa fa-building"></i> Add
        </button>
      </form>
    </div>
  </div>
  <div class="py-8">
    <div class="pl-8 pr-8 overflow-x-auto overflow-y-auto">
      <div class="mb-4">
        <input
          type="text"
          v-model="search"
          placeholder="Search..."
          class="px-6 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
        />
      </div>
      <table class="w-full text-white table-auto">
        <thead>
          <tr
            class="text-left bg-orange-500 border-2 border-orange-600 border-solid"
          >
            <th class="px-1 py-1 truncate whitespace-no-wrap border">ID</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">Name</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">Site</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Created by
            </th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Created date
            </th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Active Status
            </th>
            <th
              class="px-1 py-1 truncate whitespace-no-wrap border"
              colspan="3"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody v-for="program3 in filteredPrograms3" :key="program3.id">
          <tr
            class="font-semibold text-black bg-white border-2 border-gray-400 border-solid"
          >
            <td class="px-1 py-1">{{ program3.id }}</td>
            <td class="px-1 py-1">{{ program3.name }}</td>
            <td class="px-1 py-1">{{ program3.site.name }}</td>
            <td class="px-1 py-1">{{ program3.created_by_user.name }}</td>
            <td class="px-1 py-1">{{ program3.created_at }}</td>
            <td class="px-1 py-1">
              {{ program3.is_active == 1 ? "Active" : "Inactive" }}
            </td>
            <td class="px-2 py-2">
              <router-link :to="`/program_management/edit/${program3.id}`">
                <button
                  @click="getPrograms(program3.id)"
                  class="flex items-center h-8 px-1 py-1 text-xs font-semibold text-center text-white uppercase truncate whitespace-no-wrap transition duration-150 ease-in-out bg-blue-600 border-0 rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none disabled:opacity-25"
                >
                  Edit
                </button>
              </router-link>
            </td>
            <td class="px-2 py-2">
              <button
                @click="deactivateProgram(program3.id)"
                class="flex items-center h-8 px-1 py-1 text-xs font-semibold text-white uppercase truncate whitespace-no-wrap transition duration-150 ease-in-out bg-red-600 border-0 rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none disabled:opacity-25"
              >
                Deactivate
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="py-8">
    <div class="pl-8 pr-8 overflow-x-auto overflow-y-auto">
      <div class="mb-4">
        <input
          type="text"
          v-model="search2"
          placeholder="Search..."
          class="px-6 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
        />
      </div>
      <table class="w-full text-white table-auto">
        <thead>
          <tr
            class="text-left bg-orange-500 border-2 border-orange-600 border-solid"
          >
            <th class="px-1 py-1 truncate whitespace-no-wrap border">ID</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">Name</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">Site</th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Created by
            </th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Created date
            </th>
            <th class="px-1 py-1 truncate whitespace-no-wrap border">
              Active Status
            </th>
            <th
              class="px-1 py-1 truncate whitespace-no-wrap border"
              colspan="3"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody v-for="program4 in filteredPrograms4" :key="program4.id">
          <tr
            class="font-semibold text-black bg-white border-2 border-gray-400 border-solid"
          >
            <td class="px-1 py-1">{{ program4.id }}</td>
            <td class="px-1 py-1">{{ program4.name }}</td>
            <td class="px-1 py-1">{{ program4.site.name }}</td>
            <td class="px-1 py-1">{{ program4.created_by_user.name }}</td>
            <td class="px-1 py-1">{{ program4.created_at }}</td>
            <td class="px-1 py-1">
              {{ program4.is_active == 1 ? "Active" : "Inactive" }}
            </td>
            <td class="px-2 py-2">
              <router-link :to="`/program_management/edit/${program4.id}`">
                <button
                  @click="getPrograms(program4.id)"
                  class="flex items-center h-8 px-1 py-1 text-xs font-semibold text-center text-white uppercase truncate whitespace-no-wrap transition duration-150 ease-in-out bg-blue-600 border-0 rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none disabled:opacity-25"
                >
                  Edit
                </button>
              </router-link>
            </td>
            <td class="px-2 py-2">
              <button
                @click="activateProgram(program4.id)"
                class="flex items-center h-8 px-1 py-1 text-xs font-semibold text-white uppercase truncate whitespace-no-wrap transition duration-150 ease-in-out bg-red-600 border-0 rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none disabled:opacity-25"
              >
                Activate
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      programs3: [],
      programs4: [],
      name: "",
      description: "",
      program_group: "",
      sites_selected: "",
      sites: [],
      currentPage: 1,
      perPage: 5,
      search: "",
      search2: "",
    };
  },

  mounted() {
    console.log("Component mounted.");
    this.getPrograms3();
    this.getPrograms4();
    this.getSites();
  },
  computed: {
    filteredPrograms3() {
      return this.programs3.filter((programs3) =>
        programs3.name.toLowerCase().includes(this.search.toLowerCase())
      );
    },
    filteredPrograms4() {
      return this.programs4.filter((programs4) =>
        programs4.name.toLowerCase().includes(this.search2.toLowerCase())
      );
    },
    totalPages() {
      return Math.ceil(this.filteredPrograms.length / this.perPage);
    },
  },
  methods: {
    activateProgram(id) {
      const form = {
        is_active: 1,
        updated_by: this.$store.state.user_id,
      };
      axios
        .put("https://10.109.2.112/api/programs_activate/" + id, form)
        .then((response) => {
          console.log(response.data);
          this.is_active = "";
          this.getPrograms3();
          this.getPrograms4();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    deactivateProgram(id) {
      const form = {
        is_active: 0,
        updated_by: this.$store.state.user_id,
      };
      axios
        .put("https://10.109.2.112/api/programs_deactivate/" + id, form)
        .then((response) => {
          console.log(response.data);
          this.is_active = "";
          this.getPrograms3();
          this.getPrograms4();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    async getPrograms3() {
      await axios
        .get("https://10.109.2.112/api/programs3")
        .then((response) => {
          this.programs3 = response.data.data;
          console.log(response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getPrograms4() {
      await axios
        .get("https://10.109.2.112/api/programs4")
        .then((response) => {
          this.programs4 = response.data.data;
          console.log(response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getSites() {
      console.log(this.sites_selected);
      await axios
        .get("https://10.109.2.112/api/sites3")
        .then((response) => {
          this.sites = response.data.data;
          console.log(response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addProgram() {
      const formData = {
        name: this.name,
        description: this.description,
        program_group: this.program_group,
        site_id: this.sites_selected,
        is_active: 1,
        created_by: this.$store.state.user_id,
      };
      axios
        .post("https://10.109.2.112/api/programs", formData)
        .then((response) => {
          console.log(response.data);
          this.name = "";
          this.description = "";
          this.program_group = "";
          this.sites_selected = "";
          this.getPrograms3();
          this.getPrograms4();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
  },
};
</script>

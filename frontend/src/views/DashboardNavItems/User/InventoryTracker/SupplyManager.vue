<template>
  <header class="w-full">
    <h2 class="pb-8 pl-8 font-bold tracking-tight text-gray-900">
      REMX Supply Manager
    </h2>
    <div class="flex items-center w-full max-w-screen-xl sm:px-2 lg:px-2">
      <h2 class="pl-8 text-sm font-bold tracking-tight text-gray-900">
        <button
          v-if="isUser || isRemx"
          @click="showModal = true"
          class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          ADD Supply
        </button>
      </h2>
    </div>
  </header>
  <div class="py-0">
    <div class="px-1 py-0 mx-auto bg-white max-w-7xl sm:px-6 lg:px-8">
      <div
        class="fixed inset-0 z-50 flex items-center justify-center modal"
        v-if="showModal"
      >
        <div class="absolute inset-0 bg-black opacity-50 modal-overlay"></div>
        <div class="max-w-sm p-4 bg-white rounded shadow-lg modal-content">
          <header class="px-4 py-2 border-b-2 border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Add Supply</h2>
          </header>
          <button
            @click="showModal = false"
            class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
          <span v-if="successMessage" class="text-green-500">{{
            successMessage
          }}</span>
          <div class="modal-scrollable-content">
            <form
              @submit.prevent="addItems"
              class="grid grid-cols-1 gap-4 font-semibold sm:grid-cols-2 md:grid-cols-1"
            >
              <div class="col-span-1">
                <label class="block">
                  Site
                  <select
                    v-model="sites_selected"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  >
                    <option disabled value="" selected>
                      Please select one
                    </option>
                    <option
                      v-for="site in sites"
                      :key="site.id"
                      :value="site.id"
                    >
                      {{ site.name }}
                    </option>
                  </select>
                  <p
                    v-if="errors.sites_selected"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.sites_selected }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Item Name
                  <input
                    type="text"
                    v-model="item_name"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p v-if="errors.item_name" class="mt-1 text-xs text-red-500">
                    {{ errors.item_name }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Quantity
                  <input
                    type="number"
                    v-model="quantity"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p v-if="errors.quantity" class="mt-1 text-xs text-red-500">
                    {{ errors.quantity }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Price
                  <input
                    type="text"
                    v-model="cost"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p v-if="errors.cost" class="mt-1 text-xs text-red-500">
                    {{ errors.cost }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Total Price
                  <input
                    type="text"
                    readonly
                    v-model="total_cost"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Budget Code
                  <input
                    type="text"
                    v-model="budget_code"
                    @input="validateBudgetCode"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p
                    v-if="errors.budget_code"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.budget_code }}
                  </p>
                  <p
                    v-else-if="budgetCodeValid"
                    class="mt-1 text-xs text-green-500"
                  >
                    Budget Code is valid.
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block mb-2"> Category </label>
                <div class="flex items-center">
                  <div
                    class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]"
                  >
                    <input
                      class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300"
                      type="radio"
                      v-model="category"
                      value="Normal"
                    />
                    <label
                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                      >Normal Item</label
                    >
                  </div>
                  <div
                    class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]"
                  >
                    <input
                      class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300"
                      type="radio"
                      v-model="category"
                      value="Premium"
                    />
                    <label
                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                      >Premium Item</label
                    >
                  </div>
                </div>
              </div>
              <div class="col-span-1">
                <label class="block mb-2"> Type </label>
                <div class="flex items-center">
                  <div
                    class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]"
                  >
                    <input
                      class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300"
                      type="radio"
                      v-model="type"
                      value="Non-Food"
                    />
                    <label
                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                      >Non-Food</label
                    >
                  </div>
                  <div
                    class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]"
                  >
                    <input
                      class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300"
                      type="radio"
                      v-model="type"
                      value="Food"
                    />
                    <label
                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                      >Food</label
                    >
                  </div>
                </div>
              </div>
              <div class="col-span-1" v-if="type === 'Food'">
                <label class="block">
                  Expiration Date
                  <input
                    type="date"
                    v-model="date_expiry"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                </label>
              </div>
              <div class="flex justify-between mt-4">
                <button
                  @click="showModal = false"
                  type="button"
                  class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-0">
    <div class="pl-8 pr-8">
      <div class="scroll">
        <div class="w-2/3 mx-auto datatable-container">
          <DataTable
            :data="items"
            :columns="columns"
            class="table divide-y divide-gray-200 table-auto table-striped"
            :options="{
              responsive: false,
              autoWidth: false,
              pageLength: 10,
              lengthChange: true,
              ordering: true,
              scrollX: true,
              dom: 'frtip',
              language: {
                search: 'Search',
                zeroRecords: 'No data available',
                info: 'Showing from _START_ to _END_ of _TOTAL_ records',
                infoFiltered: '(Filtered from MAX records)',
                paginate: {
                  first: 'First',
                  previous: 'Prev',
                  next: 'Next',
                  last: 'Last',
                },
              },
            }"
          >
            <thead class="truncate">
              <tr></tr>
            </thead>
          </DataTable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import DataTable from "datatables.net-vue3";
import DataTableLib from "datatables.net-bs5";
// eslint-disable-next-line no-unused-vars
import Buttons from "datatables.net-buttons-bs5";
import ButtonsHtml5 from "datatables.net-buttons/js/buttons.html5";
// eslint-disable-next-line no-unused-vars
import print from "datatables.net-buttons/js/buttons.print";
//import pdfmake from "pdfmake";
// eslint-disable-next-line no-unused-vars
import pdfFonts from "pdfmake/build/vfs_fonts";
import "datatables.net-responsive-bs5";
// eslint-disable-next-line no-unused-vars
import "bootstrap/dist/css/bootstrap.css";

DataTable.use(DataTableLib);
//DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);

export default {
  components: { DataTable },
  data() {
    return {
      sites: [],
      items: [],
      sites_selected: "",
      item_name: "",
      quantity: "",
      budget_code: "",
      budgetCodeValid: false,
      cost: "",
      total_cost: "",
      type: "Non-Food",
      category: "Normal",
      date_expiry: "",
      showModal: false,
      successMessage: "",
      errors: {},
      columns: [
        {
          title: "No",
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
        },
        { data: "site_name", title: "Site" },
        { data: "item_name", title: "Item" },
        { data: "quantity", title: "Quantity" },
        { data: "original_quantity", title: "Original Quantity" },
        { data: "cost", title: "Price" },
        { data: "total_cost", title: "Total Price" },
        { data: "budget_code", title: "Budget Code" },
        { data: "type", title: "Type" },
        { data: "category", title: "Category" },
        { data: "date_expiry", title: "Expiration Date" },
        {
          data: "date_added",
          title: "Added Date",
          render: (data) => (data ? data.slice(0, -3) : ""),
        },
        { data: "created_by", title: "Added By" },
      ],
    };
  },
  watch: {
    quantity: function () {
      this.updateTotalPrice();
    },
    cost: function () {
      this.updateTotalPrice();
    },
  },
  computed: {
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
  },
  mounted() {
    window.vm = this;
    this.getSites();
    this.getItems();
  },
  methods: {
    validateBudgetCode() {
      this.errors.budget_code = "";
      this.budgetCodeValid = false;
      const budgetCodeRegex = /^REC[a-zA-Z0-9]{3}[0-9]{6}$/;
      if (!budgetCodeRegex.test(this.budget_code)) {
        this.errors.budget_code =
          "Budget Code must start with 'REC', followed by 3 alphanumeric characters, and ending with 6 digits.";
      } else {
        this.budgetCodeValid = true;
      }
    },
    updateTotalPrice() {
      this.total_cost = this.quantity * this.cost;
    },
    async getItems() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "http://127.0.0.1:8000/api/itemsboth3",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.items = response.data.items;
          console.log(response.data.items);
        } else {
          console.log("Error fetching items");
        }
      } catch (error) {
        console.log(error);
      }
    },
    async getSites() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get("http://127.0.0.1:8000/api/sites", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.sites = response.data.data;
          console.log(response.data.data);
        } else {
          console.log("Error fetching sites");
        }
      } catch (error) {
        console.log(error);
      }
    },
    addItems() {
      this.errors = {};
      if (!this.sites_selected) {
        this.errors.sites_selected = "Site is required.";
      }
      if (!this.item_name) {
        this.errors.item_name = "Item Name is required.";
      }
      if (!this.quantity) {
        this.errors.quantity = "Quantity is required.";
      }
      if (!this.cost) {
        this.errors.cost = "Price is required.";
      }
      if (!this.budget_code) {
        this.errors.budget_code = "Budget Code is required.";
      } else {
        console.log("Validating budget code:", this.budget_code);
        const budgetCodeRegex = /^REC[a-zA-Z0-9]{3}[0-9]{6}$/;
        if (!budgetCodeRegex.test(this.budget_code)) {
          this.errors.budget_code =
            "Budget Code must start with 'REC', followed by 3 alphanumeric characters, and ending with 6 digits.";
        } else {
          console.log("Budget code is valid:", this.budget_code);
        }
      }

      if (Object.keys(this.errors).length > 0) {
        console.log("Form has errors");
        return;
      }
      const formData = {
        item_name: this.item_name,
        quantity: this.quantity,
        original_quantity: this.quantity,
        type: this.type,
        cost: this.cost,
        total_cost: this.total_cost,
        category: this.category,
        budget_code: this.budget_code,
        date_expiry: this.date_expiry,
        site_id: this.sites_selected,
        is_active: 1,
        created_by: this.$store.state.user_id,
      };
      axios
        .post("http://127.0.0.1:8000/api/items", formData, {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        })
        .then((response) => {
          console.log(response.data);
          this.item_name = "";
          this.quantity = "";
          this.sites_selected = "";
          this.type = "";
          this.cost = "";
          this.total_cost = "";
          this.category = "";
          this.budget_code = "";
          this.date_expiry = "";
          this.getItems();
          this.successMessage = "Item Added successfully!";
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },
};
</script>
<style>
.table-responsive {
  overflow: auto;
}

.datatable-container {
  width: 100%;
}

.table {
  white-space: nowrap;
}

.table thead th {
  padding: 8px;
}

.table tbody td {
  padding: 8px;
}
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 100%;
  width: 100%;
  box-sizing: border-box;
}

.modal-content form {
  display: grid;
  grid-template-columns: 1fr;
}
.modal-scrollable-content {
  max-height: 70vh;
  overflow-y: auto;
}
/* Updated Radio Button Styles */
input[type="radio"] {
  /* Hide the default radio button */
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 50%;
  outline: none;
  margin-right: 8px;
  cursor: pointer;
  position: relative;
}

input[type="radio"]:checked {
  /* Add custom styling for the checked state */
  border-color: #3b71ca; /* Blue color for checked state */
}

input[type="radio"]:checked::before {
  /* Add the blue dot inside the checked radio button */
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #3b71ca; /* Blue color for the dot */
}

/* Optional: Increase the size of the radio button and the blue dot */
input[type="radio"] {
  width: 20px;
  height: 20px;
}

input[type="radio"]:checked::before {
  width: 10px;
  height: 10px;
}
</style>

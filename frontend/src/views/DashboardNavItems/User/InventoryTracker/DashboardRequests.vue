<template>
  <div class="py-0">
    <div class="pl-2 pr-2">
      <div class="flex flex-wrap mb-2">
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-green-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Total Request</h5>
                <h3 class="text-3xl text-white">
                  {{ filteredTotalRequest }}<span class="text-green-400"></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-blue-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Total Approved</h5>
                <h3 class="text-3xl text-white">{{ filteredTotalApproved }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-orange-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Total Denied</h5>
                <h3 class="text-3xl text-white">{{ filteredTotalDenied }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-purple-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Total Pending</h5>
                <h3 class="text-3xl text-white">{{ filteredTotalPending }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-red-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Partial</h5>
                <h3 class="text-3xl text-white">
                  {{ filteredTotalPartialReceived }}
                </h3>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-yellow-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Complete</h5>
                <h3 class="text-3xl text-white">
                  {{ filteredTotalCompleteReceived }}
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-pink-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Transferred</h5>
                <h3 class="text-3xl text-white">
                  {{ filteredTotalTransferred }}
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full px-1 py-3 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-xl:w-1/8">
          <div class="p-2 bg-indigo-600 border rounded shadow card-stats">
            <div class="flex flex-row items-center">
              <div class="flex-1 text-left">
                <h5 class="text-white">Cancelled</h5>
                <h3 class="text-3xl text-white">
                  {{ filteredTotalCancelled }}
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="scroll">
        <div class="w-2/3 mx-auto datatable-container">
          <div class="flex items-center col-span-6 space-x-2 md:col-span-4">
            <div class="flex items-center space-x-2">
              <label class="block font-semibold">
                Site
                <select
                  v-model="sites_selected"
                  class="block w-full mt-1 bg-white border-2 border-black rounded-md focus:border-orange-600 focus:ring focus:ring-orange-600 focus:ring-opacity-100"
                  @change="getPrograms"
                >
                  <option disabled value="" selected>Please select one</option>
                  <option v-for="site in sites" :key="site.id" :value="site.id">
                    {{ site.name }}
                  </option>
                </select>
              </label>
              <button
                @click="resetFilter"
                class="h-8 px-3 mt-4 font-semibold text-white transition-colors duration-300 bg-gray-500 rounded hover:bg-gray-600"
              >
                Reset
              </button>
            </div>
            <button
              @click="exportToExcel"
              class="h-8 px-3 mt-4 font-semibold text-white transition-colors duration-300 bg-green-600 rounded hover:bg-green-600"
            >
              Export
            </button>
          </div>
          <DataTable
            ref="dataTable"
            :data="filteredInventory"
            :columns="columns"
            class="table divide-y divide-gray-200 table-auto table-striped"
            :options="{
              responsive: false,
              autoWidth: false,
              pageLength: 10,
              lengthChange: true,
              ordering: true,
              scrollX: true,
              dom: 'frtlip',
              buttons: ['excel', 'csv'],
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
import { utils, writeFile } from "xlsx";

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
      filteredTotalRequest: 0,
      filteredTotalApproved: 0,
      filteredTotalDenied: 0,
      filteredTotalPending: 0,
      totalCompleteReceived: 0,
      filteredTotalPartialReceived: 0,
      filteredTotalCompleteReceived: 0,
      filteredTotalTransferred: 0,
      filteredTotalCancelled: 0,
      sites_selected: "",
      award: [],
      items: [],
      inventory: [],
      items2: [],
      columns: [
        {
          title: "No",
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
        },
        { data: "site.name", title: "Site" },
        {
          data: null,
          title: "Item Name",
          render: (data, type, row) => {
            if (row.site_inventory && row.site_inventory.item_name) {
              return row.site_inventory.item_name;
            } else if (row.item && row.item.item_name) {
              return row.item.item_name;
            } else {
              return "N/A";
            }
          },
        },
        {
          data: null,
          title: "Budget Code",
          render: (data, type, row) => {
            if (row.site_inventory && row.site_inventory.budget_code) {
              return row.site_inventory.budget_code;
            } else if (row.item && row.item.budget_code) {
              return row.item.budget_code;
            } else {
              return "N/A";
            }
          },
        },
        { data: "original_request", title: "Quantity Requested" },
        { data: "received_quantity", title: "Quantity Received" },
        { data: "quantity_approved", title: "Remaining Quantity" },
        { data: "status", title: "Approval Status" },
        {
          data: "requested_by.name",
          title: "Requested By",
          render: (data, type, row) => {
            return row.requested_by ? row.requested_by.name : "N/A";
          },
        },
        { data: "date_requested", title: "Requested Date" },
        { data: "date_received", title: "Received Date" },
        {
          data: "approved_by.name",
          title: "approved By",
          render: (data, type, row) => {
            return row.approved_by ? row.approved_by.name : "N/A";
          },
        },
        { data: "date_approved", title: "Approved Date" },
        {
          data: "denied_by.name",
          title: "Denied By",
          render: (data, type, row) => {
            return row.denied_by ? row.denied_by.name : "N/A";
          },
        },
        { data: "date_denied", title: "Denied Date" },
        { data: "denial_reason", title: "Denial Reason" },
      ],
    };
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
    filteredInventory() {
      let filteredData = [...this.inventory];

      if (this.sites_selected) {
        filteredData = filteredData.filter((item) => {
          return item.site.id === this.sites_selected;
        });
      }
      return filteredData;
    },
  },
  watch: {
    sites_selected: "getInventory",
  },

  mounted() {
    window.vm = this;
    this.getSites();
    this.getInventory();
  },
  methods: {
    resetFilter() {
      this.sites_selected = "";
    },
    generateExcelData(data) {
      console.log("filteredTotalRequest:", this.filteredTotalRequest);
      console.log("filteredTotalApproved:", this.filteredTotalApproved);
      const customHeaders = [
        "ID",
        "Site",
        "Item Name",
        "Budget Code",
        "Quantity Remaining",
        "Approval Status",
        "Original Quantity",
        "Received Quantity",
        "Requested By",
        "Approved By",
        "Denied By",
        "Denial Reason",
        "Date Requested",
        "Date Approved",
        "Date Denied",
        "Date Received",
        "Received Status",
        "Received Type",
      ];

      const customValues = [
        ["Total Request", this.filteredTotalRequest],
        ["Total Approved", this.filteredTotalApproved],
        ["Total Denied", this.filteredTotalDenied],
        ["Total Pending", this.filteredTotalPending],
        ["Partial", this.filteredTotalPartialReceived],
        ["Complete", this.filteredTotalCompleteReceived],
        ["Transferred", this.filteredTotalTransferred],
        ["Cancelled", this.filteredTotalCancelled],
      ];

      const excelData = [
        customHeaders, // Header row
        ...data.map((item) => {
          const siteName = item.site && item.site.name ? item.site.name : "N/A";
          const itemName =
            (item.site_inventory && item.site_inventory.item_name) ||
            (item.item && item.item.item_name) ||
            "N/A";
          const budgetCode =
            (item.site_inventory && item.site_inventory.budget_code) ||
            (item.item && item.item.budget_code) ||
            "N/A";

          return [
            item.id,
            siteName,
            itemName,
            budgetCode,
            item.quantity_approved,
            item.status,
            item.original_request,
            item.received_quantity,
            item.requested_by ? item.requested_by.name : "N/A",
            item.approved_by ? item.approved_by.name : "N/A",
            item.denied_by ? item.denied_by.name : "N/A",
            item.denial_reason,
            item.date_requested,
            item.date_approved,
            item.date_denied,
            item.date_received,
            item.approved_status,
            item.received_status,
          ];
        }),
        ...customValues,
      ];
      console.log("excelData:", excelData);
      return excelData;
    },

    exportToExcel() {
      const filteredData = this.filteredInventory;

      if (this.sites_selected) {
        const excelData = this.generateExcelData(filteredData);
        const worksheet = utils.aoa_to_sheet(excelData);
        const workbook = utils.book_new();
        utils.book_append_sheet(workbook, worksheet, "Inventory Data");
        writeFile(workbook, "inventory_export.xlsx");
      } else {
        const excelData = this.generateExcelData(this.inventory);
        const worksheet = utils.aoa_to_sheet(excelData);
        const workbook = utils.book_new();
        utils.book_append_sheet(workbook, worksheet, "Inventory Data");
        writeFile(workbook, "inventory_export.xlsx");
      }
    },

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
          console.log(response.data.data);
        } else {
          console.log("Error fetching sites");
        }
      } catch (error) {
        console.log(error);
      }
    },
    async getInventory() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/inventoryalltransaction",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.inventory = response.data.inventory;

          this.totalRequest = this.inventory.length;
          this.totalApproved = this.inventory.filter(
            (item) => item.status === "Approved"
          ).length;
          this.totalDenied = this.inventory.filter(
            (item) => item.status === "Denied"
          ).length;
          this.totalPending = this.inventory.filter(
            (item) => item.status === "Pending"
          ).length;
          this.totalPartialReceived = this.inventory.filter(
            (item) => item.received_status === "partial"
          ).length;
          this.totalCompleteReceived = this.inventory.filter(
            (item) => item.received_status === "complete"
          ).length;

          const filteredData = this.filteredInventory;
          this.filteredTotalRequest = filteredData.length;
          this.filteredTotalApproved = filteredData.filter(
            (item) => item.status === "Approved"
          ).length;
          this.filteredTotalDenied = filteredData.filter(
            (item) => item.status === "Denied"
          ).length;
          this.filteredTotalPending = filteredData.filter(
            (item) => item.status === "Pending"
          ).length;
          this.filteredTotalPartialReceived = filteredData.filter(
            (item) => item.received_status === "partial"
          ).length;
          this.filteredTotalCompleteReceived = filteredData.filter(
            (item) => item.received_status === "complete"
          ).length;
          this.filteredTotalTransferred = filteredData.filter(
            (item) =>
              item.status === "Transferred All" ||
              item.status === "Transferred Partial"
          ).length;

          this.filteredTotalCancelled = filteredData.filter(
            (item) => item.status === "Cancelled"
          ).length;
        } else {
          console.log("Error fetching inventory");
        }
      } catch (error) {
        console.log(error);
      }
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
.card-stats {
  width: 100%;
  max-width: 400px;
  margin-bottom: 20px;
}

.card-stats .card-body {
  padding: 10px;
}
.link-button {
  text-decoration: none;
}
</style>

<template>
  <div class="py-0">
    <div class="bg-gray-100 p-4">
      <div class="mb-4 md:flex md:space-x-2 md:items-center">
        <div class="w-full md:w-1/4">
          <select
            v-model="filterSite"
            placeholder="Filter by Site"
            class="p-2 border rounded-lg w-full"
          >
            <option disabled value="" selected>Please select one</option>
            <option v-for="site in sites" :key="site.Site" :value="site.Site">
              {{ site.Site }}
            </option>
          </select>
        </div>
        <div class="w-full md:w-1/4">
          <input
            v-model="filterStartDate"
            type="date"
            placeholder="Start"
            class="p-2 border rounded-lg w-full"
            @input="updateFilterStartDate"
          />
        </div>
        <div class="w-full md:w-1/4">
          <input
            v-model="filterEndDate"
            type="date"
            placeholder="End by Site"
            class="p-2 border rounded-lg w-full"
            @input="updateFilterEndDate"
          />
        </div>
        <div class="w-full md:w-1/4">
          <button
            @click="fetchData"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg w-full"
          >
            Filter
          </button>
        </div>
        <div class="w-full md:w-1/4">
          <button
            @click="exportToExcel"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg w-full"
          >
            Export
          </button>
        </div>
      </div>
      <div
        v-if="filterLoading || exportLoading"
        class="text-center text-blue-500 font-bold"
      >
        {{ filterLoading ? "Rendering..." : "Exporting..." }}
      </div>
      <DataTable
        :data="sr"
        :columns="columns"
        class="table divide-y divide-gray-200 table-auto table-striped"
        :options="{
          responsive: false,
          autoWidth: false,
          pageLength: 10,
          lengthChange: true,
          ordering: true,
          scrollX: true,
          dom: 'rtlip',
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
          <tr>
            <!-- Add your table headers here -->
          </tr>
        </thead>
        <tbody class="truncate">
          <tr v-for="item in sr" :key="item.id">
            <!-- Add your table row data here -->
          </tr>
        </tbody>
      </DataTable>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import "datatables.net-bs5/css/dataTables.bootstrap5.css";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.css";
import "datatables.net-responsive-bs5/css/responsive.bootstrap5.css";

import DataTable from "datatables.net-vue3";
import DataTableLib from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.css";
import "datatables.net-buttons-bs5";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.css";
import "datatables.net-responsive-bs5";
import "datatables.net-responsive-bs5/css/responsive.bootstrap5.css";
import "bootstrap/dist/js/bootstrap.bundle"; // Make sure to include Bootstrap JavaScript

// Import DataTables extensions
import Buttons from "datatables.net-buttons-bs5";
import ButtonsHtml5 from "datatables.net-buttons/js/buttons.html5";
import print from "datatables.net-buttons/js/buttons.print";
import jszip from "jszip";
// eslint-disable-next-line no-unused-vars
import pdfMake from "pdfmake/build/pdfmake";
// eslint-disable-next-line no-unused-vars
import pdfFonts from "pdfmake/build/vfs_fonts";
import "bootstrap/dist/css/bootstrap.css";

// eslint-disable-next-line no-unused-vars
import { format } from "date-fns";

DataTable.use(DataTableLib);
DataTable.use(jszip);
DataTable.use(Buttons);
DataTable.use(ButtonsHtml5);
DataTable.use(print);

export default {
  components: { DataTable },
  data() {
    return {
      filterSite: "",
      filterStartDate: "",
      filterEndDate: "",
      sites: [],
      sr: [],
      columns: [
        { data: "ApplicationInfoId", title: "SR ID" },
        { data: "QueueDate", title: "Date" },
        { data: "LastName", title: "Last Name" },
        { data: "FirstName", title: "First Name" },
        { data: "MiddleName", title: "Middle Name" },
        { data: "Site", title: "Site" },
        { data: "MobileNo", title: "Mobile#" },
        { data: "GenSource", title: "Gen Source" },
        { data: "SpecSource", title: "Spec Source" },
        { data: "Step", title: "Step" },
        { data: "AppStep", title: "AppStep" },
      ],
      filterLoading: false,
      exportLoading: false,
    };
  },
  mounted() {
    this.getSites();
    this.getDates();
  },
  computed: {
    formattedFilterDate() {
      return this.filterDate
        ? new Date(this.filterDate).toLocaleDateString("en-CA")
        : "";
    },
  },

  methods: {
    async getSites() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get("https://10.109.2.112/api/sr_site", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.sites = response.data.sites;
          console.log(response.data.data);
        } else {
          console.log("Error fetching sites");
        }
      } catch (error) {
        console.log(error);
      }
    },
    async getDates() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get("https://10.109.2.112/api/sr_date", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.filterStartDate = response.data.minDate;
          this.filterEndDate = response.data.maxDate;
          console.log(response.data.minDate);
          console.log(response.data.maxDate);
        } else {
          console.log("Error fetching Date");
        }
      } catch (error) {
        console.log(error);
      }
    },
    updateFilterStartDate(event) {
      this.filterStartDate = event.target.value;
    },

    updateFilterEndDate(event) {
      this.filterEndDate = event.target.value;
    },

    formatDateForInput(date) {
      const formattedDate = new Date(date).toISOString().split("T")[0];
      return formattedDate;
    },

    async fetchData() {
      this.filterLoading = true;
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/sr_filter",
          {
            params: {
              filter_site: this.filterSite,
              filter_date_start: this.filterStartDate,
              filter_date_end: this.filterEndDate,
            },
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        this.sr = response.data.sr;
      } catch (error) {
        console.error("Error fetching filtered data", error);
      } finally {
        this.filterLoading = false;
      }
    },

    async exportToExcel() {
      this.exportLoading = true;
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/sr_export",
          {
            params: {
              filter_site: this.filterSite,
              filter_date_start: this.filterStartDate,
              filter_date_end: this.filterEndDate,
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
        link.download = "filtered_sr_data.xlsx";
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

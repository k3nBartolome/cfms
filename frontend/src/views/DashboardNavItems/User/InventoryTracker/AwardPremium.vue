<template>
  <header class="w-full">
    <div class="flex items-center w-full max-w-screen-xl sm:px-2 lg:px-2">
      <h2 class="pl-8 text-sm font-bold tracking-tight text-gray-900">
        <button
          v-if="isUser || isRemx || isSourcing"
          @click="showModal = true"
          class="px-4 py-2 mr-2 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Released Premium Item
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
          <div v-if="loading" class="loader">
            <div aria-label="Loading..." role="status" class="loader">
              <svg class="icon" viewBox="0 0 256 256">
                <line
                  x1="128"
                  y1="32"
                  x2="128"
                  y2="64"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="195.9"
                  y1="60.1"
                  x2="173.3"
                  y2="82.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="224"
                  y1="128"
                  x2="192"
                  y2="128"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="195.9"
                  y1="195.9"
                  x2="173.3"
                  y2="173.3"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="128"
                  y1="224"
                  x2="128"
                  y2="192"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="60.1"
                  y1="195.9"
                  x2="82.7"
                  y2="173.3"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="32"
                  y1="128"
                  x2="64"
                  y2="128"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
                <line
                  x1="60.1"
                  y1="60.1"
                  x2="82.7"
                  y2="82.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="24"
                ></line>
              </svg>
              <span class="loading-text">Loading...</span>
            </div>
          </div>
          <header class="px-4 py-2 border-b-2 border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
              Released Premium Item
            </h2>
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
          <div class="modal-scrollable-content">
            <form
              @submit.prevent="AwardPremiumItem"
              class="grid grid-cols-1 gap-4 font-semibold sm:grid-cols-2 md:grid-cols-1"
            >
              <div class="col-span-1">
                <label class="block">
                  Site
                  <select
                    @change="getItems"
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
                  <select
                    @change="onItemSelected"
                    v-model="items_selected"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  >
                    <option disabled value="" selected>
                      Please select one
                    </option>
                    <option
                      v-for="site_items in site_items"
                      :key="site_items"
                      :value="site_items.id"
                    >
                      {{ site_items.item_name }}
                    </option>
                  </select>
                  <p
                    v-if="errors.items_selected"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.items_selected }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Budget Code
                  <input
                    type="text"
                    v-model="budget_code"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Quantity Available
                  <input
                    type="number"
                    readonly
                    v-model="quantity"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Awardee Name
                  <input
                    type="text"
                    v-model="awardee_name"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p
                    v-if="errors.awardee_name"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.awardee_name }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Awardee HRID
                  <input
                    type="text"
                    v-model="awardee_hrid"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p
                    v-if="errors.awardee_hrid"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.awardee_hrid }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  Awarded Quantity
                  <input
                    type="number"
                    v-model="awarded_quantity"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p
                    v-if="errors.awarded_quantity"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.awarded_quantity }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block"
                  >Remarks
                  <textarea
                    v-model="remarks"
                    class="block w-full whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-2 py-[0.17rem] text-center text-sm font-normal leading-[1.5] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                  />
                  <p v-if="errors.remarks" class="mt-1 text-xs text-red-500">
                    {{ errors.remarks }}
                  </p>
                </label>
              </div>
              <div class="col-span-1">
                <label class="block">
                  <input type="file" @change="handleFileChange" />
                  <img :src="previewImage" v-if="previewImage" alt="Preview" />
                  <p v-if="errors.file_name" class="mt-1 text-xs text-red-500">
                    {{ errors.file_name }}
                  </p>
                </label>
              </div>
              <div class="flex justify-end mt-4">
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
  <div class="image-modal">
    <button class="close-button" @click="closeImageModal">Close</button>
    <img class="enlarged-image" @click.stop="" alt="Enlarged Image" />
  </div>
  <div class="py-0">
    <div class="pl-8 pr-8">
      <div class="scroll">
        <div class="w-2/3 mx-auto datatable-container">
          <DataTable
            :data="award"
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
      selectedFile: null,
      previewImage: null,
      sites: [],
      award: [],
      site_items: [],
      sites_selected: "",
      item_name: "",
      quantity: "",
      errors: {},
      items_selected: "",
      remarks: "",
      awardee_name: "",
      awardee_hrid: "",
      awarded_quantity: "",
      budget_code: "",
      showModal: false,
      loading: false,
      columns: [
        {
          title: "No",
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
        },
        { data: "site_name", title: "Site" },
        { data: "item_name", title: "Item Name" },
        { data: "budget_code", title: "Budget Code" },
        { data: "awarded_quantity", title: "Awarded Quantity" },
        { data: "awardee_hrid", title: "Awardee ID" },
        { data: "awardee_name", title: "Awardee Name" },
        { data: "released_by", title: "Released By" },
        { data: "date_released", title: "Date Released" },
        { data: "remarks", title: "Remarks" },
        {
          data: "image_path",
          title: "Image",
          render: (data, type) => {
            if (type === "display" && data) {
              return `<button onclick="window.vm.openImageModal('${data}')">
                <img src="${data}" alt="Image" width="50" height="50" loading="lazy"/>
              </button>`;
            }
            return "";
          },
        },
        {
          data: "id",
          title: "Actions",
          orderable: false,
          searchable: false,
          render: function (data) {
            return `<button class="btn btn-primary w-36" data-id="${data}" onclick="window.vm.navigateToEdit(${data})">Edit</button>
  `;
          },
        },
      ],
    };
  },
  computed: {
    imageSource() {
      return this.capturedImage ? this.capturedImage : this.selectedImage;
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
  },
  watch: {
    items_selected(newItemId) {
      const selectedItem = this.site_items.find(
        (site_items) => site_items.id === newItemId
      );
      if (selectedItem) {
        this.budget_code = selectedItem.budget_code;
        this.quantity = selectedItem.quantity;
      }
    },
    sites_selected: {
      immediate: true,
      handler() {
        this.getItems();
        this.budget_code = null;
        this.quantity = null;
        this.item_name = null;
      },
    },
  },
  mounted() {
    window.vm = this;
    this.getSites();
    this.getItems();
    this.getAward();
  },

  methods: {
    navigateToEdit(id) {
      this.$router.push(`/award_manager/premium/${id}`);
    },
    openImageModal(imageUrl) {
      const modal = document.querySelector(".image-modal");
      const enlargedImage = document.querySelector(".enlarged-image");

      enlargedImage.src = imageUrl;
      modal.style.display = "flex";
    },
    closeImageModal() {
      const modal = document.querySelector(".image-modal");

      modal.style.display = "none";
    },
    async handleFileChange(event) {
      const selectedFile = event.target.files[0];

      if (!selectedFile) {
        return;
      }

      const maxSizeInBytes = 2 * 1024 * 1024; // 2 MB threshold

      if (selectedFile.size > maxSizeInBytes) {
        try {
          const image = new Image();
          const reader = new FileReader();

          reader.onload = (event) => {
            image.src = event.target.result;

            image.onload = async () => {
              const maxWidth = 800;
              const quality = 0.8;

              // Calculate new dimensions to fit within maxWidth
              let width = image.width;
              let height = image.height;
              if (width > maxWidth) {
                height *= maxWidth / width;
                width = maxWidth;
              }

              const canvas = document.createElement("canvas");
              canvas.width = width;
              canvas.height = height;

              const ctx = canvas.getContext("2d");
              ctx.drawImage(image, 0, 0, width, height);

              canvas.toBlob(
                async (blob) => {
                  this.selectedFile = blob;
                  this.previewImage = URL.createObjectURL(blob);

                  console.log("Preview Image URL:", this.previewImage);
                },
                "image/jpeg",
                quality
              );
            };
          };

          reader.readAsDataURL(selectedFile);
        } catch (error) {
          console.error("Error resizing image:", error);
        }
      } else {
        // No need to resize for smaller images
        this.selectedFile = selectedFile;
        this.previewImage = URL.createObjectURL(selectedFile);

        console.log("Preview Image URL:", this.previewImage);
      }
    },

    async compressBlob(blob, maxSize) {
      const image = new Image();
      const reader = new FileReader();
      const maxQuality = 0.8;

      const compressedBlob = await new Promise((resolve) => {
        reader.onload = (event) => {
          image.src = event.target.result;

          image.onload = () => {
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");

            // Calculate the new dimensions while maintaining the aspect ratio
            let newWidth = image.width;
            let newHeight = image.height;

            if (image.size > maxSize) {
              const scaleFactor = Math.sqrt(image.size / maxSize);
              newWidth = Math.floor(image.width / scaleFactor);
              newHeight = Math.floor(image.height / scaleFactor);
            }

            canvas.width = newWidth;
            canvas.height = newHeight;

            // Draw the resized image on the canvas
            ctx.drawImage(image, 0, 0, newWidth, newHeight);

            // Convert canvas content to blob with specified format and quality
            canvas.toBlob(resolve, "image/jpeg", maxQuality);
          };
        };

        reader.readAsDataURL(blob);
      });

      return compressedBlob;
    },

    onItemSelected() {
      const selectedItem = this.site_items.find(
        (site_items) => site_items.id === this.items_selected
      );

      if (selectedItem) {
        this.budget_code = selectedItem.budget_code;
        this.quantity = selectedItem.quantity;
      }
    },
    async getItems() {
      if (!this.sites_selected) {
        return;
      }

      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          `https://10.109.2.112/api/items_selected2/${this.sites_selected}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.site_items = response.data.items;
          console.log(response.data.items);
        } else {
          console.log("Error fetching items");
        }
      } catch (error) {
        console.error(error);
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
    async getAward() {
      try {
        const token = this.$store.state.token;
        const response = await axios.get(
          "https://10.109.2.112/api/awarded/premium",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.status === 200) {
          this.award = response.data.awarded;
          console.log(response.data.awarded);
        } else {
          console.log("Error fetching awarded");
        }
      } catch (error) {
        console.log(error);
      }
    },
    async AwardPremiumItem() {
      this.errors = {};
      this.loading = true;
      if (!this.sites_selected) {
        this.errors.sites_selected = "Site is required.";
      }
      if (!this.items_selected) {
        this.errors.items_selected = "Item Name is required.";
      }
      if (!this.awardee_name) {
        this.errors.awardee_name = "Awardee Name is required.";
      }
      if (!this.awardee_hrid) {
        this.errors.awardee_hrid = "Awardee ID is required.";
      }
      if (!this.remarks) {
        this.errors.remarks = "Remarks is required.";
      }
      if (!this.awarded_quantity) {
        this.errors.awarded_quantity = "Quantity Awarded is required.";
      } else if (parseInt(this.awarded_quantity) > parseInt(this.quantity)) {
        this.errors.awarded_quantity =
          "Quantity Awarded cannot exceed available quantity.";
      }

      if (Object.keys(this.errors).length > 0) {
        return;
      }
      const formData = new FormData();
      formData.append("file_name", this.selectedFile);
      formData.append("inventory_item_id", this.items_selected);
      formData.append("site_id", this.sites_selected);
      formData.append("awarded_quantity", this.awarded_quantity);
      formData.append("awardee_name", this.awardee_name);
      formData.append("remarks", this.remarks);
      formData.append("awardee_hrid", this.awardee_hrid);
      formData.append("released_by", this.$store.state.user_id);
      formData.append("processed_by", this.$store.state.user_id);

      try {
        const response = await axios.post(
          "https://10.109.2.112/api/award",
          formData,
          {
            headers: {
              Authorization: `Bearer ${this.$store.state.token}`,
              "Content-Type": "multipart/form-data",
            },
          }
        );

        console.log("Awarded:", response.data.Award);
        this.showModal = false;
        this.clearForm();
        this.getItems();
        this.getAward();
      } catch (error) {
        console.error("Error awarding:", error.response.data);
      } finally {
        this.loading = false;
      }
    },
    clearForm() {
      this.items_selected = "";
      this.awarded_quantity = "";
      this.sites_selected = "";
      this.awardee_name = "";
      this.awardee_hrid = "";
      this.remarks = "";
      this.selectedFile = null;
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
<style scoped>
/* Your loader styles here */
.loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000; /* Ensure the loader is on top of other elements */
}

.loader-content {
  /* Style your loader content (SVG, text, etc.) */
  display: flex;
  align-items: center;
}

.icon {
  /* Style your SVG icon */
  height: 3rem; /* Adjust the size as needed */
  width: 3rem; /* Adjust the size as needed */
  animation: spin 1s linear infinite;
  stroke: rgba(107, 114, 128, 1);
}

.loading-text {
  /* Style your loading text */
  font-size: 1.5rem; /* Adjust the size as needed */
  line-height: 2rem; /* Adjust the size as needed */
  font-weight: 500;
  color: rgba(107, 114, 128, 1);
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>

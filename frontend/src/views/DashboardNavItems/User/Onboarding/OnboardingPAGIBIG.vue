<template>
  <div class="container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4 text-center">PAGIBIG</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="flex flex-col">
        <label class="block text-sm font-medium">Final Status</label>
        <select v-model="pagibig_final_status" class="p-2 mt-1 border rounded w-full"
        @change="updatePagibigData">
          <option disabled>Please select one</option>
          <option value="YES">YES</option>
          <option value="NO">NO</option>
          <option value="PENDING PROOF">PENDING PROOF</option>
        </select>
      </div>
      <div class="flex flex-col">
        <label class="block text-sm font-medium">Pag-IBIG Number</label>
        <input @change="updatePagibigData"
          v-model="pagibig_number"
          type="text"
          class="p-2 mt-1 border rounded w-full"
          @input="formatPagibigNumber"
          @blur="validatePagibigNumber"
          placeholder="0123-4567-8901"
        />
        <p v-if="pagibig_number_error" class="text-red-500 text-sm mt-1">
          {{ pagibig_number_error }}
        </p>
      </div>

      <div class="flex flex-col">
        <label class="block text-sm font-medium">Proof Submitted Type</label>
        <select @change="updatePagibigData"
          v-model="pagibig_proof_submitted_type"
          class="p-2 mt-1 border rounded w-full"
        >
          <option disabled>Please select one</option>
          <option value="ID">ID</option>
          <option value="MDF">MDF</option>
          <option value="PROCESSED MCIF">PROCESSED MCIF</option>
          <option value="SOA">SOA</option>
          <option value="MP2">MP2</option>
          <option value="TRANSACTION RECEIPT">TRANSACTION RECEIPT</option>
          <option value="MID VALIDATION SLIP">MID VALIDATION SLIP</option>
          <option value="ONLINE STATIC INFO">ONLINE STATIC INFO</option>
        </select>
      </div>
      <div class="flex flex-col">
        <label class="block text-sm font-medium">Submitted Date</label>
        <input @change="updatePagibigData"
          v-model="pagibig_submitted_date"
          type="date"
          class="p-2 mt-1 border rounded w-full"
        />
      </div>
      <div class="flex flex-col">
        <label class="block text-sm font-medium">Remarks</label>
        <input @change="updatePagibigData"
          v-model="pagibig_remarks"
          type="text"
          class="p-2 mt-1 border rounded w-full"
        />
      </div>
    </div>
    <div class="flex flex-col">
      <label class="block text-sm font-medium">PAGIBIG PROOF</label>
      <input type="file" @change="uploadImage" class="p-2 mt-1 border rounded w-full" />
    </div>
    <!-- <div class="flex flex-col sm:flex-row justify-between mt-4">
      <button
        @click="chooseUpload"
        class="btn p-2 border rounded w-full sm:w-1/2 lg:w-1/4 mb-2 sm:mb-0"
      >
        Upload Image
      </button>
      <button
        @click="chooseCapture"
        class="btn p-2 border rounded w-full sm:w-1/2 lg:w-1/4"
      >
        Capture Image
      </button>
    </div> -->
    <div v-if="pagibig_file_name" class="mt-4">
      <div class="flex flex-col items-center">
        <img 
          :src="pagibig_file_name"
          alt="Preview Image"
          class="object-cover w-full sm:w-3/4 lg:w-1/2 h-48 border rounded-lg"
          @load="updatePagibigData"
        />
      </div>
    </div>
    <div v-if="showCapture" class="mt-4">
      <!-- <div class="flex flex-col items-center">
        <video
          ref="video"
          class="w-full sm:w-3/4 lg:w-1/2 h-48 object-cover border rounded"
          autoplay
        ></video>
        <button
          @click="captureImage"
          class="btn p-2 border rounded mt-2 w-full sm:w-1/2 lg:w-1/4"
        >
          Capture
        </button>
      </div> -->

      <div v-if="capturedImage" class="mt-4 flex flex-col items-center">
        <img
          :src="capturedImage"
          alt="Captured Image"
          class="object-cover w-full sm:w-3/4 lg:w-1/2 h-48 border rounded-lg"
        />
        <!-- <button
          @click="recaptureImage"
          class="btn p-2 border rounded mt-2 w-full sm:w-1/2 lg:w-1/4"
        >
          Recapture
        </button> -->
      </div>
    </div>

    <div class="mt-4">
      <button
        @click="submitForm"
        class="btn p-2 border rounded w-full sm:w-1/2 lg:w-1/4 mx-auto"
      >
        Submit
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      showUpload: false,
      showCapture: false,
      capturedImage: null,
      pagibig_submitted_date: "",
      pagibig_final_status: "",
      pagibig_proof_submitted_type: "",
      pagibig_remarks: "",
      pagibig_number: "",
      pagibig_file_name: null,
      videoStream: null,
      pagibig_proof: null, // Used for the proof file or image data
      isSubmitting: false, // Tracks form submission status
      pagibig_number_error: "",
    };
  },
  
mounted() {
    this.fetchPagibigData();
  },
  methods: {
    async fetchPagibigData() {
      try {
        const response = await axios.get(
          `https://10.109.2.112/api/get/pagibig/requirement/${this.$route.params.id}`
        );
        const data = response.data.data;

        // Populate the form fields with API response data
        this.pagibig_proof_submitted_type = data.pagibig_proof_submitted_type;
        this.pagibig_final_status = data.pagibig_final_status;
        this.pagibig_submitted_date = data.pagibig_submitted_date;
        this.pagibig_number = data.pagibig_number;
        this.pagibig_remarks = data.pagibig_remarks;
        this.pagibig_file_name = data.pagibig_file_name;
      } catch (error) {
        console.error("Error fetching NBI data:", error);
      }
    },
    updatePemeData() {
      console.log("Updating NBI Data...");
      console.log({
       pagibig_proof_submitted_type:this.pagibig_proof_submitted_type,
       pagibig_final_status:this.pagibig_final_status,
       pagibig_submitted_date:this.pagibig_submitted_date,
       pagibig_remarks:this.pagibig_remarks,
       pagibig_number:this.pagibig_number,
      });
    },
    formatPagibigNumber() {
      // Remove any non-numeric characters
      let rawValue = this.pagibig_number.replace(/[^0-9]/g, "");

      // Apply formatting: XXXX-XXXX-XXXX
      if (rawValue.length <= 4) {
        this.pagibig_number = rawValue; // First 4 digits
      } else if (rawValue.length <= 8) {
        this.pagibig_number = `${rawValue.slice(0, 4)}-${rawValue.slice(4)}`;
      } else {
        this.pagibig_number = `${rawValue.slice(0, 4)}-${rawValue.slice(
          4,
          8
        )}-${rawValue.slice(8, 12)}`;
      }
    },
    validatePagibigNumber() {
      // Validation: Ensure the input matches the format XXXX-XXXX-XXXX
      const isValid = /^\d{4}-\d{4}-\d{4}$/.test(this.pagibig_number);
      if (!isValid) {
        this.pagibig_number_error =
          "Pag-IBIG number must be in the format 0123-4567-8901 and exactly 12 numeric characters.";
      } else {
        this.pagibig_number_error = ""; // Clear the error if valid
      }
    },
    async submitForm() {
      this.isSubmitting = true;

      // Check if 'pagibig_final_status' is selected
      if (!this.pagibig_final_status) {
        this.pagibig_final_status = "NO STATUS"; // or any default string or null
      }

      // Prepare form data
      const formData = new FormData();
      formData.append("pagibig_final_status", this.pagibig_final_status);
      formData.append("pagibig_submitted_date", this.pagibig_submitted_date);
      formData.append("pagibig_number", this.pagibig_number);
      formData.append("pagibig_proof_submitted_type", this.pagibig_proof_submitted_type);
      formData.append("pagibig_remarks", this.pagibig_remarks);
      formData.append("pagibig_updated_by", this.$store.state.user_id);
      // Append the actual file (pagibig_proof) for upload
      if (this.pagibig_proof) {
        formData.append("pagibig_proof", this.pagibig_proof); // append file here
      }

      try {
        const apiUrl = `https://10.109.2.112/api/update/pagibig/requirement/${this.$route.params.id}`;

        // Submit the form data to the API
        const response = await axios.post(apiUrl, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // Handle success
        console.log("Form submitted successfully", response.data);
      } catch (error) {
        // Handle error
        console.error(
          "Error submitting form",
          error.response ? error.response.data : error.message
        );
        alert("An error occurred while submitting the form.");
      } finally {
        // Reset submitting state
        this.isSubmitting = false;

        // Show success alert and navigate with reload after form submission
        alert("Form submitted successfully!");

        // Redirect to OnboardingUpdateSelection and reload the page
        this.$router
          .push({
            name: "OnboardingUpdateSelection",
            params: { id: this.$route.params.id },
          })
          .then(() => {
            window.location.reload(); // Reloads the page after navigation
          });
      }
    },
    uploadImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.pagibig_proof = file; // Store the file in pagibig_proof

        const reader = new FileReader();
        reader.onload = () => {
          this.pagibig_file_name = reader.result; // Preview the image
        };
        reader.readAsDataURL(file); // Preview file
      }
    },

    resizeImage(file) {
      const img = new Image();
      const reader = new FileReader();
      reader.onload = (e) => {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);

      img.onload = () => {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        const maxWidth = 1024;
        const maxHeight = 1024;
        let width = img.width;
        let height = img.height;

        if (width > height) {
          if (width > maxWidth) {
            height = (height * maxWidth) / width;
            width = maxWidth;
          }
        } else {
          if (height > maxHeight) {
            width = (width * maxHeight) / height;
            height = maxHeight;
          }
        }

        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);

        const dataUrl = canvas.toDataURL("image/jpeg", 0.7); // Compress image to 70% quality
        const compressedFile = this.dataURLtoBlob(dataUrl);

        if (compressedFile.size > this.maxSize) {
          alert("Image is still too large, please upload a smaller image.");
          return;
        }

        this.pagibig_proof = compressedFile;
        this.pagibig_file_name = dataUrl;
      };
    },
    chooseUpload() {
      this.showUpload = true;
      this.showCapture = false;
      this.pagibig_proof = null;
      this.capturedImage = null;
    },
    chooseCapture() {
      this.showCapture = true;
      this.showUpload = false;
      this.pagibig_proof = null;
      this.capturedImage = null;
      this.startCamera();
    },
    async startCamera() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({
          video: true,
        });
        this.$refs.video.srcObject = stream;
        this.videoStream = stream;
      } catch (error) {
        console.error("Error accessing camera:", error);
      }
    },
    captureImage() {
      const canvas = document.createElement("canvas");
      const context = canvas.getContext("2d");
      const video = this.$refs.video;

      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      context.drawImage(video, 0, 0, canvas.width, canvas.height);
      this.pagibig_proof = canvas.toDataURL("image/png");
    },
    recaptureImage() {
      this.capturedImage = null;
      this.pagibig_proof = null;
    },

    dataURLtoBlob(dataURL) {
      const byteString = atob(dataURL.split(",")[1]);
      const mimeString = dataURL.split(",")[0].split(":")[1].split(";")[0];
      const ab = new ArrayBuffer(byteString.length);
      const ia = new Uint8Array(ab);
      for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }
      return new Blob([ab], { type: mimeString });
    },

    beforeUnmount() {
      if (this.videoStream) {
        const tracks = this.videoStream.getTracks();
        tracks.forEach((track) => track.stop());
      }
    },
  },
};
</script>

<style scoped>
.btn {
  background-color: #3490dc;
  color: white;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #2779bd;
}

.container {
  max-width: 800px;
  margin: auto;
}

.object-cover {
  object-fit: cover;
}
</style>

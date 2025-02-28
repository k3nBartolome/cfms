<template>
  <!-- Sticky Header -->

  <form @submit.prevent="submitForm">
    <div class="px-4 py-4">
      <!-- Employee Details Section -->
      <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">EMPLOYEE DETAILS</span>
          <div class="flex items-center space-x-4">
            <button
              type="button"
              @click="toggleEmployeeInfo"
              class="text-blue-500 hover:text-blue-700 focus:outline-none"
            >
              <svg
                v-if="isEmployeeInfo"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
              <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 15l7-7 7 7"
                />
              </svg>
            </button>
          </div>
        </div>

        <div
          v-if="isEmployeeInfo"
          class="px-4 py-4 border rounded-lg bg-gray-50"
        >
          <div
            class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-5"
          >
            <!-- Employee ID -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Employee ID</label
              >
              <input
                v-model="employee_id"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- First Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >First Name</label
              >
              <input
                v-model="first_name"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Last Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Last Name</label
              >
              <input
                v-model="last_name"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Middle Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Middle Name</label
              >
              <input
                v-model="middle_name"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Date of Birth -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Date of Birth</label
              >
              <input
                v-model="birthdate"
                type="date"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Email</label
              >
              <input
                v-model="email"
                type="email"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Contact Number -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Contact#</label
              >
              <input
                v-model="contact_number"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Hired Date -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Hired Date</label
              >
              <input
                v-model="hired_date"
                type="date"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Hired Month -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Hired Month</label
              >
              <select
                v-model="hired_month"
                disabled
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="JAN">JAN</option>
                <option value="FEB">FEB</option>
                <option value="MAR">MAR</option>
                <option value="APR">APR</option>
                <option value="MAY">MAY</option>
                <option value="JUN">JUN</option>
                <option value="JUL">JUL</option>
                <option value="AUG">AUG</option>
                <option value="SEP">SEP</option>
                <option value="OCT">OCT</option>
                <option value="NOV">NOV</option>
                <option value="DEC">DEC</option>
              </select>
            </div>
            <!-- Employee Status -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Employee Status</label
              >
              <select
                v-model="employee_status"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Separated">Separated</option>
              </select>
            </div>
            <!-- Employment Status -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Employment Status</label
              >
              <select
                v-model="employment_status"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="Hired">Hired</option>
                <option value="To be Hired">To be Hired</option>
              </select>
            </div>
            <!-- Account Associate -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Position</label
              >
              <input
                v-model="account_associate"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Account Type -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Account Type</label
              >
              <select
                v-model="account_type"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="Agent">Agent</option>
                <option value="Non-Agent">Non-Agent</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Contract</label
              >
              <select
                v-model="contract"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="PHYSICAL">PHYSICAL</option>
                <option value="WORKDAY">WORKDAY</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >With Findings</label
              >
              <select
                v-model="with_findings"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option>Select one</option>
                <option value="WITH FINDINGS">WITH FINDINGS</option>
                <option value="N/A">N/A</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Date Endorsed to Compliance</label
              >
              <input
                v-model="date_endorsed_to_compliance"
                type="date"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Return to H&S(with findings)</label
              >
              <input
                v-model="return_to_hs_with_findings"
                type="date"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Last Received from H&S (with findings)</label
              >
              <input
                v-model="last_received_from_hs_with_findings"
                type="date"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Updated By -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Updated By</label
              >
              <input
                v-model="updated_by"
                type="text"
                disabled
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Last Updated At -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Last Updated At</label
              >
              <input
                v-model="updated_at"
                type="text"
                disabled
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- Workday Section -->
      <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">WORKDAY DETAILS</span>
          <button
            type="button"
            @click="toggleWorkdayInfo"
            class="text-blue-500 hover:text-blue-700 focus:outline-none"
          >
            <svg
              v-if="isWorkdayInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <div
          v-if="isWorkdayInfo"
          class="px-4 py-4 border rounded-lg bg-gray-50"
        >
          <div
            class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-5"
          >
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Workday ID</label
              >
              <input
                v-model="workday_id"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >RO Feedback</label
              >
              <input
                v-model="ro_feedback"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Per Findings</label
              >
              <input
                v-model="per_findings"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >201 Completion</label
              >
              <select
                v-model="completion"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option disabled>Please select one</option>
                <option value="COMPLETE">COMPLETE</option>
                <option value="WITH FINDINGS">WITH FINDINGS</option>
                <option value="PENDING">PENDING</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Contract Findings</label
              >
              <input
                v-model="contract_findings"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Contract Remarks</label
              >
              <select
                v-model="contract_remarks"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option disabled>Please select one</option>
                <option value="COMPLETE">COMPLETE</option>
                <option value="WITH FINDINGS">WITH FINDINGS</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Contract Status</label
              >
              <select
                v-model="contract_status"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option disabled>Please select one</option>
                <option value="DONE - WORKDAY">DONE - WORKDAY</option>
                <option value="DONE - MANUAL">DONE - MANUAL</option>
                <option value="PENDING">PENDING</option>
              </select>
            </div>

            <!-- Last Updated At -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Last Updated At</label
              >
              <input
                v-model="wd_updated_at"
                type="text"
                disabled
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- Programs Section -->
      <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">PROGRAM DETAILS</span>
          <button
            type="button"
            @click="toggleProgramInfo"
            class="text-blue-500 hover:text-blue-700 focus:outline-none"
          >
            <svg
              v-if="isProgramInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              ></path>
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <div
          v-if="isProgramInfo"
          class="px-4 py-4 border rounded-lg bg-gray-50"
        >
          <div
            class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-5"
          >
            <!-- Region -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Region</label
              >
              <select
                v-model="region"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option disabled value="">Please select Site</option>
                <option
                  v-for="regions in regions"
                  :key="regions"
                  :value="regions"
                >
                  {{ regions }}
                </option>
              </select>
            </div>
            <!-- Site -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Site</label
              >
              <select
                v-model="site"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option disabled value="">Please select Site</option>
                <option v-for="site in sites" :key="site.id" :value="site.id">
                  {{ site.name }}
                </option>
              </select>
            </div>
            <!-- LOB -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >LOB</label
              >
              <input
                v-model="lob"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Team Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Team Name</label
              >
              <input
                v-model="team_name"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Project Code -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Project Code</label
              >
              <input
                v-model="project_code"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <!-- Compliance POC -->
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Compliance POC</label
              >
              <input
                v-model="compliance_poc"
                type="text"
                :disabled="!isEditable"
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 truncate"
                >Last Updated At</label
              >
              <input
                v-model="lob_updated_at"
                type="text"
                disabled
                class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- NBI -->
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">NBI DETAILS</span>
          <button
            type="button"
            @click="toggleNbiInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isNbiInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- NBI Info Section -->
        <div v-if="isNbiInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="nbi_final_status"
                    @change="updateNBIData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">Yes</option>
                    <option value="NO">No</option>
                    <option value="NO - HIT RECEIPT">NO - HIT RECEIPT</option>
                    <option value="QUALITY CONTROL">QUALITY CONTROL</option>
                  </select>
                </div>

                <!-- Validity Date -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Validity Date</label
                  >
                  <input
                    v-model="nbi_validity_date"
                    type="date"
                    @change="updateNBIData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>

                <!-- Printed Date -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Printed Date</label
                  >
                  <input
                    v-model="nbi_printed_date"
                    type="date"
                    @change="updateNBIData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>

                <!-- Submitted Date -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    v-model="nbi_submitted_date"
                    type="date"
                    @change="updateNBIData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>

                <!-- Remarks -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="nbi_remarks"
                    type="text"
                    @input="updateNBIData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>

                <!-- NBI Proof Upload -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >NBI Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadNbiImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Updated By -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="nbi_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="nbi_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>

            <!-- Image Preview on the Right -->
            <div
              v-if="nbi_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="nbi_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">DT DETAILS</span>
          <button
            type="button"
            @click="toggleDtInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isDtInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- DT Info Section -->
        <div v-if="isDtInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="dt_final_status"
                    @change="updateDTData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="NEGATIVE">NEGATIVE</option>
                    <option value="POSITIVE - FOR CONFIRMATORY">
                      POSITIVE - FOR CONFIRMATORY
                    </option>
                    <option value="(BLANK)">(BLANK)</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Transaction Date</label
                  >
                  <input
                    v-model="dt_transaction_date"
                    @change="updateDTData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Result Date</label
                  >
                  <input
                    v-model="dt_results_date"
                    @change="updateDTData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Endorsed Date</label
                  >
                  <input
                    v-model="dt_endorsed_date"
                    @change="updateDTData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="dt_remarks"
                    type="text"
                    @input="updateDTData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >DT Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadDtImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Updated By -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="dt_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="dt_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="dt_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="dt_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">PEME DETAILS</span>
          <button
            type="button"
            @click="togglePemeInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isPemeInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- PEME Info Section -->
        <div v-if="isPemeInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="peme_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="updatePemeData"
                  >
                    <option disabled>Please select one</option>
                    <option value="COMPLETE">COMPLETE</option>
                    <option value="INCOMPLETE">INCOMPLETE</option>
                    <option value="BLANK">BLANK</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 truncae"
                    >Transaction Date</label
                  >
                  <input
                    v-model="peme_transaction_date"
                    @change="updatePemeData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Result Date</label
                  >
                  <input
                    v-model="peme_results_date"
                    @change="updatePemeData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Endorsed Date</label
                  >
                  <input
                    v-model="peme_endorsed_date"
                    @change="updatePemeData"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PEME Vendor</label
                  >
                  <input
                    v-model="peme_vendor"
                    @change="updatePemeData"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <select
                    v-model="peme_remarks"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="FIT TO WORK">FIT TO WORK</option>
                    <option value="UNFIT TO WORK">UNFIT TO WORK</option>
                    <option value="INCOMPLETE - PENDING DT">
                      INCOMPLETE - PENDING DT
                    </option>
                    <option value="INCOMPLETE - PENDING CHEST XRAY">
                      INCOMPLETE - PENDING CHEST XRAY
                    </option>
                    <option value="FOR OB CLEARANCE/ PENDING SPUTUM TEST">
                      FOR OB CLEARANCE/ PENDING SPUTUM TEST
                    </option>
                    <option value="FOR CARDIO CLEARANCE">
                      FOR CARDIO CLEARANCE
                    </option>
                    <option value="FOR PULMO CLEARANCE">
                      FOR PULMO CLEARANCE
                    </option>
                    <option value="FOR ORTHO CLEARANCE">
                      FOR ORTHO CLEARANCE
                    </option>
                    <option value="FOR OPTHA CLEARANCE">
                      FOR OPTHA CLEARANCE
                    </option>
                    <option value="FOR ENDO CLEARANCE">
                      FOR ENDO CLEARANCE
                    </option>
                    <option value="FOR CLINIC'S VALIDATION">
                      FOR CLINIC'S VALIDATION
                    </option>
                    <option value="FOR MEDICAL LEAVE">FOR MEDICAL LEAVE</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PEME Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadPemeImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Updated By -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="peme_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="peme_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="peme_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="peme_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">SSS DETAILS</span>
          <button
            type="button"
            @click="toggleSssInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isSssInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- SSS Info Section -->
        <div v-if="isSssInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="sss_final_status"
                    @change="updateSssData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                    <option value="PENDING PROOF">PENDING PROOF</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >SSS #</label
                  >
                  <input
                    v-model="sss_number"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="updateSssData"
                    @input="formatSSSNumber"
                    placeholder="01-2345678-9"
                  />
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted Type</label
                  >
                  <select
                    v-model="sss_proof_submitted_type"
                    @change="updateSssData"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="E-FORM">E-FORM</option>
                    <option value="NUMBER SLIP">NUMBER SLIP</option>
                    <option value="PERSONAL RECORD">PERSONAL RECORD</option>
                    <option value="VERIFICATION SLIP">VERIFICATION SLIP</option>
                    <option value="ONLINE STATIC INFO">
                      ONLINE STATIC INFO
                    </option>
                    <option value="ID">ID</option>
                    <option value="MEMBER DATE CHANGE REQUEST">
                      MEMBER DATE CHANGE REQUEST
                    </option>
                    <option value="R1A">R1A</option>
                    <option value="TRANSACTION RECEIPT">
                      TRANSACTION RECEIPT
                    </option>
                    <option value="SOA">SOA</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    @change="updateSssData"
                    v-model="sss_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >

                  <input
                    v-model="sss_remarks"
                    @change="updateSssData"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >SSS Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadSssImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="sss_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="sss_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="sss_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="sss_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">PHIC DETAILS</span>
          <button
            type="button"
            @click="togglePhicInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isPhicInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- PHIC Info Section -->
        <div v-if="isPhicInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="phic_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="updatePhicData"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                    <option value="PENDING PROOF">PENDING PROOF</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PHIC #</label
                  >
                  <input
                    v-model="phic_number"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @input="formatPhicNumber"
                    @change="updatePhicData"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted Type</label
                  >
                  <select
                    @change="updatePhicData"
                    v-model="phic_proof_submitted_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="ID">ID</option>
                    <option value="MDR">MDR</option>
                    <option value="PIN SLIP">PIN SLIP</option>
                    <option value="ONLINE STATIC INFO">
                      ONLINE STATIC INFO
                    </option>
                    <option value="STAMPED PMRF">STAMPED PMRF</option>
                    <option value="PERSONAL RECORD">PERSONAL RECORD</option>
                    <option value="TRANSACTION RECEIPT">
                      TRANSACTION RECEIPT
                    </option>
                    <option value="SOA">SOA</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    @change="updatePhicData"
                    v-model="phic_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    @change="updatePhicData"
                    v-model="phic_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PHIC Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadPhicImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="phic_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="phic_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="phic_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="phic_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">PAGIBIG DETAILS</span>
          <button
            type="button"
            @click="togglePagIbigInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isPagIbigInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- PAGIBIG Info Section -->
        <div v-if="isPagIbigInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="pagibig_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="updatePagibigData"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                    <option value="PENDING PROOF">PENDING PROOF</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Pag-IBIG Number</label
                  >
                  <input
                    @change="updatePagibigData"
                    v-model="pagibig_number"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @input="formatPagibigNumber"
                    placeholder="0123-4567-8901"
                  />
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted Type</label
                  >
                  <select
                    @change="updatePagibigData"
                    v-model="pagibig_proof_submitted_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="ID">ID</option>
                    <option value="MDF">MDF</option>
                    <option value="PROCESSED MCIF">PROCESSED MCIF</option>
                    <option value="SOA">SOA</option>
                    <option value="MP2">MP2</option>
                    <option value="TRANSACTION RECEIPT">
                      TRANSACTION RECEIPT
                    </option>
                    <option value="MID VALIDATION SLIP">
                      MID VALIDATION SLIP
                    </option>
                    <option value="ONLINE STATIC INFO">
                      ONLINE STATIC INFO
                    </option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    @change="updatePagibigData"
                    v-model="pagibig_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    @change="updatePagibigData"
                    v-model="pagibig_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PAGIBIG Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadPagIbigImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="pagibig_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="pagibig_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="pagibig_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="pagibig_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">TIN DETAILS</span>
          <button
            type="button"
            @click="toggleTinInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isTinInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- TIN Info Section -->
        <div v-if="isTinInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="tin_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                    <option value="NO - FOR ORUS">NO - FOR ORUS</option>
                    <option value="PENDING PROOF">PENDING PROOF</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >TIN Number</label
                  >
                  <input
                    v-model="tin_number"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @input="formatTinNumber"
                    placeholder="012-345-678"
                  />
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted Type</label
                  >
                  <select
                    v-model="tin_proof_submitted_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="ID">ID</option>
                    <option value="STAMPED VERIFICATION SLIP">
                      STAMPED VERIFICATION SLIP
                    </option>
                    <option value="BIR FORM 2316">BIR FORM 2316</option>
                    <option value="BIR FORM 1701">BIR FORM 1701</option>
                    <option value="PROCESSED BIR FORM">
                      PROCESSED BIR FORM
                    </option>
                    <option value="E-TIN CONFIRMATION">
                      E-TIN CONFIRMATION
                    </option>
                    <option value="ORUS VERIFICATION">ORUS VERIFICATION</option>
                    <option value="ORUS CONFIRMATION">ORUS CONFIRMATION</option>
                  </select>
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    v-model="tin_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="tin_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >TIN Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadTinImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="tin_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="tin_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="tin_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="tin_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">HEALTH CERTIFICATE DETAILS</span>
          <button
            type="button"
            @click="toggleHcInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isHcInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- HEALTH CERTIFICATEInfo Section -->
        <div v-if="isHcInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="health_certificate_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Validity Date</label
                  >
                  <input
                    v-model="health_certificate_validity_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    v-model="health_certificate_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="health_certificate_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >HEALTH CERTIFICATE Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadHcImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="health_certificate_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="health_certificate_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="health_certificate_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="health_certificate_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">OCCUPATIONAL PERMIT DETAILS</span>
          <button
            type="button"
            @click="toggleOpInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isOpInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- OCCUPATIONAL PERMIT Info Section -->
        <div v-if="isOpInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="occupational_permit_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Validity Date</label
                  >
                  <input
                    v-model="occupational_permit_validity_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Submitted Date</label
                  >
                  <input
                    v-model="occupational_permit_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="occupational_permit_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >OCCUPATIONAL PERMIT Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadOpImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="occupational_permit_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="occupational_permit_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="occupational_permit_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="occupational_permit_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">OFAC DETAILS</span>
          <button
            type="button"
            @click="toggleOfacInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isOfacInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- OFAC Info Section -->
        <div v-if="isOfacInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="ofac_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="CLEARED BEFORE DAY 1">
                      CLEARED BEFORE DAY 1
                    </option>
                    <option value="CLEARED BEYOND DAY 1">
                      CLEARED BEYOND DAY 1
                    </option>
                    <option value="WITH FINDINGS">WITH FINDINGS</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Checked</label
                  >
                  <input
                    v-model="ofac_checked_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="ofac_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >OFAC Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadOfacImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="ofac_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="ofac_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="ofac_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="ofac_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">SAM DETAILS</span>
          <button
            type="button"
            @click="toggleSamInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isSamInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- SAM Info Section -->
        <div v-if="isSamInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="sam_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="CLEARED BEFORE DAY 1">
                      CLEARED BEFORE DAY 1
                    </option>
                    <option value="CLEARED BEYOND DAY 1">
                      CLEARED BEYOND DAY 1
                    </option>
                    <option value="WITH FINDINGS">WITH FINDINGS</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Checked</label
                  >
                  <input
                    v-model="sam_checked_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="sam_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >SAM Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadSamImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="sam_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="sam_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="sam_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="sam_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">OIG DETAILS</span>
          <button
            type="button"
            @click="toggleOigInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isOigInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- OIG Info Section -->
        <div v-if="isOigInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="oig_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="CLEARED BEFORE DAY 1">
                      CLEARED BEFORE DAY 1
                    </option>
                    <option value="CLEARED BEYOND DAY 1">
                      CLEARED BEYOND DAY 1
                    </option>
                    <option value="WITH FINDINGS">WITH FINDINGS</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Checked</label
                  >
                  <input
                    v-model="oig_checked_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="oig_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >OIG Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadOigImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="oig_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="oig_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="oig_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="oig_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">CIBI DETAILS</span>
          <button
            type="button"
            @click="toggleCibiInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isCibiInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- CIBI Info Section -->
        <div v-if="isCibiInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="cibi_final_status"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="CLEARED BEFORE DAY 1">
                      CLEARED BEFORE DAY 1
                    </option>
                    <option value="CLEARED BEYOND DAY 1">
                      CLEARED BEYOND DAY 1
                    </option>
                    <option value="WITH FINDINGS">WITH FINDINGS</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Checked</label
                  >
                  <input
                    v-model="cibi_checked_date"
                    type="date"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Search</label
                  >
                  <input
                    v-model="cibi_search_date"
                    type="date"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="cibi_remarks"
                    type="text"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >CIBI Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadCibiImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="cibi_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="cibi_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="cibi_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="cibi_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">BGC DETAILS</span>
          <button
            type="button"
            @click="toggleBgcInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isBgcInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- BGC Info Section -->
        <div v-if="isBgcInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Final Status</label
                  >
                  <select
                    v-model="bgc_final_status"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="CLEARED BEFORE DAY 1">
                      CLEARED BEFORE DAY 1
                    </option>
                    <option value="CLEARED BEYOND DAY 1">
                      CLEARED BEYOND DAY 1
                    </option>
                    <option value="WITH FINDINGS">WITH FINDINGS</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Endorsed</label
                  >
                  <input
                    v-model="bgc_endorsed_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Result Date</label
                  >
                  <input
                    v-model="bgc_results_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >BGC Vendor</label
                  >
                  <input
                    v-model="bgc_vendor"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="bgc_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >BGC Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadBgcImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="bgc_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="bgc_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="bgc_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="bgc_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">BIRTH CERTIFICATE DETAILS</span>
          <button
            type="button"
            @click="toggleBcInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isBcInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- BIRTH CERTIFICATE Info Section -->
        <div v-if="isBcInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="birth_certificate_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="PSA">PSA</option>
                    <option value="NSO">NSO</option>
                    <option value="Certified true copy">
                      Certified true copy
                    </option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="birth_certificate_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="birth_certificate_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >BIRTH CERTIFICATE Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadBcImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="birth_certificate_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="birth_certificate_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="birth_certificate_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="birth_certificate_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold"
            >MARRIAGE CERTIFICATE DETAILS</span
          >
          <button
            type="button"
            @click="toggleMcInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isMcInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- MARRIAGE CERTIFICATE Info Section -->
        <div v-if="isMcInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="marriage_certificate_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="PSA">PSA</option>
                    <option value="NSO">NSO</option>
                    <option value="Certified true copy">
                      Certified true copy
                    </option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="marriage_certificate_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="marriage_certificate_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >MARRIAGE CERTIFICATE Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadMcImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="marriage_certificate_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="marriage_certificate_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="marriage_certificate_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="marriage_certificate_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold"
            >DEPENDENT BIRTH CERTIFICATE DETAILS</span
          >
          <button
            type="button"
            @click="toggleDbcInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isDbcInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- DEPENDENT BIRTH CERTIFICATE Info Section -->
        <div v-if="isDbcInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="dependent_birth_certificate_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="PSA">PSA</option>
                    <option value="NSO">NSO</option>
                    <option value="Certified true copy">
                      Certified true copy
                    </option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="dependent_birth_certificate_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="dependent_birth_certificate_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >DEPENDENT BIRTH CERTIFICATE Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadDbcImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="dependent_birth_certificate_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="dependent_birth_certificate_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="dependent_birth_certificate_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="dependent_birth_certificate_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">SCHOLASTIC RECORD DETAILS</span>
          <button
            type="button"
            @click="toggleSrInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isSrInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- SCHOLASTIC RECORD Info Section -->
        <div v-if="isSrInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="scholastic_record_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="School Id">School Id</option>
                    <option value="Diploma">Diploma</option>
                    <option value="TOR">TOR</option>
                    <option value="Copy of Grades">Copy of Grades</option>
                    <option value="Certification">Certification</option>
                    <option value="Others">Others</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="scholastic_record_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="scholastic_record_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >SCHOLASTIC RECORD Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadSrImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="scholastic_record_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="scholastic_record_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="scholastic_record_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="scholastic_record_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold">PREVIOUS EMPLOYMENT DETAILS</span>
          <button
            type="button"
            @click="togglePeInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isPeInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- PREVIOUS EMPLOYMENT Info Section -->
        <div v-if="isPeInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="previous_employment_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="Resignation Letter">
                      Resignation Letter
                    </option>
                    <option value="Acceptance Letter">Acceptance Letter</option>
                    <option value="Exit Clearance">Exit Clearance</option>
                    <option value="COE">COE</option>
                    <option value="Payslip">Payslip</option>
                    <option value="Others">Others</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="previous_employment_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="previous_employment_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >PREVIOUS EMPLOYMENT Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadPeImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="previous_employment_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="previous_employment_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="previous_employment_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="previous_employment_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <!-- Header with Toggle Button -->
        <div class="flex items-center justify-between mb-2">
          <span class="text-lg font-semibold"
            >SUPPORTING DOCUMENTS DETAILS</span
          >
          <button
            type="button"
            @click="toggleSdInfo"
            class="p-1 text-blue-500 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            <svg
              v-if="isSdInfo"
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
              />
            </svg>
          </button>
        </div>

        <!-- SUPPORTING DOCUMENTS Info Section -->
        <div v-if="isSdInfo" class="p-4 border rounded-lg bg-gray-50">
          <!-- Flex Container for Form and Image -->
          <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Form Section on the Left -->
            <div class="w-full lg:w-3/5">
              <!-- Grid for Input Fields -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <!-- Final Status -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Proof Submitted</label
                  >
                  <select
                    v-model="supporting_documents_proof_type"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option disabled>Please select one</option>
                    <option value="Affidavit of same person">
                      Affidavit of same person
                    </option>
                    <option value="Others">Others</option>
                  </select>
                </div>

                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Date Submitted</label
                  >
                  <input
                    v-model="supporting_documents_submitted_date"
                    type="date"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Remarks</label
                  >
                  <input
                    v-model="supporting_documents_remarks"
                    type="text"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >SUPPORTING DOCUMENTS Proof</label
                  >
                  <input
                    type="file"
                    @change="uploadSdImage"
                    :disabled="!isEditable"
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Updated By</label
                  >
                  <input
                    v-model="supporting_documents_updated_by"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <!-- Last Updated At -->
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 truncate"
                    >Last Updated At</label
                  >
                  <input
                    v-model="supporting_documents_last_updated_at"
                    type="text"
                    disabled
                    class="w-full p-2 mt-1 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
            <div
              v-if="supporting_documents_file_name"
              class="flex items-center justify-center w-full lg:w-2/5"
            >
              <img
                :src="supporting_documents_file_name"
                alt="Preview Image"
                class="object-contain w-full h-full max-h-[230px] border rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-between sticky-save-button">
        <div class="flex space-x-2">
          <button
            type="button"
            @click="expandAll"
            class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
          >
            Expand All
          </button>
          <button
            type="button"
            @click="collapseAll"
            class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
          >
            Collapse All
          </button>
          <button
            type="button"
            @click="toggleEdit"
            class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            {{ isEditable ? "Cancel" : "Edit" }}
          </button>
        </div>
        <div>
          <button
            v-if="isEditable"
            type="submit"
            @click="submitForm"
            class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Save Details
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      sites: [],
      regions: [],
      form: {},
      employee_id: "",
      employee_status: "",
      first_name: "",
      middle_name: "",
      last_name: "",
      hired_date: "",
      birthdate: "",
      contact_number: "",
      email: "",
      account_associate: "",
      account_type: "",
      employment_status: "",
      updated_by: "",
      updated_at: "",
      hired_month: "",
      contract: "",
      with_findings: "",
      date_endorsed_to_compliance: "",
      return_to_hs_with_findings: "",
      last_received_from_hs_with_findings: "",
      region: "",
      site: "",
      lob: "",
      team_name: "",
      project_code: "",
      compliance_poc: "",
      workday_id: "",
      ro_feedback: "",
      per_findings: "",
      completion: "",
      contract_findings: "",
      contract_remarks: "",
      contract_status: "",
      nbi_final_status: null,
      nbi_validity_date: "",
      nbi_submitted_date: "",
      nbi_printed_date: "",
      nbi_remarks: "",
      nbi_file_name: null,
      nbi_proof: null,
      dt_final_status: "",
      dt_results_date: "",
      dt_transaction_date: "",
      dt_endorsed_date: "",
      dt_remarks: "",
      dt_file_name: null,
      dt_proof: null,
      peme_file_name: null,
      peme_remarks: "",
      peme_endorsed_date: "",
      peme_results_date: "",
      peme_transaction_date: "",
      peme_final_status: "",
      peme_vendor: "",
      peme_proof: null,
      sss_proof_submitted_type: "",
      sss_final_status: "",
      sss_submitted_date: "",
      sss_remarks: "",
      sss_number: "",
      sss_file_name: null,
      sss_proof: null,
      phic_submitted_date: "",
      phic_final_status: "",
      phic_proof_submitted_type: "",
      phic_remarks: "",
      phic_number: "",
      phic_file_name: null,
      phic_proof: null,
      pagibig_submitted_date: "",
      pagibig_final_status: "",
      pagibig_proof_submitted_type: "",
      pagibig_remarks: "",
      pagibig_number: "",
      pagibig_file_name: null,
      pagibig_proof: null,
      tin_submitted_date: "",
      tin_final_status: "",
      tin_proof_submitted_type: "",
      tin_remarks: "",
      tin_number: "",
      tin_file_name: null,
      tin_proof: null,
      health_certificate_validity_date: "",
      health_certificate_submitted_date: "",
      health_certificate_remarks: "",
      health_certificate_file_name: null,
      health_certificate_final_status: "",
      health_certificate_proof: null,
      occupational_permit_validity_date: "",
      occupational_permit_submitted_date: "",
      occupational_permit_remarks: "",
      occupational_permit_file_name: null,
      occupational_permit_final_status: "",
      occupational_permit_proof: null,
      ofac_checked_date: "",
      ofac_final_status: "",
      ofac_remarks: "",
      ofac_file_name: null,
      ofac_proof: null,
      sam_checked_date: "",
      sam_final_status: "",
      sam_remarks: "",
      sam_file_name: null,
      sam_proof: null,
      oig_checked_date: "",
      oig_final_status: "",
      oig_remarks: "",
      oig_file_name: null,
      oig_proof: null,
      cibi_checked_date: "",
      cibi_search_date: "",
      cibi_final_status: "",
      cibi_remarks: "",
      cibi_file_name: null,
      cibi_proof: null,
      bgc_endorsed_date: "",
      bgc_results_date: "",
      bgc_final_status: "",
      bgc_remarks: "",
      bgc_vendor: "",
      bgc_file_name: null,
      bgc_proof: null,
      birth_certificate_file_name: null,
      birth_certificate_submitted_date: "",
      birth_certificate_proof_type: "",
      birth_certificate_remarks: "",
      birth_certificate_proof: null,
      dependent_birth_certificate_file_name: null,
      dependent_birth_certificate_submitted_date: "",
      dependent_birth_certificate_proof_type: "",
      dependent_birth_certificate_remarks: "",
      dependent_birth_certificate_proof: null,
      marriage_certificate_file_name: null,
      marriage_certificate_submitted_date: "",
      marriage_certificate_proof_type: "",
      marriage_certificate_remarks: "",
      marriage_certificate_proof: null,
      scholastic_record_file_name: null,
      scholastic_record_submitted_date: "",
      scholastic_record_proof_type: "",
      scholastic_record_remarks: "",
      scholastic_record_proof: null,
      previous_employment_file_name: null,
      previous_employment_submitted_date: "",
      previous_employment_proof_type: "",
      previous_employment_remarks: "",
      previous_employment_proof: null,
      supporting_documents_file_name: null,
      supporting_documents_submitted_date: "",
      supporting_documents_proof_type: "",
      supporting_documents_remarks: "",
      supporting_documents_proof: null,
      nbi_updated_by: "",
      dt_updated_by: "",
      peme_updated_by: "",
      sss_updated_by: "",
      phic_updated_by: "",
      pagibig_updated_by: "",
      tin_updated_by: "",
      health_certificate_updated_by: "",
      occupational_permit_updated_by: "",
      ofac_updated_by: "",
      sam_updated_by: "",
      oig_updated_by: "",
      cibi_updated_by: "",
      bgc_updated_by: "",
      birth_certificate_updated_by: "",
      dependent_birth_certificate_updated_by: "",
      marriage_certificate_updated_by: "",
      scholastic_record_updated_by: "",
      previous_employment_updated_by: "",
      supporting_documents_updated_by: "",
      wd_updated_at: "",
      lob_updated_at: "",
      nbi_last_updated_at: "",
      dt_last_updated_at: "",
      peme_last_updated_at: "",
      sss_last_updated_at: "",
      phic_last_updated_at: "",
      pagibig_last_updated_at: "",
      tin_last_updated_at: "",
      health_certificate_last_updated_at: "",
      occupational_permit_last_updated_at: "",
      ofac_last_updated_at: "",
      sam_last_updated_at: "",
      oig_last_updated_at: "",
      cibi_last_updated_at: "",
      bgc_last_updated_at: "",
      birth_certificate_last_updated_at: "",
      dependent_birth_certificate_last_updated_at: "",
      marriage_certificate_last_updated_at: "",
      scholastic_record_last_updated_at: "",
      previous_employment_last_updated_at: "",
      supporting_documents_last_updated_at: "",
      isEmployeeInfo: true,
      isWorkdayInfo: false,
      isProgramInfo: false,
      isNbiInfo: false,
      isDtInfo: false,
      isPemeInfo: false,
      isSssInfo: false,
      isPhicInfo: false,
      isPagIbigInfo: false,
      isTinInfo: false,
      isHcInfo: false,
      isOpInfo: false,
      isOfacInfo: false,
      isSamInfo: false,
      isOigInfo: false,
      isCibiInfo: false,
      isBgcInfo: false,
      isBcInfo: false,
      isDbcInfo: false,
      isMcInfo: false,
      isSrInfo: false,
      isPeInfo: false,
      isSdInfo: false,
      isEditable: false,
      isSubmitting: false,
    };
  },

  watch: {
    hired_date(newValue) {
      if (newValue) {
        // Convert the date string to a Date object
        const date = new Date(newValue);
        // Extract the month and map it to the corresponding short name
        const months = [
          "JAN",
          "FEB",
          "MAR",
          "APR",
          "MAY",
          "JUN",
          "JUL",
          "AUG",
          "SEP",
          "OCT",
          "NOV",
          "DEC",
        ];
        this.hired_month = months[date.getMonth()];
      } else {
        this.hired_month = "Select one"; // Reset if no date is selected
      }
    },
  },
  mounted() {
    this.fetchEmployeeData();
    this.getSites();
    this.getRegion();
  },
  methods: {
    uploadNbiImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.nbi_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.nbi_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadDtImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.dt_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.dt_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadPemeImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.peme_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.peme_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadSssImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.sss_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.sss_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadPhicImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.phic_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.phic_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadPagIbigImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.pagibig_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.pagibig_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadTinImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.tin_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.tin_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadHcImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.health_certificate_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.health_certificate_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadOpImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.occupational_permit_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.occupational_permit_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadOfacImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.ofac_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.ofac_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadSamImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.sam_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.sam_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadOigImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.oig_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.oig_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadCibiImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.cibi_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.cibi_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadBgcImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.bgc_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.bgc_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadBcImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.birth_certificate_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.birth_certificate_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadDbcImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.dependent_birth_certificate_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.dependent_birth_certificate_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadMcImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.marriage_certificate_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.marriage_certificate_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadSrImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.scholastic_record_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.scholastic_record_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadPeImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.previous_employment_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.previous_employment_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
    },
    uploadSdImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.supporting_documents_proof = file;
        const reader = new FileReader();
        reader.onload = () => {
          this.supporting_documents_file_name = reader.result;
        };
        reader.readAsDataURL(file);
      }
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
        const token = this.$store.state.token; // Retrieve the token from Vuex store
        const response = await axios.get("https://10.109.2.112/api/sites", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          this.sites = response.data.data; // Populate sites with API response data
          console.log("Sites loaded:", response.data.data);
        } else {
          console.log("Error fetching sites");
        }
      } catch (error) {
        console.error("Error while fetching sites:", error);
      }
    },
    async fetchEmployeeData() {
      try {
        const response = await axios.get(
          `https://10.109.2.112/api/get/employees/${this.$route.params.id}`
        );
        const data = response.data.data;

        // Populate the form fields with API response data
        this.employee_id = data.employee_id || "";
        this.employee_status = data.employee_status || "";
        this.first_name = data.first_name || "";
        this.middle_name = data.middle_name || "";
        this.last_name = data.last_name || "";
        this.hired_date = data.hired_date || "";
        this.birthdate = data.birthdate || "";
        this.contact_number = data.contact_number || "";
        this.email = data.email || "";
        this.account_associate = data.account_associate || "";
        this.account_type = data.account_type || "";
        this.employment_status = data.employment_status || "";
        this.updated_by = data.updated_by || "";
        this.updated_at = data.updated_at || "";
        this.hired_month = data.hired_month || "";
        this.contract = data.contract || "";
        this.with_findings = data.with_findings || "";
        this.date_endorsed_to_compliance =
          data.date_endorsed_to_compliance || "";
        this.return_to_hs_with_findings = data.return_to_hs_with_findings || "";
        this.last_received_from_hs_with_findings =
          data.last_received_from_hs_with_findings || "";
        this.region = data.region || "";
        this.site = data.site || "";
        this.lob = data.lob || "";
        this.team_name = data.team_name || "";
        this.project_code = data.project_code || "";
        this.compliance_poc = data.compliance_poc || "";
        this.workday_id = data.workday_id || "";
        this.ro_feedback = data.ro_feedback || "";
        this.per_findings = data.per_findings || "";
        this.completion = data.completion || "";
        this.contract_findings = data.contract_findings || "";
        this.contract_remarks = data.contract_remarks || "";
        this.contract_status = data.contract_status || "";
        this.nbi_final_status = data.nbi_final_status;
        this.nbi_validity_date = data.nbi_validity_date;
        this.nbi_submitted_date = data.nbi_submitted_date;
        this.nbi_printed_date = data.nbi_printed_date;
        this.nbi_remarks = data.nbi_remarks;
        this.nbi_file_name = data.nbi_file_name;
        this.dt_final_status = data.dt_final_status || "";
        this.dt_results_date = data.dt_results_date || "";
        this.dt_transaction_date = data.dt_transaction_date || "";
        this.dt_endorsed_date = data.dt_endorsed_date || "";
        this.dt_remarks = data.dt_remarks || "";
        this.dt_file_name = data.dt_file_name || "";
        this.peme_file_name = data.peme_file_name || null;
        this.peme_remarks = data.peme_remarks || null;
        this.peme_endorsed_date = data.peme_endorsed_date || null;
        this.peme_results_date = data.peme_results_date || null;
        this.peme_transaction_date = data.peme_transaction_date || null;
        this.peme_final_status = data.peme_final_status || null;
        this.peme_proof = data.peme_proof || null;
        this.peme_vendor = data.peme_vendor || null;
        this.sss_proof_submitted_type = data.sss_proof_submitted_type || null;
        this.sss_final_status = data.sss_final_status || null;
        this.sss_submitted_date = data.sss_submitted_date || null;
        this.sss_remarks = data.sss_remarks || null;
        this.sss_number = data.sss_number || null;
        this.sss_file_name = data.sss_file_name || null;
        this.sss_proof = data.sss_proof || null;
        this.phic_submitted_date = data.phic_submitted_date || null;
        this.phic_final_status = data.phic_final_status || null;
        this.phic_proof_submitted_type = data.phic_proof_submitted_type || null;
        this.phic_remarks = data.phic_remarks || null;
        this.phic_number = data.phic_number || null;
        this.phic_file_name = data.phic_file_name || null;
        this.phic_proof = data.phic_proof || null;
        this.pagibig_submitted_date = data.pagibig_submitted_date || null;
        this.pagibig_final_status = data.pagibig_final_status || null;
        this.pagibig_proof_submitted_type =
          data.pagibig_proof_submitted_type || null;
        this.pagibig_remarks = data.pagibig_remarks || null;
        this.pagibig_number = data.pagibig_number || null;
        this.pagibig_file_name = data.pagibig_file_name || null;
        this.pagibig_proof = data.pagibig_proof || null;
        this.tin_submitted_date = data.tin_submitted_date || null;
        this.tin_final_status = data.tin_final_status || null;
        this.tin_proof_submitted_type = data.tin_proof_submitted_type || null;
        this.tin_remarks = data.tin_remarks || null;
        this.tin_number = data.tin_number || null;
        this.tin_file_name = data.tin_file_name || null;
        this.tin_proof = data.tin_proof || null;
        this.health_certificate_validity_date =
          data.health_certificate_validity_date || null;
        this.health_certificate_submitted_date =
          data.health_certificate_submitted_date || null;
        this.health_certificate_remarks =
          data.health_certificate_remarks || null;
        this.health_certificate_file_name =
          data.health_certificate_file_name || null;
        this.health_certificate_final_status =
          data.health_certificate_final_status || null;
        this.health_certificate_proof = data.health_certificate_proof || null;
        this.occupational_permit_validity_date =
          data.occupational_permit_validity_date || null;
        this.occupational_permit_submitted_date =
          data.occupational_permit_submitted_date || null;
        this.occupational_permit_remarks =
          data.occupational_permit_remarks || null;
        this.occupational_permit_file_name =
          data.occupational_permit_file_name || null;
        this.occupational_permit_final_status =
          data.occupational_permit_final_status || null;
        this.occupational_permit_proof = data.occupational_permit_proof || null;
        this.ofac_checked_date = data.ofac_checked_date || null;
        this.ofac_final_status = data.ofac_final_status || null;
        this.ofac_remarks = data.ofac_remarks || null;
        this.ofac_file_name = data.ofac_file_name || null;
        this.ofac_proof = data.ofac_proof || null;
        this.sam_checked_date = data.sam_checked_date || null;
        this.sam_final_status = data.sam_final_status || null;
        this.sam_remarks = data.sam_remarks || null;
        this.sam_file_name = data.sam_file_name || null;
        this.sam_proof = data.sam_proof || null;
        this.oig_checked_date = data.oig_checked_date || null;
        this.oig_final_status = data.oig_final_status || null;
        this.oig_remarks = data.oig_remarks || null;
        this.oig_file_name = data.oig_file_name || null;
        this.oig_proof = data.oig_proof || null;
        this.cibi_checked_date = data.cibi_checked_date || null;
        this.cibi_search_date = data.cibi_search_date || null;
        this.cibi_final_status = data.cibi_final_status || null;
        this.cibi_remarks = data.cibi_remarks || null;
        this.cibi_file_name = data.cibi_file_name || null;
        this.cibi_proof = data.cibi_proof || null;
        this.bgc_endorsed_date = data.bgc_endorsed_date || null;
        this.bgc_results_date = data.bgc_results_date || null;
        this.bgc_final_status = data.bgc_final_status || null;
        this.bgc_remarks = data.bgc_remarks || null;
        this.bgc_file_name = data.bgc_file_name || null;
        this.bgc_proof = data.bgc_proof || null;
        this.bgc_vendor = data.bgc_vendor || null;
        this.birth_certificate_file_name =
          data.birth_certificate_file_name || null;
        this.birth_certificate_submitted_date =
          data.birth_certificate_submitted_date || null;
        this.birth_certificate_proof_type =
          data.birth_certificate_proof_type || null;
        this.birth_certificate_remarks = data.birth_certificate_remarks || null;
        this.birth_certificate_proof = data.birth_certificate_proof || null;
        this.dependent_birth_certificate_file_name =
          data.dependent_birth_certificate_file_name || null;
        this.dependent_birth_certificate_submitted_date =
          data.dependent_birth_certificate_submitted_date || null;
        this.dependent_birth_certificate_proof_type =
          data.dependent_birth_certificate_proof_type || null;
        this.dependent_birth_certificate_remarks =
          data.dependent_birth_certificate_remarks || null;
        this.dependent_birth_certificate_proof =
          data.dependent_birth_certificate_proof || null;
        this.marriage_certificate_file_name =
          data.marriage_certificate_file_name || null;
        this.marriage_certificate_submitted_date =
          data.marriage_certificate_submitted_date || null;
        this.marriage_certificate_proof_type =
          data.marriage_certificate_proof_type || null;
        this.marriage_certificate_remarks =
          data.marriage_certificate_remarks || null;
        this.marriage_certificate_proof =
          data.marriage_certificate_proof || null;
        this.scholastic_record_file_name =
          data.scholastic_record_file_name || null;
        this.scholastic_record_submitted_date =
          data.scholastic_record_submitted_date || null;
        this.scholastic_record_proof_type =
          data.scholastic_record_proof_type || null;
        this.scholastic_record_remarks = data.scholastic_record_remarks || null;
        this.scholastic_record_proof = data.scholastic_record_proof || null;
        this.previous_employment_file_name =
          data.previous_employment_file_name || null;
        this.previous_employment_submitted_date =
          data.previous_employment_submitted_date || null;
        this.previous_employment_proof_type =
          data.previous_employment_proof_type || null;
        this.previous_employment_remarks =
          data.previous_employment_remarks || null;
        this.previous_employment_proof = data.previous_employment_proof || null;
        this.supporting_documents_file_name =
          data.supporting_documents_file_name || null;
        this.supporting_documents_submitted_date =
          data.supporting_documents_submitted_date || null;
        this.supporting_documents_proof_type =
          data.supporting_documents_proof_type || null;
        this.supporting_documents_remarks =
          data.supporting_documents_remarks || null;
        this.supporting_documents_proof =
          data.supporting_documents_proof || null;
        this.nbi_updated_by = data.nbi_updated_by || null;
        this.dt_updated_by = data.dt_updated_by || null;
        this.peme_updated_by = data.peme_updated_by || null;
        this.sss_updated_by = data.sss_updated_by || null;
        this.phic_updated_by = data.phic_updated_by || null;
        this.pagibig_updated_by = data.pagibig_updated_by || null;
        this.tin_updated_by = data.tin_updated_by || null;
        this.health_certificate_updated_by =
          data.health_certificate_updated_by || null;
        this.occupational_permit_updated_by =
          data.occupational_permit_updated_by || null;
        this.ofac_updated_by = data.ofac_updated_by || null;
        this.sam_updated_by = data.sam_updated_by || null;
        this.oig_updated_by = data.oig_updated_by || null;
        this.cibi_updated_by = data.cibi_updated_by || null;
        this.bgc_updated_by = data.bgc_updated_by || null;
        this.birth_certificate_updated_by =
          data.birth_certificate_updated_by || null;
        this.dependent_birth_certificate_updated_by =
          data.dependent_birth_certificate_updated_by || null;
        this.marriage_certificate_updated_by =
          data.marriage_certificate_updated_by || null;
        this.scholastic_record_updated_by =
          data.scholastic_record_updated_by || null;
        this.previous_employment_updated_by =
          data.previous_employment_updated_by || null;
        this.supporting_documents_updated_by =
          data.supporting_documents_updated_by || null;
        this.wd_updated_at = data.wd_updated_at || null;
        this.lob_updated_at = data.lob_updated_at || null;
        this.nbi_last_updated_at = data.nbi_last_updated_at || null;
        this.nbi_last_updated_at = data.nbi_last_updated_at || null;
        this.dt_last_updated_at = data.dt_last_updated_at || null;
        this.peme_last_updated_at = data.peme_last_updated_at || null;
        this.sss_last_updated_at = data.sss_last_updated_at || null;
        this.phic_last_updated_at = data.phic_last_updated_at || null;
        this.pagibig_last_updated_at = data.pagibig_last_updated_at || null;
        this.tin_last_updated_at = data.tin_last_updated_at || null;
        this.health_certificate_last_updated_at =
          data.health_certificate_last_updated_at || null;
        this.occupational_permit_last_updated_at =
          data.occupational_permit_last_updated_at || null;
        this.ofac_last_updated_at = data.ofac_last_updated_at || null;
        this.sam_last_updated_at = data.sam_last_updated_at || null;
        this.oig_last_updated_at = data.oig_last_updated_at || null;
        this.cibi_last_updated_at = data.cibi_last_updated_at || null;
        this.bgc_last_updated_at = data.bgc_last_updated_at || null;
        this.birth_certificate_last_updated_at =
          data.birth_certificate_last_updated_at || null;
        this.dependent_birth_certificate_last_updated_at =
          data.dependent_birth_certificate_last_updated_at || null;
        this.marriage_certificate_last_updated_at =
          data.marriage_certificate_last_updated_at || null;
        this.scholastic_record_last_updated_at =
          data.scholastic_record_last_updated_at || null;
        this.previous_employment_last_updated_at =
          data.previous_employment_last_updated_at || null;
        this.supporting_documents_last_updated_at =
          data.supporting_documents_last_updated_at || null;
      } catch (error) {
        console.error("Error fetching NBI data:", error);
      }
    },
    async submitForm() {
      if (this.isSubmitting) return;

      this.isSubmitting = true;

      try {
        const apiUrl = `https://10.109.2.112/api/update/employee/${this.$route.params.id}`;
        const formData = new FormData();

        // Append general form data
        Object.keys(this.form).forEach((key) => {
          formData.append(key, this.form[key] || "");
        });

        // Append employee data
        formData.append("first_name", this.first_name || "");
        formData.append("middle_name", this.middle_name || "");
        formData.append("last_name", this.last_name || "");
        formData.append("account_associate", this.account_associate || "");
        formData.append("account_type", this.account_type || "");
        formData.append("employee_id", this.employee_id || "");
        formData.append("contact_number", this.contact_number || "");
        formData.append("email", this.email || "");
        formData.append("birthdate", this.birthdate || "");
        formData.append("hired_date", this.hired_date || "");
        formData.append("employee_status", this.employee_status || "");
        formData.append("employment_status", this.employment_status || "");
        formData.append("hired_month", this.hired_month || "");
        formData.append("updated_by", this.$store.state.user_id);
        formData.append("contract", this.contract || "");
        formData.append("with_findings", this.with_findings || "");
        formData.append(
          "date_endorsed_to_compliance",
          this.date_endorsed_to_compliance || ""
        );
        formData.append(
          "return_to_hs_with_findings",
          this.return_to_hs_with_findings || ""
        );
        formData.append(
          "last_received_from_hs_with_findings",
          this.last_received_from_hs_with_findings || ""
        );
        // Append LOB data
        formData.append("region", this.region || "");
        formData.append("site", this.site || "");
        formData.append("lob", this.lob || "");
        formData.append("team_name", this.team_name || "");
        formData.append("project_code", this.project_code || "");
        formData.append("compliance_poc", this.compliance_poc || "");

        // Append Workday data
        formData.append("workday_id", this.workday_id || "");
        formData.append("ro_feedback", this.ro_feedback || "");
        formData.append("per_findings", this.per_findings || "");
        formData.append("completion", this.completion || "");
        formData.append("contract_findings", this.contract_findings || "");
        formData.append("contract_remarks", this.contract_remarks || "");
        formData.append("contract_status", this.contract_status || "");

        // Append Requirements data
        formData.append("nbi_final_status", this.nbi_final_status || "");
        formData.append("dt_final_status", this.dt_final_status || "");
        formData.append("peme_final_status", this.peme_final_status || "");
        formData.append("sss_final_status", this.sss_final_status || "");
        formData.append("phic_final_status", this.phic_final_status || "");
        formData.append(
          "pagibig_final_status",
          this.pagibig_final_status || ""
        );
        formData.append("tin_final_status", this.tin_final_status || "");
        formData.append(
          "health_certificate_final_status",
          this.health_certificate_final_status || ""
        );
        formData.append(
          "occupational_permit_final_status",
          this.occupational_permit_final_status || ""
        );
        formData.append("ofac_final_status", this.ofac_final_status || "");
        formData.append("sam_final_status", this.sam_final_status || "");
        formData.append("oig_final_status", this.oig_final_status || "");
        formData.append("cibi_final_status", this.cibi_final_status || "");
        formData.append("bgc_final_status", this.bgc_final_status || "");
        formData.append(
          "birth_certificate_final_status",
          this.birth_certificate_final_status || ""
        );
        formData.append(
          "dependent_birth_certificate_final_status",
          this.dependent_birth_certificate_final_status || ""
        );
        formData.append(
          "marriage_certificate_final_status",
          this.marriage_certificate_final_status || ""
        );
        formData.append(
          "scholastic_record_final_status",
          this.scholastic_record_final_status || ""
        );
        formData.append(
          "previous_employment_final_status",
          this.previous_employment_final_status || ""
        );
        formData.append(
          "supporting_documents_final_status",
          this.supporting_documents_final_status || ""
        );

        formData.append("nbi_final_status", this.nbi_final_status || "");
        formData.append("nbi_validity_date", this.nbi_validity_date || "");
        formData.append("nbi_submitted_date", this.nbi_submitted_date || "");
        formData.append("nbi_printed_date", this.nbi_printed_date || "");
        formData.append("nbi_remarks", this.nbi_remarks || "");
        formData.append("nbi_updated_by", this.$store.state.user_id || "");
        formData.append("dt_final_status", this.dt_final_status || "");
        formData.append("dt_results_date", this.dt_results_date || "");
        formData.append("dt_transaction_date", this.dt_transaction_date || "");
        formData.append("dt_endorsed_date", this.dt_endorsed_date || "");
        formData.append("dt_remarks", this.dt_remarks || "");
        formData.append("dt_updated_by", this.$store.state.user_id || "");
        formData.append("peme_final_status", this.peme_final_status || "");
        formData.append("peme_results_date", this.peme_results_date || "");
        formData.append(
          "peme_transaction_date",
          this.peme_transaction_date || ""
        );
        formData.append("peme_endorsed_date", this.peme_endorsed_date || "");
        formData.append("peme_remarks", this.peme_remarks || "");
        formData.append("peme_vendor", this.peme_vendor || "");
        formData.append("peme_updated_by", this.$store.state.user_id || "");
        formData.append("sss_final_status", this.sss_final_status || "");
        formData.append("sss_submitted_date", this.sss_submitted_date || "");
        formData.append("sss_remarks", this.sss_remarks || "");
        formData.append("sss_number", this.sss_number || "");
        formData.append(
          "sss_proof_submitted_type",
          this.sss_proof_submitted_type || ""
        );
        formData.append("sss_updated_by", this.$store.state.user_id || "");
        formData.append("phic_submitted_date", this.phic_submitted_date || "");
        formData.append("phic_final_status", this.phic_final_status || "");
        formData.append(
          "phic_proof_submitted_type",
          this.phic_proof_submitted_type || ""
        );
        formData.append("phic_remarks", this.phic_remarks || "");
        formData.append("phic_number", this.phic_number || "");
        formData.append("phic_updated_by", this.$store.state.user_id || "");
        formData.append(
          "pagibig_submitted_date",
          this.pagibig_submitted_date || ""
        );
        formData.append(
          "pagibig_final_status",
          this.pagibig_final_status || ""
        );
        formData.append(
          "pagibig_proof_submitted_type",
          this.pagibig_proof_submitted_type || ""
        );
        formData.append("pagibig_remarks", this.pagibig_remarks || "");
        formData.append("pagibig_number", this.pagibig_number || "");
        formData.append("pagibig_updated_by", this.$store.state.user_id || "");
        formData.append("tin_submitted_date", this.tin_submitted_date || "");
        formData.append("tin_final_status", this.tin_final_status || "");
        formData.append(
          "tin_proof_submitted_type",
          this.tin_proof_submitted_type || ""
        );
        formData.append("tin_remarks", this.tin_remarks || "");
        formData.append("tin_number", this.tin_number || "");
        formData.append("tin_updated_by", this.$store.state.user_id || "");
        formData.append(
          "health_certificate_validity_date",
          this.health_certificate_validity_date || ""
        );
        formData.append(
          "health_certificate_final_status",
          this.health_certificate_final_status || ""
        );
        formData.append(
          "health_certificate_submitted_date",
          this.health_certificate_submitted_date || ""
        );
        formData.append(
          "health_certificate_remarks",
          this.health_certificate_remarks || ""
        );
        formData.append(
          "health_certificate_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "occupational_permit_validity_date",
          this.occupational_permit_validity_date || ""
        );
        formData.append(
          "occupational_permit_submitted_date",
          this.occupational_permit_submitted_date || ""
        );
        formData.append(
          "occupational_permit_remarks",
          this.occupational_permit_remarks || ""
        );
        formData.append(
          "occupational_permit_final_status",
          this.occupational_permit_final_status || ""
        );
        formData.append(
          "occupational_permit_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append("ofac_checked_date", this.ofac_checked_date || "");
        formData.append("ofac_final_status", this.ofac_final_status || "");
        formData.append("ofac_remarks", this.ofac_remarks || "");
        formData.append("ofac_updated_by", this.$store.state.user_id || "");
        formData.append("sam_checked_date", this.sam_checked_date || "");
        formData.append("sam_final_status", this.sam_final_status || "");
        formData.append("sam_remarks", this.sam_remarks || "");
        formData.append("sam_updated_by", this.$store.state.user_id || "");
        formData.append("oig_checked_date", this.oig_checked_date || "");
        formData.append("oig_final_status", this.oig_final_status || "");
        formData.append("oig_remarks", this.oig_remarks || "");
        formData.append("oig_updated_by", this.$store.state.user_id || "");
        formData.append("cibi_checked_date", this.cibi_checked_date || "");

        formData.append("cibi_search_date", this.cibi_search_date || "");
        formData.append("cibi_final_status", this.cibi_final_status || "");
        formData.append("cibi_remarks", this.cibi_remarks || "");
        formData.append("cibi_updated_by", this.$store.state.user_id || "");
        formData.append("bgc_endorsed_date", this.bgc_endorsed_date || "");
        formData.append("bgc_vendor", this.bgc_vendor || "");
        formData.append("bgc_results_date", this.bgc_results_date || "");
        formData.append("bgc_final_status", this.bgc_final_status || "");
        formData.append("bgc_remarks", this.bgc_remarks || "");
        formData.append("bgc_updated_by", this.$store.state.user_id || "");
        formData.append(
          "birth_certificate_submitted_date",
          this.birth_certificate_submitted_date || ""
        );
        formData.append(
          "birth_certificate_proof_type",
          this.birth_certificate_proof_type || ""
        );
        formData.append(
          "birth_certificate_remarks",
          this.birth_certificate_remarks || ""
        );
        formData.append(
          "birth_certificate_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "dependent_birth_certificate_submitted_date",
          this.dependent_birth_certificate_submitted_date || ""
        );
        formData.append(
          "dependent_birth_certificate_proof_type",
          this.dependent_birth_certificate_proof_type || ""
        );
        formData.append(
          "dependent_birth_certificate_remarks",
          this.dependent_birth_certificate_remarks || ""
        );
        formData.append(
          "dependent_birth_certificate_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "marriage_certificate_submitted_date",
          this.marriage_certificate_submitted_date || ""
        );
        formData.append(
          "marriage_certificate_proof_type",
          this.marriage_certificate_proof_type || ""
        );
        formData.append(
          "marriage_certificate_remarks",
          this.marriage_certificate_remarks || ""
        );
        formData.append(
          "marriage_certificate_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "scholastic_record_submitted_date",
          this.scholastic_record_submitted_date || ""
        );
        formData.append(
          "scholastic_record_proof_type",
          this.scholastic_record_proof_type || ""
        );
        formData.append(
          "scholastic_record_remarks",
          this.scholastic_record_remarks || ""
        );
        formData.append(
          "scholastic_record_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "previous_employment_submitted_date",
          this.previous_employment_submitted_date || ""
        );
        formData.append(
          "previous_employment_proof_type",
          this.previous_employment_proof_type || ""
        );
        formData.append(
          "previous_employment_remarks",
          this.previous_employment_remarks || ""
        );
        formData.append(
          "previous_employment_updated_by",
          this.$store.state.user_id || ""
        );
        formData.append(
          "supporting_documents_submitted_date",
          this.supporting_documents_submitted_date || ""
        );
        formData.append(
          "supporting_documents_proof_type",
          this.supporting_documents_proof_type || ""
        );
        formData.append(
          "supporting_documents_remarks",
          this.supporting_documents_remarks || ""
        );
        formData.append(
          "supporting_documents_updated_by",
          this.$store.state.user_id || ""
        );

        if (this.nbi_proof instanceof File) {
          formData.append("nbi_proof", this.nbi_proof);
        }
        if (this.dt_proof instanceof File) {
          formData.append("dt_proof", this.dt_proof);
        }
        if (this.peme_proof instanceof File) {
          formData.append("peme_proof", this.peme_proof);
        }
        if (this.sss_proof instanceof File) {
          formData.append("sss_proof", this.sss_proof);
        }
        if (this.phic_proof instanceof File) {
          formData.append("phic_proof", this.phic_proof);
        }
        if (this.pagibig_proof instanceof File) {
          formData.append("pagibig_proof", this.pagibig_proof);
        }
        if (this.tin_proof instanceof File) {
          formData.append("tin_proof", this.tin_proof);
        }
        if (this.health_certificate_proof instanceof File) {
          formData.append(
            "health_certificate_proof",
            this.health_certificate_proof
          );
        }
        if (this.occupational_permit_proof instanceof File) {
          formData.append(
            "occupational_permit_proof",
            this.occupational_permit_proof
          );
        }
        if (this.ofac_proof instanceof File) {
          formData.append("ofac_proof", this.ofac_proof);
        }
        if (this.sam_proof instanceof File) {
          formData.append("sam_proof", this.sam_proof);
        }
        if (this.oig_proof instanceof File) {
          formData.append("oig_proof", this.oig_proof);
        }
        if (this.cibi_proof instanceof File) {
          formData.append("cibi_proof", this.cibi_proof);
        }
        if (this.bgc_proof instanceof File) {
          formData.append("bgc_proof", this.bgc_proof);
        }
        if (this.birth_certificate_proof instanceof File) {
          formData.append(
            "birth_certificate_proof",
            this.birth_certificate_proof
          );
        }
        if (this.dependent_birth_certificate_proof instanceof File) {
          formData.append(
            "dependent_birth_certificate_proof",
            this.dependent_birth_certificate_proof
          );
        }
        if (this.marriage_certificate_proof instanceof File) {
          formData.append(
            "marriage_certificate_proof",
            this.marriage_certificate_proof
          );
        }
        if (this.scholastic_record_proof instanceof File) {
          formData.append(
            "scholastic_record_proof",
            this.scholastic_record_proof
          );
        }
        if (this.previous_employment_proof instanceof File) {
          formData.append(
            "previous_employment_proof",
            this.previous_employment_proof
          );
        }
        if (this.supporting_documents_proof instanceof File) {
          formData.append(
            "supporting_documents_proof",
            this.supporting_documents_proof
          );
        }

        const token = localStorage.getItem("token"); // Ensure you have the token
        const response = await axios.post(apiUrl, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${token}`,
          },
        });

        alert(response.data.message || "Update successful!");
        this.$router.push({
          name: "OnboardingUpdateForm",
          params: { id: this.$route.params.id },
        });
      } catch (error) {
        console.error(
          "Error submitting form",
          error.response ? error.response.data : error.message
        );
        alert(
          "An error occurred while updating data. Please check the console for details."
        );
      } finally {
        this.isSubmitting = false;
      }
    },

    expandAll() {
      this.isWorkdayInfo = true;
      this.isProgramInfo = true;
      this.isNbiInfo = true;
      this.isDtInfo = true;
      this.isPemeInfo = true;
      this.isSssInfo = true;
      this.isPhicInfo = true;
      this.isPagIbigInfo = true;
      this.isTinInfo = true;
      this.isHcInfo = true;
      this.isOpInfo = true;
      this.isOfacInfo = true;
      this.isSamInfo = true;
      this.isOigInfo = true;
      this.isCibiInfo = true;
      this.isBgcInfo = true;
      this.isBcInfo = true;
      this.isDbcInfo = true;
      this.isMcInfo = true;
      this.isSrInfo = true;
      this.isPeInfo = true;
      this.isSdInfo = true;
    },
    collapseAll() {
      this.isWorkdayInfo = false;
      this.isProgramInfo = false;
      this.isNbiInfo = false;
      this.isDtInfo = false;
      this.isPemeInfo = false;
      this.isSssInfo = false;
      this.isPhicInfo = false;
      this.isPagIbigInfo = false;
      this.isTinInfo = false;
      this.isHcInfo = false;
      this.isOpInfo = false;
      this.isOfacInfo = false;
      this.isSamInfo = false;
      this.isOigInfo = false;
      this.isCibiInfo = false;
      this.isBgcInfo = false;
      this.isBcInfo = false;
      this.isDbcInfo = false;
      this.isMcInfo = false;
      this.isSrInfo = false;
      this.isPeInfo = false;
      this.isSdInfo = false;
    },
    toggleEmployeeInfo() {
      this.isEmployeeInfo = !this.isEmployeeInfo;
    },

    toggleWorkdayInfo() {
      this.isWorkdayInfo = !this.isWorkdayInfo;
    },
    toggleProgramInfo() {
      this.isProgramInfo = !this.isProgramInfo;
    },
    toggleNbiInfo() {
      this.isNbiInfo = !this.isNbiInfo;
    },
    toggleDtInfo() {
      this.isDtInfo = !this.isDtInfo;
    },
    togglePemeInfo() {
      this.isPemeInfo = !this.isPemeInfo;
    },
    toggleSssInfo() {
      this.isSssInfo = !this.isSssInfo;
    },
    togglePhicInfo() {
      this.isPhicInfo = !this.isPhicInfo;
    },
    togglePagIbigInfo() {
      this.isPagIbigInfo = !this.isPagIbigInfo;
    },
    toggleTinInfo() {
      this.isTinInfo = !this.isTinInfo;
    },
    toggleHcInfo() {
      this.isHcInfo = !this.isHcInfo;
    },
    toggleOpInfo() {
      this.isOpInfo = !this.isOpInfo;
    },
    toggleOfacInfo() {
      this.isOfacInfo = !this.isOfacInfo;
    },
    toggleSamInfo() {
      this.isSamInfo = !this.isSamInfo;
    },
    toggleOigInfo() {
      this.isOigInfo = !this.isOigInfo;
    },
    toggleCibiInfo() {
      this.isCibiInfo = !this.isCibiInfo;
    },
    toggleBgcInfo() {
      this.isBgcInfo = !this.isBgcInfo;
    },
    toggleBcInfo() {
      this.isBcInfo = !this.isBcInfo;
    },
    toggleDbcInfo() {
      this.isDbcInfo = !this.isDbcInfo;
    },
    toggleMcInfo() {
      this.isMcInfo = !this.isMcInfo;
    },
    toggleSrInfo() {
      this.isSrInfo = !this.isSrInfo;
    },
    togglePeInfo() {
      this.isPeInfo = !this.isPeInfo;
    },
    toggleSdInfo() {
      this.isSdInfo = !this.isSdInfo;
    },

    toggleEdit() {
      this.isEditable = !this.isEditable;
    },
    formatSSSNumber() {
      let rawValue = this.sss_number.replace(/[^0-9]/g, "");
      if (rawValue.length <= 2) {
        this.sss_number = rawValue;
      } else if (rawValue.length <= 9) {
        this.sss_number = `${rawValue.slice(0, 2)}-${rawValue.slice(2)}`;
      } else {
        this.sss_number = `${rawValue.slice(0, 2)}-${rawValue.slice(
          2,
          9
        )}-${rawValue.slice(9, 10)}`;
      }
    },
    formatPhicNumber() {
      let numericValue = this.phic_number.replace(/\D/g, "");
      if (numericValue.length > 12) {
        numericValue = numericValue.slice(0, 12);
      }
      const parts = [
        numericValue.slice(0, 2),
        numericValue.slice(2, 10),
        numericValue.slice(10, 12),
      ];
      this.phic_number = parts.filter((part) => part).join("-");
    },
    formatPagibigNumber() {
      let rawValue = this.pagibig_number.replace(/[^0-9]/g, "");
      if (rawValue.length <= 4) {
        this.pagibig_number = rawValue;
      } else if (rawValue.length <= 8) {
        this.pagibig_number = `${rawValue.slice(0, 4)}-${rawValue.slice(4)}`;
      } else {
        this.pagibig_number = `${rawValue.slice(0, 4)}-${rawValue.slice(
          4,
          8
        )}-${rawValue.slice(8, 12)}`;
      }
    },
    formatTinNumber() {
      let rawValue = this.tin_number.replace(/[^0-9]/g, "");
      if (rawValue.length <= 3) {
        this.tin_number = rawValue;
      } else if (rawValue.length <= 6) {
        this.tin_number = `${rawValue.slice(0, 3)}-${rawValue.slice(3)}`;
      } else {
        this.tin_number = `${rawValue.slice(0, 3)}-${rawValue.slice(
          3,
          6
        )}-${rawValue.slice(6, 9)}`;
      }
    },
  },
};
</script>

<style scoped>
.sticky-save-button {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: white; /* Optional: Add background color */
  padding: 1rem;
  text-align: right;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
  z-index: 1000; /* Ensure it stays on top of other content */
}
.sticky-edit-button {
  position: fixed;
  top: 1;
  left: 0;
  right: 0;
  background-color: white; /* Optional: Add background color */
  padding: 1rem;
  text-align: right;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
}
</style>

<template>
  <div class="py-0">
  <div class="px-1 py-0 mx-auto bg-white max-w-7xl sm:px-6 lg:px-8">
 
  </div>
</div>
  <main class="flex flex-col min-h-screen border border-gray-300">
    <!-- Main Content -->
    <div class="flex flex-1 px-4 py-2 overflow-y-auto md:px-6 md:py-4">
      <div class="w-full py-6">
        <router-view />
      </div>
    </div>
  </main>
</template>
<script>
export default {
  data() {
    return {
     
    };
  },
  mounted() {
    this.$router.afterEach(() => {
      window.location.reload();
    });
   
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
};
</script>
<style>
* {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  font-size: 100%;
  vertical-align: baseline;
  background: transparent;
}
main {
  overflow-y: auto; /* Enable vertical scrolling when content overflows */
  border-left-width: 1px; /* Ensure left border is persistent */
  border-color: #ccc; /* Define a consistent border color */
}
@media (min-width: 576px) {
  .tab-button {
    padding: 1rem 0.75rem;
  }
}
@media (min-width: 768px) {
  .tab-button {
    padding: 1rem 0.5rem;
  }
}
.link-button {
  text-decoration: none;
}
.svg-button {
  display: flex;
  align-items: center;
  gap: 5px;
}

.svg-button svg {
  width: 1em;
  height: 1em;
  border: 1px solid #000;
}
.svg-button2 {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 8px;
  height: 20px;
  width: auto;
}
.svg-button2 svg {
  width: 1em;
  height: 1em;
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

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
  display: flex;
  align-items: center;
  justify-content: center;

  overflow: auto; /* Allow scrolling if the content exceeds screen height */
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 90%; /* Take 90% of the screen width on smaller screens */
  max-width: 600px; /* Limit the width on larger screens */
  max-height: 90vh; /* Prevent the modal from exceeding the viewport height */
  overflow-y: auto; /* Add vertical scroll if content overflows */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for better contrast */
}

.drop-container:hover,
.drop-container.drag-active {
  background: #eee;
  border-color: #111;
}

.drop-container:hover .drop-title,
.drop-container.drag-active .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color 0.2s ease-in-out;
}
</style>

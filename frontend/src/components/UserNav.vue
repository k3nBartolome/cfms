<template>
  <div class="bg-white">
    <nav class="container px-6 py-2 mx-auto md:flex md:justify-between md:items-center">

      <div class="flex items-center justify-between">
        <img :src="logo" alt="VXI Logo" class="w-20 h-10">
        <!-- Mobile menu button -->
        <div @click="toggleNav" class="flex md:hidden">
          <button type="button" class="text-orange-600 hover:text-gray-400 focus:outline-none focus:text-orange-600">
            <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
              <path fill-rule="evenodd"
                d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
              </path>
            </svg>
          </button>
        </div>
      </div>
      <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
      <ul :class="showMenu ? 'flex' : 'hidden'"
        class="flex-col mt-8 space-y-4 font-bold md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0">
      <router-link to="/dashboard"><li class="text-black hover:text-orange-600 focus:outline-none focus:shadow-outline-orange-600">Dashboard</li></router-link>
      <router-link to="/capfile"><li class="text-black hover:text-orange-600 focus:outline-none focus:shadow-outline-orange-600">Capacity File</li></router-link>
      </ul>
    </nav>
  </div>
</template>
<script>
import { ref } from 'vue';
import logo from './storage/vxilogo.jpg'
export default {
  setup() {
    let showMenu = ref(false);
    const toggleNav = () => (showMenu.value = !showMenu.value);
    return { showMenu, toggleNav };
  },
  data() {
    return {
      logo,
    }
  },
};
</script>
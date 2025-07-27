<script setup>
import TheHeader from './components/TheHeader.vue'
// import TheFooter from './components/TheFooter.vue'
</script>

<template>
  <TheHeader></TheHeader>
   <div class="content">
    <router-view />
  </div>
  <!-- <TheFooter></TheFooter> -->
</template>

<style scoped>
.content {
  padding-top: 76px; /* hoặc đúng chiều cao header */
}
</style>
<script setup>
import TheHeader from './components/TheHeader.vue'
// import TheFooter from './components/TheFooter.vue'
</script>

<template>
  <TheHeader v-if="!$route.meta.hideHeader"></TheHeader>
  <div :class="{
    content: !$route.meta.hideHeader,
    content1: $route.meta.hideHeader
  }">
    <router-view />
  </div>
  <!-- <TheFooter></TheFooter> -->
</template>

<style scoped>
.content {
  padding-top: 76px;
}

.content1 {
  padding-top: none;

}
</style>
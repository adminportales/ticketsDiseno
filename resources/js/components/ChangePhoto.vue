<template>
  <div
    class="m-0 justify-content-center align-items-end width-icon change-icon"
    @click="change"
  >
    <span class="fa-fw select-all fas"></span>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    change() {
      alert("cambiar foto");
    },
  },
};
</script>

<style>
</style>

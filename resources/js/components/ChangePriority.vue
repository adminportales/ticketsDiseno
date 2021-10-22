<template>
  <div class="">
    <button class="btn btn-sm btn-info" @click="change">
      <i class="fas fa-sync-alt"></i>
    </button>
  </div>
</template>

<script>
export default {
  props: ["ticket", "priorities"],
  data() {
    return {
      prioritiesData: this.priorities,
    };
  },
  mounted() {
      alert('dsc')
  },
  methods: {
    change() {},
  },
};
</script>

<style>
</style>

<template>
  <div>{{ message }}</div>
</template>

<script>
export default {
  props: ["user"],
  mounted() {
    window.Echo.channel("notification").listen("MessageSendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        Toastify({
          text: `${e.emisor}\n ${e.message}`,
          duration: 3000,
          backgroundColor: "#435ebe",
        }).showToast();
      }
    });
  },
  data: function () {
    return {
      message: "",
    };
  },
};
</script>

<style>
</style>

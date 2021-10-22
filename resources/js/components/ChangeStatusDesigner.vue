<template>
  <div class="form-check form-switch">
    <input
      class="form-check-input"
      type="checkbox"
      id="flexSwitchCheckDefault"
      @click="change"
      :checked="currentAvailability"
    />
    <label class="form-check-label" for="flexSwitchCheckDefault">{{
      message
    }}</label>
  </div>
</template>

<script>
export default {
  props: ["availability", "user"],
  data() {
    return {
      message: "",
      currentAvailability: "",
    };
  },
  mounted() {
    this.currentAvailability = this.availability;
    this.message = this.currentAvailability ? "Disponible" : "No disponible";
  },
  methods: {
    change() {
      this.currentAvailability = this.currentAvailability ? 0 : 1;
      this.message = this.currentAvailability ? "Disponible" : "No disponible";
      this.changeStatus(this.currentAvailability);
    },
    async changeStatus(status) {
      try {
        let params = { status, _method: "put" };
        let res = await axios.post(
          `/design-manager/update-availability/${this.user}`,
          params
        );
        let data = res.data;
        Toastify({
          text: "La disponibilidad se cambio exitosamente",
          duration: 3000,
          backgroundColor: "#198754",
        }).showToast();
      } catch (error) {
        Toastify({
          text: "Ops! No se pudo cambiar la disponibilidad :(",
          duration: 3000,
          backgroundColor: "#dc3545",
        }).showToast();
        this.currentAvailability = this.currentAvailability ? 0 : 1;
        this.message = this.currentAvailability
          ? "Disponible"
          : "No disponible";
      }
    },
  },
};
</script>

<style>
</style>

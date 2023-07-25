<template>
  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @click="change"
      :checked="currentAvailability" />
  </div>
</template>

<script>
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);
export default {
  props: ["availability", "user"],
  data() {
    return {
      message: "",
      currentAvailability: "",
      reason: "",
    };
  },
  mounted() {
    this.currentAvailability = this.availability;
    this.message = this.currentAvailability ? "Disponible" : "No disponible";
  },
  methods: {
    change() {
      this.currentAvailability = this.currentAvailability ? 0 : 1;
      if (!this.currentAvailability) {
        // SweetAlert
        this.$swal({
          title: '¿Por qué no estás disponible?',
          input: 'text',
          inputPlaceholder: 'Escribe el motivo',
          showCloseButton: true,
        }).then((result) => {
          if (result.value) {
            this.reason = result.value;
            this.changeStatus(this.currentAvailability);
          } else {
            this.currentAvailability = 1;
          }
        })
      } else {
        this.changeStatus(this.currentAvailability);
      }

    },
    async changeStatus(status) {
      try {
        let params = {
          status,
          reason: this.reason,
          _method: "put"
        };
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
      }
    },
  },
};
</script>

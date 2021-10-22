<template>
  <div class="d-flex">
    <span class="badge" :class="color">{{ designerCurrent }}</span>

    <div class="dropdown">
      <button
        class="btn btn-info btn-sm dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      ></button>
      <ul
        class="dropdown-menu dropdown-menu-dark"
        aria-labelledby="dropdownMenuButton"
      >
        <li v-for="designer in designers" :key="designer.id">
          <a class="dropdown-item" @click="changeDesigner(designer.id)">
            {{ designer.name }}</a
          >
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: ["ticket", "designers", "designer"],
  data() {
    return {
      designersData: this.designers,
      color: "",
      designerCurrent: "",
    };
  },
  mounted() {
    this.designerCurrent = this.designer;
  },
  methods: {
    async changeDesigner(designer) {
      try {
        if (this.designers.id == designer) {
          return;
        }
        let params = { designer: designer, _method: "put" };
        let res = await axios.post(
          `/sales-manager/update-designer/${this.ticket}`,
          params
        );
        let data = res.data;
        if (data != "equaldesigner") {
          this.designerCurrent = data.designer;
          Toastify({
            text: "La prioridad se cambio exitosamente",
            duration: 3000,
            backgroundColor: "#198754",
          }).showToast();
        }
      } catch (error) {
        Toastify({
          text: "Ops! No se pudo cambiar la propiedad :(",
          duration: 3000,
          backgroundColor: "#dc3545",
        }).showToast();
      }
    },
    changeColor() {
      switch (this.designerCurrent) {
        case "Alta":
          this.color = "bg-danger";
          break;
        case "Normal":
          this.color = "bg-warning";
          break;
        case "Baja":
          this.color = "bg-success";
          break;
        default:
          break;
      }
    },
  },
};
</script>

<style scoped>
.dropdown-menu {
  min-width: 1rem !important;
}
</style>

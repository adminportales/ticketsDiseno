<template>
  <div class="d-flex">
    <div class="dropdown">
      <button
        class="btn btn-sm dropdown-toggle" :class="color"
        type="button"
        id="dropdownMenuButton"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        {{ priorityCurrent }}
      </button>
      <ul
        class="dropdown-menu dropdown-menu-dark"
        aria-labelledby="dropdownMenuButton"
      >
        <li v-for="priority in priorities" :key="priority.id">
          <a class="dropdown-item" @click="changePriority(priority.id)">
            {{ priority.priority }}</a
          >
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: ["ticket", "priorities", "priority"],
  data() {
    return {
      prioritiesData: this.priorities,
      color: "",
      priorityCurrent: "",
    };
  },
  mounted() {
    this.priorityCurrent = this.priority;
    this.changeColor();
  },
  methods: {
    async changePriority(priority) {
      try {
        if (this.priorities.id == priority) {
          return;
        }
        let params = { priority: priority, _method: "put" };
        let res = await axios.post(
          `/sales-manager/update-priority/${this.ticket}`,
          params
        );
        let data = res.data;
        if (data != "equalPriority") {
          this.priorityCurrent = data.priority;
          this.changeColor();
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
      switch (this.priorityCurrent) {
        case "Alta":
          this.color = "btn-danger";
          break;
        case "Normal":
          this.color = "btn-warning";
          break;
        case "Baja":
          this.color = "btn-success";
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

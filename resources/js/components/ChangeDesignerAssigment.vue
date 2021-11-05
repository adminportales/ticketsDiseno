<template>
  <div class="d-flex">
    <span></span>

    <div class="dropdown">
      <button
        class="boton btn-sm dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        {{ designerCurrent }}
      </button>
      <ul
        class="dropdown-menu dropdown-menu-dark"
        aria-labelledby="dropdownMenuButton"
      >
        <li v-for="designer in designers" :key="designer.id">
          <a class="dropdown-item" @click="changeDesigner(designer)">
            {{ designer.name.replace("#", " ") }}
            {{ designer.lastname.replace("#", " ") }}</a
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
        if (this.designers.id == designer.id) {
          return;
        }

        let params = {
          designer_id: designer.id,
          designer_name:
            designer.name.replace("#", " ") +
            " " +
            designer.lastname.replace("#", " "),
          _method: "put",
        };
        let res = await axios.post(
          `/design-manager/update-assign/${this.ticket}`,
          params
        );
        let data = res.data;
        if (data != "equalDesigner") {
          this.designerCurrent = data.designer;
          Toastify({
            text: `Se ha reasignado ha ${designer.name.replace("#", " ")}`,
            duration: 3000,
            backgroundColor: "#198754",
          }).showToast();
          this.designerCurrent = data.name;
        }
      } catch (error) {
        // console.log(error);
        Toastify({
          text: "Ops! No se pudo reasignar el ticket :(",
          duration: 3000,
          backgroundColor: "#dc3545",
        }).showToast();
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

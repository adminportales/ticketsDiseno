<template>
  <div>
    <div v-for="(item, index) in usersSelected" :key="index" class="d-inline">
      <div class="btn-group">
        <p class="btn btn-primary">{{ item.name }}</p>
        <p class="btn btn-primary" @click="deleteUser(item)">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </p>
      </div>
    </div>
    <input
      class="form-control"
      type="text"
      v-model="userSearch"
      @keyup="search"
    />
    <input type="hidden" v-model="idsUsers" name="team" />
    <div class="list-group" v-if="this.userSearch">
      <li
        v-for="userSearch in usersSearch"
        :key="userSearch.id"
        class="list-group-item"
        @click="addUserSelected(userSearch)"
      >
        {{ userSearch.name }}
        {{ userSearch.lastname }}
      </li>
    </div>
  </div>
</template>

<script>
export default {
  props: ["members"],
  data() {
    return {
      users: [],
      usersSelected: [],
      userSearch: "",
      usersSearch: [],
      idsUsers: "",
    };
  },
  mounted() {
    this.obtenerUsuarios();
  },
  methods: {
    async obtenerUsuarios() {
      try {
        let res = await axios.get("/users/all");
        let data = res.data;
        this.users = data;
      } catch {
        console.log(error);
      }
    },
    search() {
      this.usersSearch = this.users.filter((item) => {
        return (
          item.name.indexOf(this.userSearch) >= 0 ||
          item.lastname.indexOf(this.userSearch) >= 0
        );
      });
    },
    addUserSelected(user) {
      let repeticion = this.usersSelected.filter((item) => item.id == user.id);
      if (repeticion.length == 0) {
        this.usersSelected.push(user);
      }
      this.getIds();
    },
    deleteUser(user) {
      this.usersSelected = this.usersSelected.filter(
        (item) => item.id != user.id
      );
      this.getIds();
    },
    getIds() {
      this.idsUsers = this.usersSelected.map((element) => {
        return element.id;
      });
    },
  },
};
</script>

<style scoped>
.list-group-item:hover {
  background-color: #032a3d;
  color: #ffffff;
  cursor: pointer;
}
</style>

<template>
  <div>
    <form action="">
      <div class="form-group">
        <label for="">Archivo en vue</label>
        <p onclick="cambiarNumero">{{ numero }}</p>
        <input type="file" class="form-control" />
      </div>
      <input type="submit" value="Enviar archvio" />
    </form>
    <button @click="numero == 1 ? 0 : 1">Cambiar</button>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      numero: 1,
    };
  },
  methods: {},
};
</script>

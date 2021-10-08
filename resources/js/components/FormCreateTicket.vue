<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="category">Categoria</label>
          <select name="category" class="form-control">
            <option value="">Seleccione...</option>
          </select>
        </div>
        <div class="form-group">
          <label for="customer">Cliente</label>
          <input type="text" class="form-control" name="customer" />
        </div>
        <div class="form-group">
          <label for="title">Titulo</label>
          <input type="text" class="form-control" name="title" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="technique">Tecnica</label>
          <input type="text" class="form-control" name="technique" />
        </div>
        <div class="form-group">
          <label for="pantone">Pantone</label>
          <input type="color" class="form-control" name="pantone" />
        </div>
        <div class="form-group">
          <label for="logo">Logo</label>
          <input type="file" class="form-control" name="logo" />
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="logo">Descripcion</label>
          <textarea rows="" cols="" class="form-control w-100"></textarea>
        </div>
      </div>

      <p>Dropzone para los items</p>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

<template>
    <div>
        <table class="table table-bordered table-products ">
          <thead>
            <tr class=" table-primary ">
              <th scope="col">Opciones</th>
              <th scope="col">Categoria</th>
              <th scope="col">Productos</th>
              <th scope="col">Tipo</th>

            </tr>
          </thead>
          <tbody>

            <tr v-for="(categoria,index) in listaCategorias.data" :key="categoria.id">
              <th scope="row" >
                <span v-if="editMode==(index+1)">
                  <button  type="button" class="btn btn-primary btn-sm" v-on:click="onClickUpdate(categoria,index)">Guardar</button>
                  <button  type="button" class="btn btn-secondary btn-sm" v-on:click="onClickCloseEdit">Cerrar</button>
                </span>
                <span v-else>
                  <button  type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(categoria,index)"><i class="fas fa-times-circle"></i></button>
                </span>
              </th>
              <th>
                <input v-if="editMode==(index+1)" type="text" name="nombre" v-model="categoria.nombre">
                <span  v-else> {{categoria.nombre}} </span>
              </th>
              <th>
                <input v-if="editMode==(index+1)" type="text" name="categoria" v-model="categoria.categoria">
                <span  v-else> {{categoria.cantidadProductos}} </span>
              </th>
              <th>
                <input v-if="editMode==(index+1)" type="text" name="stock" v-model="categoria.stock">
                <span  v-else> {{categoria.tipo}} </span>
              </th>
            </tr>         
          </tbody>
        </table>
        <pagination :data="listaCategorias" @pagination-change-page="getResults" class="float-right">
        </pagination>
        
    </div>
</template>

<script>
    export default {
        props: {
        },
        data(){
            return {
              editMode: 0,
              listaCategorias: {}
                
            }
              
        },
        mounted() {
          this.getResults();
        },
        methods:{
            getResults(page = 1) {
              axios.get('/categorias?page=' + page)
                .then(response => {
                  this.listaCategorias = response.data;
                });
            },
            onClickDelete(categoria,index){
              //var answer = window.confirm("¿Está seguro que desea elimminar?")
              var answer = true;
              if (answer) {
                  axios.delete('/categorias/'+categoria.id).then(()=>{
                    this.categorias.splice(index,1);
                    this.$toasted.show('Categoria Eliminada Exitosamente', { 
                     theme: "toasted-primary", 
                     position: "top-right", 
                     duration : 2000
                    });
                  })
              }
                
            },
            onClickOpenEdit(index){
                this.editMode = index+1;

            },
            onClickCloseEdit(){
                this.editMode = 0;
            },
            onClickUpdate(product,index){
              const params = {
                nombre: product.nombre,                
                categoria: product.categoria,
                stock: product.stock,
                precio: product.precio,
                n_serie: product.n_serie
              }
              axios.put('/products/'+product.id, params).then((response)=>{
                this.editMode = 0;
                const new_product = response.data;
                this.$emit('updateProduct', new_product, index);
                this.$toasted.show('Producto Actualizado Exitosamente', { 
                 theme: "toasted-primary", 
                 position: "top-right", 
                 duration : 2000
                });
              })

              

            }
        },
        computed: {
        }
        
    }
</script>
<style>
.table-products{
    table-layout: fixed;
    width: 100%;
}
.td-venta {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
}
.input-venta{
  width: 100%;
}

</style>

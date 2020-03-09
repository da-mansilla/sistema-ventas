<template>
    <div>
        <!-- Button trigger modal -->
        
        <!-- Modal-->
        <div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form autocomplete="off" v-on:submit.prevent="newProduct()">
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg" v-model="n_serie" v-on:keydown.enter='inputSerie' required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg" v-model="nombre" required  v-on:keydown.enter.prevent='enter' list="sugerencias">
                          <datalist id="sugerencias">
                              <option>remeras</option>
                              <option>Pantalones</option>
                              <option>Camperas</option>
                          </datalist>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Agregar</button>
              </div>
              </form>
                
            </div>
          </div>
        </div>
            
        
    </div>

</template>

<script>
    import Toasted from 'vue-toasted';
    export default {
    	data(){
    		return {
    			nombre: '',
	            categoria: '',
	            precio: '',
	            n_serie: '',
                talle: '',
                color: ''

    		}
    	},
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
        	newProduct(){
                let index = this.n_serie.indexOf("%");
                let serie = this.n_serie.slice(0, index);
                const params = {
                    nombre : this.nombre,               
                    categoria: this.categoria,
                    talle: this.talle,
                    color: this.color,
                    precio: this.precio,
                    n_serie: serie,
                    enabled: 1
                };
                axios.post('/products', params)
                        .then((response)=>{
                            const product = response.data;
                            this.$emit('new', product);
                });
                this.$toasted.show('Producto Cargado Exitosamente', { 
                 theme: "toasted-primary", 
                 position: "top-right", 
                 duration : 2000
                });
	            this.nombre= '';	              
	            this.categoria= '';
                this.talle= '';
                this.color= '';
                this.precio= '';
                this.n_serie= '';
    		},
            inputSerie(){
                let index = this.n_serie.indexOf("%");
                var codigoTemporada = this.n_serie.substr(0,3);
                var codigoCategoria = this.n_serie.substr(3,2);
                var codigoTalle= this.n_serie.substr(index+3);
                var codigoColor = this.n_serie.substr((index+1),2);
                console.log('Temporada: '+ codigoTemporada); 
                console.log('Categoria: '+ codigoCategoria); 
                console.log('Color: '+ codigoColor); 
                console.log('Talle: '+ codigoTalle);

                this.talle = codigoTalle;

                axios.get('seriecolor/'+codigoColor)
                .then((response)=>{
                    console.log(response.data);
                }).catch((err)=>{
                    console.log('No existe ese Color');
                }).then(()=>{
                    console.log('Guardando Color');
                });                     
            }
        }
    }
</script>

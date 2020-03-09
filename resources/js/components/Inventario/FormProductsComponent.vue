<template>
    <div>
        <!-- Button trigger modal -->

        <!-- Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form autocomplete="off" v-on:submit.prevent="newProduct()">
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">N° Serie</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg" v-model="n_serie" v-on:keydown.enter='inputSerie' required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Temporada</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control form-control-lg" v-model="nombre" >
                        </div>

                        <label for="sub-grupo-tipo" class="col-sm-2 col-form-label col-form-label-lg">Tipo</label>
                        <div class="col-sm-4">
                          <select id="sub-grupo-tipo" class="form-control form-control-lg" required="" v-on:click="elegirTipo" v-model="tipo">
                            <option value="Niño">Niños</option>
                            <option value="Niña">Niñas</option>
                            <option value="Unisex">Unisex</option>
                          </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Categoria</label>
                        <div class="input-group col-sm-4">
                            <select v-if="seleccionarCategoria"class="form-control form-control-lg" v-model="categoria" required>
                                <option v-for="sugerencia in sugerenciasList">{{sugerencia.nombre}} ({{sugerencia.tipo}})</option>
                            </select>
                            <input v-if="!seleccionarCategoria"type="text" class="form-control form-control-lg" v-model="categoria" required>

                            <div class="input-group-append">
                             <button class="btn btn-outline-secondary" type="button" v-on:click="clickCrearNuevaCategoria"><i class="fas fa-plus"></i></button>
                            </div>
                            <!--
                          <input type="text" class="form-control form-control-lg" v-model="categoria" required list="sugerencias">
                          <datalist id="sugerencias" >
                              <option v-for="sugerencia in sugerenciasList">{{sugerencia.nombre}} ({{sugerencia.tipo}})</option>
                          </datalist>
                      -->
                        </div>
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Cantidad</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control form-control-lg" v-model="cantidad">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Talle</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" v-model="talle">
                        </div>

                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Color</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" v-model="color">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Costo</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control form-control-lg" v-model="costo" required v-on:keyup="redondeoAumentar()">
                        </div>
                        <div class="input-group col-sm-6">
                            <label for="colFormLabelLg" class=" col-form-label col-form-label-lg" style="margin-right: 58px;">Precio</label>

                            <input type="number" class="form-control form-control-lg ml-4 "v-model="factor" v-on:keyup="redondeoAumentar()"required >
                            <div class="input-group-append">
                             <button class="btn btn-outline-secondary" type="button"><i class="fas fa-percentage"></i></button>
                            </div>

                            <input type="number" class="form-control form-control-lg ml-2 pl-1 pr-0" v-model="precio" required>

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
        props: {
          categorias: {
                type: Array,
                default: ''
            }
        },
    	data(){
    		return {
    			nombre: '',
                tipo: '',
	            categoria: '',
	            costo: '',
                precio: '',
                cantidad: 1,
	            n_serie: '',
                talle: '',
                color: '',
                sugerenciasList: [],
                crearColor: false,
                clickCategoria: false,
                factor: 10,
                seleccionarCategoria: true

    		}
    	},
        mounted() {
            $('#exampleModal').on('hidden.bs.modal', this.cerrarModal);
        },
        methods: {
            cerrarModal(){

                this.categoria= '';
                this.tipo= '';
                this.nombre= '';                  
                this.talle= '';
                this.color= '';
                this.costo= '';
                this.n_serie= '';
            },
        	newProduct(){
                if (this.crearColor) {
                    let index = this.n_serie.indexOf("%");
                    var codigoColor = this.n_serie.substr((index+1),2);
                    var colorParam = this.color
                    var params= {
                        codigo: codigoColor,
                        color: colorParam
                    }
                    axios.post('/seriecolor',params).then((response)=>{
                        console.log('Color Creado');
                    })
                }
                var crearCategoria = true;
                var categoriaId;
                var parar = true

                var inicio = this.categoria.indexOf('(');

                var categoriaComparar = this.categoria.substring(0,inicio-1);
                if(inicio == -1){
                    categoriaComparar = this.categoria;
                } 
                var final = this.categoria.indexOf(')');
                
                var tipoComparar = this.categoria.substring(inicio+1,final);

                console.log('Categoria Comparar: ' + categoriaComparar);
                console.log('Tipo Comparar: ' + tipoComparar);
                for(var categoria of this.categorias){
                    if(categoriaComparar == categoria.nombre && parar){
                        if(categoria.tipo == this.tipo){
                            crearCategoria = false;
                            categoriaId = categoria.id;
                            parar = false;
                        }
                    }
                }
                if(crearCategoria){
                    let params= {
                        nombre: this.categoria,
                        tipo: this.tipo
                    }
                    let index = this.n_serie.indexOf("%");
                    let serie = this.n_serie.slice(0, index);

                    var nombre = this.nombre;
                    var talle = this.talle;
                    var color = this.color;
                    var costo = this.costo;
                    var precio = this.precio;
                    var n_serie = serie;

                    axios.post('/categorias',params).then((response)=>{
                        let index = this.n_serie.indexOf("%");
                        let serie = this.n_serie.slice(0, index);
                        const params2 = {
                            nombre : nombre,               
                            categoria_id: response.data.id,
                            talle: talle,
                            color: color,
                            costo: costo,
                            precio: precio,
                            n_serie: n_serie,
                            enabled: 1,
                            estado: 'Inventario',
                            cantidadProducts: this.cantidad
                        }

                            axios.post('/products', params2)
                                    .then((response)=>{
                                        console.log(response);
                                        
                            });

                        this.$emit('new');
                        this.$toasted.show('Producto Cargado Exitosamente', { 
                            theme: "toasted-primary", 
                            position: "top-right", 
                            duration : 2000
                        });
                    })
                } else {
                    let index = this.n_serie.indexOf("%");
                    let serie = this.n_serie.slice(0, index);

                    var nombre = this.nombre;
                    var talle = this.talle;
                    var color = this.color;
                    var costo = this.costo;
                    var precio = this.precio;
                    var n_serie = serie;
                    const params = {
                        nombre : nombre,               
                        categoria_id: categoriaId,
                        talle: talle,
                        color: color,
                        costo: costo,
                        precio: precio,
                        n_serie: n_serie,
                        enabled: 1,
                        estado: 'Inventario',
                        cantidadProducts: this.cantidad
                    };

                        axios.post('/products', params)
                                .then((response)=>{
                                    console.log(response);
                                    
                        });

                    this.$emit('new');
                    this.$toasted.show('Producto Cargado Exitosamente', { 
                        theme: "toasted-primary", 
                        position: "top-right", 
                        duration : 2000
                    });
                }
                
                
	            this.nombre= '';	              
                this.talle= '';
                this.color= '';
                this.costo= '';
                this.precio= '';
                this.n_serie= '';
                this.seleccionarCategoria= true;
    		},
            inputSerie(){
                this.tipo = '';
                let index = this.n_serie.indexOf("%");
                var codigoTemporada = this.n_serie.substr(0,3);
                var codigoCategoria = this.n_serie.substr(3,2);
                var codigoTalle= this.n_serie.substr(index+3);
                var codigoColor = this.n_serie.substr((index+1),2);
                console.log('Temporada: '+ codigoTemporada); 
                console.log('Categoria: '+ codigoCategoria); 
                console.log('Color: '+ codigoColor); 
                console.log('Talle: '+ codigoTalle);

                this.categorias.forEach((elemento)=>{
                    if(elemento.tipo == 'Niño'){
                        this.sugerenciasList.push(elemento);
                    }
                })

                this.talle = codigoTalle;
                if(codigoTemporada.substr(0,1) == 'I'){
                    var temporada = 'Invierno 20' + codigoTemporada.substr(1,2);
                    this.nombre = temporada;
                }
                if(codigoTemporada.substr(0,1) == 'V'){
                    var temporada = 'Verano 20' + codigoTemporada.substr(1,2);
                    this.nombre = temporada;
                }
                if(codigoTemporada == 'CHK'){
                    var temporada = 'CHK';
                    this.nombre = temporada;
                }

                axios.get('seriecolor/'+codigoColor)
                .then((response)=>{
                    this.color = response.data;
                }).catch((err)=>{
                    console.log('No existe ese Color');
                    this.crearColor = true;
                })                    
            },
            busquedaCategoria(){
            console.log('busqueda');
              this.sugerenciasList = [];
              for(var categoria of this.categorias)
              {
                var nombre = categoria.nombre;

                if(nombre.startsWith(this.categoria)){
                    this.sugerenciasList.push(categoria);  
                }
              }
            },
            elegirTipo(e){
                if (this.clickCategoria){
                    console.log('elegir tipo');
                    this.clickCategoria = false;

                    var tipo = e.target.value;
                    this.sugerenciasList = [];
                    if(tipo == 'Niño'){
                        console.log('Categorias Niño');
                        this.categorias.forEach((elemento)=>{
                            if(elemento.tipo == 'Niño'){
                                this.sugerenciasList.push(elemento);
                                console.log(this.sugerenciasList);
                            }
                        })
                    } else if(tipo =='Niña'){
                        console.log('Categorias Niña');
                        this.categorias.forEach((elemento)=>{
                            if(elemento.tipo == 'Niña'){
                                this.sugerenciasList.push(elemento);
                                console.log(this.sugerenciasList);
                            }
                        })
                    } else if(tipo == 'Unisex'){
                        console.log('Categorias Unisex');
                        this.categorias.forEach((elemento)=>{
                            if(elemento.tipo == 'Unisex'){
                                this.sugerenciasList.push(elemento);
                                console.log(this.sugerenciasList);
                            }
                        })
                    }
                } else {
                    this.clickCategoria = true;
                    this.sugerenciasList = [];
                }
                
            },
            redondeoAumentar(){
                this.precio = 0
                var precioFinal = Math.ceil( ((parseInt(this.factor)/100)* parseInt(this.costo) )+parseInt(this.costo) );
                console.log(precioFinal);
                var numeroString = String(precioFinal);
                var ultimoDigito = numeroString.slice(-1);
                if(ultimoDigito == 1 ){
                    this.precio = precioFinal-1

                } else if(ultimoDigito == 2 ){
                    this.precio = precioFinal-2

                } else if(ultimoDigito == 3){
                    this.precio = precioFinal-3

                } else if(ultimoDigito == 4){
                    this.precio = precioFinal+1

                } else if(ultimoDigito == 6){
                    this.precio = precioFinal-1

                } else if(ultimoDigito == 7){
                    this.precio = precioFinal+3

                } else if(ultimoDigito == 8){
                    this.precio = precioFinal+2

                } else if(ultimoDigito == 9){
                    this.precio = precioFinal+1

                } else {
                    this.precio = precioFinal
               }
            },
            clickCrearNuevaCategoria(){
                if(this.seleccionarCategoria){
                    this.seleccionarCategoria = false;
                    this.categoria = '';   
                } else {
                    this.seleccionarCategoria = true;
                    this.categoria = '';
                }
            }
        }
    }
</script>

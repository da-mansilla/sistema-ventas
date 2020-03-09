<template>
    <div>
        <!-- Button trigger modal -->
        
        <!-- Modal-->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  

                <form  autocomplete="off">
                  <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="grupo">Seleccionar Por:</label>
                          <select id="grupo" class="form-control" v-on:click="seleccionarPor">
                            <option selected>Categoria</option>
                            <option>Producto</option>
                            <option>Todos</option>
                          </select>
                        </div>
                            <!-- Categoria -->
                            <div v-if="seleccionado==1" class="form-group col-md-3">
                              <label>Tipo</label>
                              <select class="form-control" v-on:click="elegirTipo" v-model="tipo">
                                <option selected value="Todos">Todos</option>
                                <option disabled>──────────────</option>
                                <option value="Niño">Niños</option>
                                <option value="Niña">Niñas</option>
                                <option value="Unisex">Unisex</option>
                              </select>
                            </div>
                            <div v-if="seleccionado==1" class="form-group col-md-3">
                              <label for="sub-grupo-categoria">Elegir</label>
                              <div class="input-group">
                                <!--
                                  <input type="text" class="form-control" id="sub-grupo-categoria" list="sugerenciasCategorias" v-model="categoriaElegida">
                                  <datalist id="sugerenciasCategorias" >
                                      <option v-for="sugerencia in listaElegida">{{sugerencia.nombre}} ({{sugerencia.tipo}})</option>
                                  </datalist>
                                -->
                                    <select class="form-control" id="sub-grupo-categoria" v-model="categoriaElegida">
                                        <option v-for="sugerencia in listaElegida" :value="sugerencia.id">{{sugerencia.nombre}} ({{sugerencia.tipo}})</option>
                                    </select>
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" v-on:click="cargarProductos"><i class="fas fa-plus"></i></button>
                                  </div>
                              </div>
                            </div>
                            <!-- Producto -->
                            <div v-if="seleccionado==2" class="form-group col-md-6">
                              <label for="sub-grupo-producto">N° Serie</label>
                              <input type="text" class="form-control" id="sub-grupo-producto" v-model="productoSerie" v-on:keydown.enter='inputSerie'>
                            </div>
                      </div>
                      <hr>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cambio">Aumentar/Disminuir</label>
                          <select id="cambio" class="form-control" v-on:click="elegirAccion">
                            <option selected value="aumentar">Aumentar</option>
                            <option value="disminuir">Disminuir</option>

                          </select>
                        </div>
                        <div class="form-group col-md-6 ">
                            <div class="form-check-label d-block">
                                <label for="cantidad">Cantidad</label>
                            </div>
                            <div class="input-group">
                              <input type="number" class="form-control " aria-label="Recipient's username" required id="cantidad" placeholder="10%" v-model="cantidad">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary" style="cursor: default;" type="button"><i class="fas fa-percentage"></i></button>
                              </div>
                            </div>
                        </div>
                      </div>

                      <hr>

                    <table class="table mt-0">
                      <thead>
                        <tr class=" table-primary">
                          <th scope="col"></th>
                          <th scope="col">N° Serie</th>
                          <th scope="col">Costo</th>
                          <th scope="col">Precio</th>
                          <th scope="col">Nuevo Precio</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(product,index) in productsModificar" :key="product.id">
                            <td><button  type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(index)"><i class="fas fa-times-circle"></i></button></td>
                            <td>{{product.n_serie}}</td>
                            <td>{{product.costo}}</td>
                            <td>{{product.precio}}</td>
                            <td v-if="accion == 'aumentar'"><strong>{{ redondeoAumentar(product.precio) }}</strong></td>
                            <td v-if="accion == 'disminuir'"><strong>{{ redondeoDisminuir(product.precio) }}</strong></td>
                        </tr>
                      </tbody>
                    </table>
                    <span v-if="productsModificar.length == 0">
                        <button type="button" disabled v-on:click="modificarPrecio" class="btn btn-primary">Modificar</button>
                    </span>
                    <span v-else>
                        <button type="button" v-on:click="modificarPrecio" class="btn btn-primary">Modificar</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            categorias: {},
            listStock: {}
        },
    	data(){
    		return {
                tipo: '',
                accion: 'aumentar',
                cantidad: 0,
                clickSeleccionar: false,
                seleccionado : 1,
                productoSerie: '',
                clickCategoria: false,
                clickAccion : false,
                clickCargar: false,
                listaElegida: [],
                categoriaElegida: '',
                productsModificar: [],
                nuevoPrecio: 0

    		}
    	},
        mounted() {
            $('#exampleModal2').on('hidden.bs.modal', this.cerrarModal);
        },
        methods: {
            cerrarModal(){
                this.productsModificar = [];
                this.listaElegida = [];
                this.seleccionado = 1;

            },
            getTodosProductos(){
                axios.get('todosproductos').then(response=>{

                })
            },
            seleccionarPor(e){
                if (this.clickSeleccionar){
                    this.clickSeleccionar = false;

                    var seleccionar = e.target.value;

                    console.log(seleccionar);
                    this.productsModificar = [];
                    if(seleccionar == 'Todos'){
                        this.seleccionado = 3;
                        axios.get('todosproductos').then(response=>{
                            response.data.forEach(element=>{
                                this.productsModificar.push(element);
                            })
                        })
                    }
                    if(seleccionar == 'Categoria'){
                        this.seleccionado = 1;
                    }
                    if(seleccionar == 'Producto'){
                        this.seleccionado = 2;
                    }
                } else {
                    this.clickSeleccionar = true;
                }

            },
            elegirTipo(e){
                if (this.clickCategoria){
                    this.clickCategoria = false;

                    var tipo = e.target.value;
                    this.listaElegida = [];
                    if(tipo == 'Niño'){
                        console.log('Categorias Niño');
                        axios.get('tipos/Niño').then(response=>{
                            response.data.forEach(element=>{
                                this.listaElegida.push(element);
                                console.log(this.listaElegida);
                            })
                        })
                    } else if(tipo =='Niña'){
                        console.log('Categorias Niña');
                        axios.get('tipos/Niña').then(response=>{
                            response.data.forEach(element=>{
                                this.listaElegida.push(element);
                                console.log(this.listaElegida);
                            })
                        })
                    } else if(tipo == 'Unisex'){
                        console.log('Categorias Unisex');
                        axios.get('tipos/Unisex').then(response=>{
                            response.data.forEach(element=>{
                                this.listaElegida.push(element);
                                console.log(this.listaElegida);
                            })
                        })
                    } else if(tipo == 'Todos'){
                        console.log('Todas Categorias');
                        this.categorias.forEach((elemento)=>{
                                this.listaElegida.push(elemento);
                                console.log(this.listaElegida);
                        })
                    }
                } else {
                    this.clickCategoria = true;
                    this.listaElegida = [];
                }
                
            },
            inputSerie(){
                console.log(this.productoSerie);
                let index = this.productoSerie.indexOf("%");
                let serie = this.productoSerie.slice(0, index);
                axios.get('buscarProducto/'+serie).then(response=>{
                    response.data.forEach(element=>{
                        this.productsModificar.push(element);
                        this.productoSerie = '';
                    })
                })
            },
            cargarProductos(){
                    console.log('Id de categoria '+ this.categoriaElegida)
                    this.productsModificar = [];
                    axios.get('productsporcategoria/'+this.categoriaElegida).then(response=>{
                        response.data.forEach(element=>{
                            this.productsModificar.push(element);
                        })
                        console.log('Productos a modificar');
                        console.log(this.productsModificar);
                    })

            },
            onClickDelete(index){
                this.productsModificar.splice(index,1);
            },
            elegirAccion(e){
                if (this.clickAccion){
                    this.clickAccion = false;

                    var tipo = e.target.value;

                    if(tipo == 'aumentar'){
                        this.accion = 'aumentar';
                    } else {
                        this.accion = 'disminuir';
                    }
                } else {
                    this.clickAccion = true;
                }
            },
            modificarPrecio(){
                this.productsModificar.forEach((elemento)=>{
                    var precioFinal
                    if(this.accion == 'aumentar'){
                        precioFinal = this.redondeoAumentar(elemento.costo);
                        console.log('El producto ' + elemento.id + ' de precio ' + elemento.precio+ ' se modificará a '+ precioFinal);
                    } else if(this.accion == 'disminuir'){
                        precioFinal = this.redondeoDisminuir(elemento.costo);
                        console.log('El producto ' + elemento.id + ' de precio ' + elemento.precio+ ' se modificará a '+ precioFinal);
                    }
                    let params= {
                        precio: precioFinal
                    }
                    axios.put('/precio/aumentar/'+elemento.id,params).then((response)=>{
                        this.$emit('updatePrecio');
                        console.log(response);
                        this.productsModificar= [];
                        this.cantidad = 0;
                        this.categoriaElegida = '';
                        this.tipo = '';
                        this.$toasted.show('Se actualizaron los precios exitosamente', { 
                            theme: "toasted-primary", 
                            position: "top-right", 
                            duration : 2000
                        });

                    })

                })
            },
            redondeoAumentar(costo){
                var precioFinal = Math.ceil( ((this.cantidad/100)* costo )+costo );
                var numeroString = String(precioFinal);
                var ultimoDigito = numeroString.slice(-1);
                if(ultimoDigito == 1 ){
                    return precioFinal-1

                } else if(ultimoDigito == 2 ){
                    return precioFinal-2

                } else if(ultimoDigito == 3){
                    return precioFinal-3

                } else if(ultimoDigito == 4){
                    return precioFinal-4

                } else if(ultimoDigito == 5){
                    return precioFinal+5

                } else if(ultimoDigito == 6){
                    return precioFinal+4

                } else if(ultimoDigito == 7){
                    return precioFinal+3

                } else if(ultimoDigito == 8){
                    return precioFinal+2

                } else if(ultimoDigito == 9){
                    return precioFinal+1

                } else {
                    return precioFinal
               }
            },
            redondeoDisminuir(costo){
                var precioFinal = Math.ceil( costo-((this.cantidad/100)* costo ) );
                var numeroString = String(precioFinal);
                var ultimoDigito = numeroString.slice(-1);
                if(ultimoDigito == 1 ){
                    return precioFinal-1

                } else if(ultimoDigito == 2 ){
                    return precioFinal-2

                } else if(ultimoDigito == 3){
                    return precioFinal-3

                } else if(ultimoDigito == 4){
                    return precioFinal-4

                } else if(ultimoDigito == 5){
                    return precioFinal+5

                } else if(ultimoDigito == 6){
                    return precioFinal+4

                } else if(ultimoDigito == 7){
                    return precioFinal+3

                } else if(ultimoDigito == 8){
                    return precioFinal+2

                } else if(ultimoDigito == 9){
                    return precioFinal+1

                } else {
                    return precioFinal
               }
            }
        }
    }
</script>

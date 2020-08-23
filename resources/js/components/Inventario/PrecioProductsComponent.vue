<template>
    <div>
        <!-- Button trigger modal -->
        
        <!-- Modal-->
        <div class="modal fade" id="ModalPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <option v-for="sugerencia in sortedArray" :value="sugerencia.id">{{sugerencia.nombre.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))}} ({{sugerencia.tipo}})</option>
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
                              <input type="number" class="form-control " required id="cantidad" placeholder="10%" v-model="cantidad"v-on:keyup="agregarPrecios">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary" style="cursor: default;" type="button"><i class="fas fa-percentage"></i></button>
                              </div>
                            </div>
                        </div>
                      </div>

                      <hr>

                    <table class="table mt-0">
                      <thead>
                        <tr class=" table-info">
                          <th scope="col"></th>
                          <th scope="col"><h5><strong>N° Serie</strong></h5></th>
                          <th scope="col"><h5><strong>Categoria</strong></h5></th>
                          <th scope="col"><h5><strong>Talle</strong></h5></th>
                          <th scope="col"><h5><strong>Color</strong></h5></th>
                          <th scope="col"><h5><strong>Precio</strong></h5></th>
                          <th scope="col"><h5><strong>Nuevo Precio</strong></h5></th>
                        </tr>
                      </thead>
                      <paginate ref="paginator" name="productsModificar" :list="productsModificar" :per="10" tag="tbody">
                        <tr v-for="(product,index) in paginated('productsModificar')" :key="product.id">
                            <td><button  v-if="!activateModificarCategoria"type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(index)"><i class="fas fa-times-circle"></i></button></td>
                            <td>{{product.n_serie}}</td>
                            <td v-if="activateModificarCategoria != product.id">
                                <button  type="button" class="btn btn-light" v-on:click="abrirModificarCategoria(product.id)" v-bind:class="{'btn-outline-success' : product.cambio}">{{product.categoria}}</button>
                            </td>
                            <td v-else>
                                <button  type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModificarCategoria"><i class="fas fa-times-circle"></i></button>
                                <button  type="button" class="btn btn-success btn-sm" v-on:click="modificarCategoria(product.id)"><i class="fas fa-times-circle"></i></button>
                                <select class="form-control" style="width: 100px; display: inline;" v-model="nuevaCategoria">
                                    <option v-for="sugerencia in sortedArrayCategorias" :value="sugerencia.id">{{sugerencia.nombre.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))}} ({{sugerencia.tipo}})</option>
                                </select>
                            </td>
                            <td>{{product.talle}}</td>
                            <td>{{product.color}}</td>
                            <td>{{product.precio}}</td>
                            <td v-if="accion == 'aumentar'" style="width: 100px;"><input  style="width: 100px;" :id="product.id" v-on:keyup="cambiarPrecioIndividual(product.id)" type="number" :value="product.nuevoPrecio"></td>
                            <td v-if="accion == 'disminuir'" style="width: 100px;"><input style="width: 100px;" :id="product.id" v-on:keyup="cambiarPrecioIndividual(product.id)" type="number" :value="product.nuevoPrecio"></td>
                        </tr>
                      </paginate>
                      
                    </table>
                    <div class="mb-3">
                        
                      <paginate-links class="justify-content-end" for="productsModificar" :simple="{prev: 'Atras',next: 'Siguiente'}" :async="true":classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                    <span v-if="$refs.paginator && productsModificar.length >0">
                          Mostrando {{$refs.paginator.pageItemsCount}} resultados
                    </span>
                    </div>

                    <div v-if="productsModificar.length == 0" class="d-flex justify-content-end">
                        <button type="button" disabled v-on:click="modificarPrecio" class="btn btn-primary ">Modificar</button>
                    </div>
                    <div v-else class="d-flex justify-content-end">
                        <button type="button" v-on:click="modificarPrecio" class="btn btn-primary">Modificar</button>
                    </div>
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
                paginate: ['productsModificar'],
                nuevoPrecio: 0,
                preciosModificar: [],
                precioIndividual: 0,
                activateModificarCategoria: false,
                nuevaCategoria: '',
                cambiarCategoria:[]

    		}
    	},
        mounted() {
            $('#ModalPrecio').on('hidden.bs.modal', this.cerrarModal);
        },
        methods: {
            cerrarModal(){
                this.productsModificar = [];
                this.listaElegida = [];
                this.seleccionado = 1;
                this.cambiarCategoria = [];
                this.activateModificarCategoria= false

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
                                element.nuevoPrecio = element.precio
                                this.productsModificar.push(element);
                                this.$refs.paginator.goToPage(1)
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
                            })
                        })
                    } else if(tipo =='Niña'){
                        console.log('Categorias Niña');
                        axios.get('tipos/Niña').then(response=>{
                            response.data.forEach(element=>{
                                this.listaElegida.push(element);
                            })
                        })
                    } else if(tipo == 'Unisex'){
                        console.log('Categorias Unisex');
                        axios.get('tipos/Unisex').then(response=>{
                            response.data.forEach(element=>{
                                this.listaElegida.push(element);
                            })
                        })
                    } else if(tipo == 'Todos'){
                        console.log('Todas Categorias');
                        this.categorias.forEach((elemento)=>{
                                this.listaElegida.push(elemento);
                        })
                    }
                } else {
                    this.clickCategoria = true;
                    this.listaElegida = [];
                }
                
            },
            inputSerie(){
                console.log(this.productoSerie);
                let numSerie = '';
                let index = this.productoSerie.indexOf("%");
                if(index == -1){
                  numSerie = this.productoSerie
                } else {
                  numSerie = this.productoSerie.substring(0,index);  
                }



                axios.get('productosPorSerie/'+numSerie).then(response=>{

                    response.data.forEach(element=>{
                        element.nuevoPrecio = element.precio
                        this.productsModificar.push(element);
                        this.productoSerie = '';
                    })
                    this.$refs.paginator.goToPage(1)
                })
            },
            cargarProductos(){
                    console.log('Id de categoria '+ this.categoriaElegida)
                    this.productsModificar = [];
                    axios.get('productsporcategoria/'+this.categoriaElegida).then(response=>{
                        response.data.forEach(element=>{
                            element.nuevoPrecio = element.precio
                            this.productsModificar.push(element);
                        })
                        console.log('Productos a modificar');
                        console.log(this.productsModificar);
                        this.productsModificar.forEach(producto=>{
                            this.preciosModificar.push(producto.precio);
                        })
                        this.agregarPrecios();
                        this.$refs.paginator.goToPage(1)
                    })

            },
            onClickDelete(index){
                let productoID = this.productsModificar[index].id
                this.productsModificar.splice(index,1);
                this.cambiarCategoria.forEach((product,i)=>{
                    if(product.producto.id == productoID){
                        this.cambiarCategoria.splice(i,1)
                    }
                })
                console.log(this.cambiarCategoria);
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
            async modificarPrecio(){
                let cantidadProductos=this.productsModificar.length
                var listaParam = [];
                this.productsModificar.forEach((elemento)=>{
                    var precioFinal
                    if(this.accion == 'aumentar'){
                        precioFinal = elemento.nuevoPrecio
                        console.log('El producto ' + elemento.id + ' de precio ' + elemento.precio+ ' se aumentara a '+ precioFinal);
                    } else if(this.accion == 'disminuir'){
                        precioFinal = elemento.nuevoPrecio
                        console.log('El producto ' + elemento.id + ' de precio ' + elemento.precio+ ' se disminuira a '+ precioFinal);
                    }
                    let productoCambiar = [elemento.id,precioFinal];
                    listaParam.push(productoCambiar);
                    
                    /*
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
                    })
                    */
                })
                let cantidadProductosCategoria = this.cambiarCategoria.length
                if(cantidadProductosCategoria > 0){
                    await axios.post('/modificarProductos', this.cambiarCategoria)
                    .then(response=>{
                        console.log(response)
                    })
                }
                await axios.put('/precio',listaParam)
                    .then((response)=>{
                        console.log(response);
                        this.$toasted.show('Se actualizaron los precios de '+cantidadProductos+' productos exitosamente', { 
                            theme: "toasted-primary", 
                            position: "top-right", 
                            duration : 2000
                        });
                        $("#ModalPrecio").modal('hide');
                    })
                    .catch(error =>{
                        console.log(error);
                })

                
                
            },
            agregarPrecios(){
                this.preciosModificar = [];
                this.productsModificar.forEach(product=>{
                    if(this.accion == 'aumentar'){
                        var precioFinal = this.redondeoAumentar(product.precio)

                    }
                    if(this.accion == 'disminuir'){
                        var precioFinal = this.redondeoDisminuir(product.precio)
                    }
                    product.nuevoPrecio = precioFinal
                })
                console.log(this.productsModificar);
            },
            cambiarPrecioIndividual(id){
                var precioingresado = $('#'+id).val()
                console.log(precioingresado)
                this.productsModificar.forEach((element,index)=>{
                    if(element.id == id){
                        console.log("El precio de este producto se va a modificar de "+ element.nuevoPrecio+" a "+precioingresado)
                        this.productsModificar[index].nuevoPrecio = parseInt(precioingresado)
                    }
                })
                console.log(this.preciosModificar);
                console.log(this.productsModificar);

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
            },
            abrirModificarCategoria(id){
                this.activateModificarCategoria = id;
            },
            modificarCategoria(id){
                var categoriaNueva= ''
                this.categorias.forEach(categoria=>{
                    if(categoria.id == this.nuevaCategoria){
                        categoriaNueva = categoria.nombre
                     }
                })
                console.log('El producto de id '+id+' se va a cambiar a la cateogoria '+this.nuevaCategoria)
                this.productsModificar.forEach((product,index)=>{
                    if(product.id == id && product.categoria_id != this.nuevaCategoria){
                        this.productsModificar[index].categoria = categoriaNueva
                        this.productsModificar[index].cambio = true
                        let param = {
                            producto: product,
                            categoria: this.nuevaCategoria,
                            cambio:'categoria'
                        }
                        this.cambiarCategoria.push(param)
                    }
                })
                this.activateModificarCategoria = false
                this.nuevaCategoria = ''
                console.log(this.cambiarCategoria);
            },
            cerrarModificarCategoria(){
                this.activateModificarCategoria = false;
                this.nuevaCategoria = ''
            }
        },
        computed: {
            sortedArray: function() {
                function compare(a, b) {
                  if (a.nombre.toLowerCase() < b.nombre.toLowerCase() )
                    return -1;
                  if (a.nombre.toLowerCase() > b.nombre.toLowerCase())
                    return 1;
                  return 0;
                }

                return this.listaElegida.sort(compare);
            },
            sortedArrayCategorias: function() {
                function compare(a, b) {
                  if (a.nombre.toLowerCase() < b.nombre.toLowerCase() )
                    return -1;
                  if (a.nombre.toLowerCase() > b.nombre.toLowerCase())
                    return 1;
                  return 0;
                }

                return this.categorias.sort(compare);
            }
        }
    }
</script>
<style>
ul.paginate-links:{
    float: right
}
</style>
@extends('layouts.app')

@section('content')

    <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    @include('includes.sidebar')
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <template v-if="menu==0">
        <sectionhome-component></sectionhome-component>            
    </template>
    <template v-if="menu==1">
        <sectionventas-component></sectionventas-component>            
    </template>
    <template v-if="menu==2">
        <sectionproducts-component></sectionproducts-component>            
    </template>
    <template v-if="menu==3">
        <sectionclientes-component></sectionclientes-component>            
    </template>
    <template v-if="menu==4">
            <sectionproveedores-component></sectionproveedores-component>            
    </template>
    <template v-if="menu==5">
            <informacionsection-component></informacionsection-component>            
    </template>

    <!-- /#page-content-wrapper -->
  </div>


@endsection

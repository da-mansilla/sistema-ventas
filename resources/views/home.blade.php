@extends('layouts.app')

@section('content')
    
    <!-- Sidebar -->
    @include('includes.sidebar')
    <!-- /#sidebar-wrapper -->

    

    <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content"> 

                <!-- Topbar -->
                
                <!-- endTopBar -->  

                <!-- Page Content -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <template v-if="menu==100">
                        <sectionhome-component></sectionhome-component>            
                    </template>
                    <template v-if="menu==1">
                        <sectionventas-component></sectionventas-component>            
                    </template>
                    <template v-if="menu==2">
                            <preciosection-component></preciosection-component>            
                    </template>
                    <template v-if="menu==3">
                        <sectionproducts-component></sectionproducts-component>            
                    </template>
                    <template v-if="menu==4">
                            <informacionsection-component></informacionsection-component>            
                    </template>
                    <template v-if="menu==99">
                        <sectionclientes-component></sectionclientes-component>            
                    </template>
                    <template v-if="menu==98">
                            <sectionproveedores-component></sectionproveedores-component>            
                    </template>
                </div>
                <!-- /#page-content-wrapper -->
            </div>
        </div>

@endsection

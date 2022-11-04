<script>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Navbar from './Navbar.vue';
import SidebarMenu from './SidebarMenu.vue';

export default {
    name: 'AuthenticatedLayout',
    components: {
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        NavLink,
        ResponsiveNavLink,
        Navbar,
        Link,
        SidebarMenu,
    },
    setup() {
        const showMenu = ref(false);
        const showingNavigationDropdown = ref(false);
        const logout = () => {
            Inertia.post('/logout');
        };
        return {
            showMenu,
            logout,
        };
    },
};
</script>

<template>
    <div class="wrapper">

        <!-- Preloader -->
        <!--
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>
        -->

        <!-- Navbar -->
        <Navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <SidebarMenu />
        <!-- sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid p-5">
                    <slot></slot>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
</template>

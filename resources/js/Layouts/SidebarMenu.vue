<script>
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
export default {
    name: 'SidebarMenu',
    components: {
        NavLink,
        ResponsiveNavLink
    },
    data() {
        return {
            // ...
        }
    }
}
</script>
<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar bg-white elevation-4 h-screen">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link d-flex justify-center bg-blue-500 border-b-4 border-blue-700">
            <img src="https://habbofont.net/font/habjoy/hospeda+p.gif" alt="AdminLTE Logo">
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="mb-4">
                <div class="mt-5 pb-3 mb-3 border-b-2 border-white d-flex justify-center items-center">
                    <div class="rounded-full w-20 h-20 bg-blue-400 d-flex justify-center items-center">
                        <img src="https://pbs.twimg.com/media/Eatx0NoXkAIWUDi.png" alt="User Image"
                            class="object-cover">
                    </div>
                </div>
                <div class="info text-center">
                    <a href="#" class="d-block text-black hover:text-black font-bold">{{
                            $page.props.auth.user.name
                    }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <div class="nav-link hover:bg-gray-200 bg-gray-100 mb-3">
                                <p class="text-black d-flex justify-start items-center">
                                    <i class="nav-icon fas fa-home"></i>
                                    Dashboard
                                </p>
                            </div>
                        </ResponsiveNavLink>
                    </li>
                    <li class="nav-item">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <div class="nav-link hover:bg-gray-200 bg-gray-100 mb-3">
                                <p class="text-black d-flex justify-start items-center">
                                    <i class="nav-icon fas fa-file-code" aria-hidden="true"></i>
                                    Arquivos
                                </p>
                            </div>
                        </ResponsiveNavLink>
                    </li>
                    <li class="nav-item">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <div class="nav-link hover:bg-gray-200 bg-gray-100 mb-3">
                                <p class="text-black d-flex justify-start items-center">
                                    <i class="nav-icon fas fa-cog" aria-hidden="true"></i>
                                    Gerenciar
                                </p>
                            </div>
                        </ResponsiveNavLink>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
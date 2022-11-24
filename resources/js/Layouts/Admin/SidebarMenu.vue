<script>
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
export default {
    inheritAttrs: true,
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
    <aside class=" bg-white elevation-4 min-h-fit" v-bind="$attrs">
        <!-- Brand Logo -->
        <div class="h-full">
            <a href="index3.html" class="brand-link bg-black border-b-4 border-gray-900">

                <div class="mt-2 pb-3 mb-2 d-flex justify-center items-center">
                    <div class="rounded-full w-20 h-20 bg-white d-flex justify-center items-center p-3">
                        <img src="/dist/img/user.png" alt="User Image" class="object-cover">
                    </div>
                </div>
                <div class="info text-center">
                    <a href="#" class="d-block text-white hover:text-white font-normal text-md">{{
                            $page.props.auth.user.name
                    }}</a>
                </div>
            </a>

            <!-- Sidebar -->
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column p-2" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <ResponsiveNavLink :href="route('admin.dashboard')"
                            :active="route().current('admin.dashboard')">
                            <i class="nav-icon fas fa-home"></i>
                            Dashboard
                        </ResponsiveNavLink>
                    </li>

                    <li class="nav-item">
                        <ResponsiveNavLink :href="route('admin.portal')" :active="route().current('admin.portal')">
                            <i class="nav-icon fas fa-cog" aria-hidden="true"></i> Portal
                        </ResponsiveNavLink>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            <!-- /.sidebar -->
        </div>
    </aside>
</template>
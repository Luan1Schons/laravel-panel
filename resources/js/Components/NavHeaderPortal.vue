<script>

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link, useForm
    },
    data() {
        return {

        }
    }
}
</script>
<template>
    <div class="bg-red-500 p-2 text-center hover:cursor-pointer">
        <a href="#boosts">
            <p class="text-white font-bold">CLIQUE AQUI PARA CONHECER OS MELHORES HABBOS DO BRASIL</p>
        </a>
    </div>
    <nav class="flex items-center flex-wrap bg-black p-6">

        <div class="flex justify-start items-center w-4/12">
            <div class="flex items-center flex-shrink-0 bg-white">
                <span class="font-semibold text-xl tracking-tight">Black</span>
            </div>
            <div class="flex items-center justify-start text-white w-4/12">
                <span class="font-semibold text-xl tracking-tight">Habbos</span>
            </div>
        </div>

        <div class="flex justify-center items-center w-4/12">
            <Link :href="route('welcome')" class="blocklg:inline-block lg:mt-0 text-white hover:text-white mr-4">
                Habbos
            </Link>
            <Link :href="route('portal.comprar.habbo')"
                class="flex gap-2 lg:mt-0 text-black hover:text-black mr-4 bg-white px-2 py-0.5 rounded-md items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                stroke="currentColor" class="w-6 h-6">
                <path strokeLinecap="round" strokeLinejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
            Comprar Habbo
            </Link>
            <!--
            <a href="#responsive-header" class="block lg:inline-block lg:mt-0 text-white hover:text-white">
                Servidor VPS
            </a>
            -->
        </div>

        <div class="w-3/12 flex justify-end items-center">
            <Link :href="route('admin.dashboard')"
                v-if="$page.props.auth.user && $page.props.auth.user.roles.find(r => r.name == 'admin')"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-gray-900 lg:mt-0">
            Administração</Link>
            <Link :href="route('dashboard')"
                v-if="$page.props.auth.user && $page.props.auth.user.roles.find(r => r.name == 'user')"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-gray-900 lg:mt-0">
            Área
            do Usuário</Link>

            <Link :href="route('habbo.dashboard')"
                v-if="$page.props.auth.user && $page.props.auth.user.roles.find(r => r.name == 'habbo')"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-gray-900 lg:mt-0">
            Painel do emulador</Link>

            <Link :href="route('login')" v-if="!$page.props.auth.user"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-gray-900 lg:mt-0">
            Login / Registro</Link>
        </div>
    </nav>
</template>
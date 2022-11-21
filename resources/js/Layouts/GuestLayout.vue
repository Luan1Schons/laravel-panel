<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen d-flex flex-wrap sm:justify-center items-center sm:pt-0 bg-black">
        <div class="col-12 md:col-md-6">
            <ApplicationLogo class="mb-2 fill-current text-gray-500 text-center" />
            <div class="d-flex justify-center items-center mx-5">
                <div class="w-full d-flex justify-center items-center">
                    
                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">   
     
                        <slot />

                    </div>
                </div>
            </div>
        </div>

       
    </div>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';
import { useToast } from "vue-toastification";
import NavHeaderPortal from '@/Components/NavHeaderPortal.vue';
const toast = useToast();

export default {
    name: 'Comprar Habbo',
    components: {
        Head,
        Link,
        useForm,
        NavHeaderPortal,
    },
    data() {
        return {
            modalHabbo: false,
        }
    },
    created: function () {

    },
    methods: {

    }
}
</script>
<template>
    <NavHeaderPortal />
    <section class="h-full box-border flex justify-center pt-5 bg-gray-100">

        <div class="w-8/12">

            <div class="slider mb-10">
                <div class="bg-orange-200 relative rounded-2xl">
                    <img src="http://images.habbo.com/c_images/DEV_tests/floor_02_cp.png" class="object-cover">
                    <div class="text-white bg-black p-2 relative rounded-b-2xl">
                        <p class="font-bold text-2xl text-white opacity-100">
                            BlackHabbos Especialista na criação de hotéis de última geração
                        </p>
                        <p class="font-bold">BlackHabbos chegou!</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-5 items-center">
                <div class="bg-black rounded-md w-3/12 p-3">
                    <h3 class="text-md font-bold text-center">Segurança</h3>
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-14 h-14">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-black rounded-md w-3/12 p-3">
                    <h3 class="text-md font-bold text-center">Qualidade</h3>
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-14 h-14">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-black rounded-md w-3/12 p-3">
                    <h3 class="text-md font-bold text-center">Desempenho</h3>
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-14 h-14">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-black rounded-md w-3/12 p-3">
                    <h3 class="text-md font-bold text-center">Suporte</h3>
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-14 h-14">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="bg-gray-200 my-5 mb-5">
                <div class="p-4">
                    <h3 class="font-bold text-lg">Oque é Black Habbos?</h3>
                    <p>A Black Habbos é feita de pessoas comprometidas com a qualidade dos serviços prestados,
                        Procuramos em sempre melhorar diariamente em todos os aspectos.
                        é por isso que na Black Habbos criamos nossos próprios serviços para proporcionar sempre o
                        melhor para nossos clientes.
                    </p>
                    <br>
                    <p><b>Nosso propósito</b></p>
                    <p>Procuramos crescer a qualidade dos nossos serviços juntamente com os nossos clientes, Aprimorar o
                        nosso portal para ajudar nossos clientes a terem mais usuário e destaque.</p>
                    <br>
                    <p><b>Benefícios que só a Black proporciona:</b></p>
                    <br>
                    <div class="flex justify-center items-center gap-3">
                        <div class="w-4/12">
                            <div class="card">
                                <div class="card-body text-center">

                                    <div class="flex justify-center mb-2">
                                        <div class="bg-black rounded-full w-12 h-12 flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor" class="w-8 h-8">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                            </svg>
                                        </div>
                                    </div>

                                    <p class="text-black">PORTAL DE DIVULGAÇÃO</p>
                                </div>
                            </div>
                        </div>

                        <div class="w-4/12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flex justify-center mb-2">
                                        <div class="bg-black rounded-full w-12 h-12 flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor" class="w-8 h-8">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-black">EQUIPE ESPECIALIZADA</p>
                                </div>
                            </div>
                        </div>

                        <div class="w-4/12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flex justify-center mb-2">
                                        <div class="bg-black rounded-full w-12 h-12 flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor" class="w-8 h-8">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-black">EQUIPE PARA PACK PRÓPRIO</p>
                                </div>
                            </div>
                        </div>

                        <div class="w-4/12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flex justify-center mb-2">
                                        <div class="bg-black rounded-full w-12 h-12 flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor" class="w-8 h-8">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M12.75 19.5v-.75a7.5 7.5 0 00-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-black">MAIOR REDE DE HOTÉIS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" p-3 mb-5">
                <h3 class="font-bold text-lg text-black">Nossos planos</h3>
                <div class="bg-red-500 rounded-md mt-2 px-2">
                    <p class="text-white">Todos os planos incluem uma taxa de configuração de <b>R$45,00</b> que só é
                        paga no <b>primeiro mês</b>.</p>
                </div>
                <div class="row items-center mt-5">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <p class="text-black font-bold">Plano I</p>
                                <span class="bg-red-500 absolute right-2 -top-5 px-3 py-0.5 rounded-md">
                                    <p class="text-white font-bold">PROMO</p>
                                </span>
                            </div>
                            <div class="card-body">
                                <ul class="text-black ">
                                    <li> - 512MB de Memória Ram</li>
                                    <li>- Hotel Atualizado</li>
                                    <li> - 15GB SSD NVME de espaço</li>
                                    <li> - Acesso FTP</li>
                                    <li> - Painel de Controle</li>
                                    <li> - Suporte 24/7</li>
                                </ul>
                                <div class="border-t-2">
                                    <div class="mt-2 flex justify-between">
                                        <span class="text-black font-bold">
                                            <p>MENSAL</p>
                                        </span>
                                        <span class="text-black font-bold">
                                            <p>R$45,00</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <p class="text-black font-bold">Plano II</p>
                                <span class="bg-red-500 absolute right-2 -top-5 px-3 py-0.5 rounded-md">
                                    <p class="text-white font-bold">PROMO</p>
                                </span>
                            </div>
                            <div class="card-body">
                                <ul class="text-black ">
                                    <li> - 2048MB de Memória Ram</li>
                                    <li>- Hotel Atualizado</li>
                                    <li> - 40GB SSD NVME de espaço</li>
                                    <li> - Acesso FTP</li>
                                    <li> - Painel de Controle</li>
                                    <li> - Suporte 24/7</li>
                                </ul>
                                <div class="border-t-2">
                                    <div class="mt-2 flex justify-between">
                                        <span class="text-black font-bold">
                                            <p>MENSAL</p>
                                        </span>
                                        <span class="text-black font-bold">
                                            <p>R$65,00</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <p class="text-black font-bold">Plano III</p>
                                <span class="bg-red-500 absolute right-2 -top-5 px-3 py-0.5 rounded-md">
                                    <p class="text-white font-bold">PROMO</p>
                                </span>
                            </div>
                            <div class="card-body">
                                <ul class="text-black ">
                                    <li> - 4048MB de Memória Ram</li>
                                    <li>- Hotel Atualizado</li>
                                    <li> - 40GB SSD NVME de espaço</li>
                                    <li> - Acesso FTP</li>
                                    <li> - Painel de Controle</li>
                                    <li> - Suporte 24/7</li>
                                </ul>
                                <div class="border-t-2">
                                    <div class="mt-2 flex justify-between">
                                        <span class="text-black font-bold">
                                            <p>MENSAL</p>
                                        </span>
                                        <span class="text-black font-bold">
                                            <p>R$85,00</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <p class="text-black font-bold">Hotel Parceiro</p>
                                <span class="bg-green-500 absolute right-2 -top-5 px-3 py-0.5 rounded-md">
                                    <p class="text-white font-bold">QUALIDADE</p>
                                </span>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-6 p-4">
                                        <ul class="text-black">
                                            <li> - Memória Ram & Disco Escalável</li>
                                            <li> - Hotel Atualizado</li>
                                            <li> - Domínio próprio e CloudFlare configurados</li>
                                            <li> - Proteção avançada</li>
                                            <li> - Destaque no Portal</li>
                                            <li> - Boost no Portal Diário</li>
                                            <li> - Divulgação destacada no chat</li>
                                            <li> - Tag VIP no chat</li>
                                            <li> - Contato com programadores</li>
                                            <li> - Painel de Controle Avançado</li>
                                            <li> - Suporte em tudo</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="https://cdn.habtium.es/habtium/album/7/886fec70aa35.png" class="tr" />
                                    </div>
                                </div>
                                <div class="border-t-2">
                                    <div class="mt-2 flex justify-between p-4">
                                        <span class="text-black font-bold">
                                            <p>MENSAL</p>
                                        </span>
                                        <span class="text-white px-3 py-0.5 font-bold bg-black rounded-md">
                                            <p>R$185,00</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        <div classs="card">
                            <div class="card-body">
                                <p>Descobriu qual plano vai comprar?, entre em contato com nossos vendedores agora
                                    mesmo!</p>
                                <br>
                                <div class="flex justify-end">
                                    <a href="https://wa.me/5551983188147" class="bg-green-500 text-white rounded-md px-10 py-0.5 font-bold">ENTRAR
                                        EM CONTATO</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <footer class="bg-black py-8 flex justify-center">
        <p>@ BlackHabbos 2022 | Developer: LuanSP12</p>
    </footer>
</template>
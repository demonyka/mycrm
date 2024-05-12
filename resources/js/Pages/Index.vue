<template>
    <Head title="Главная"/>
    <Sidebar :links="links">

    </Sidebar>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
export default {
    name: "Index",
    components: {
        Sidebar,
        Head
    },
    data() {
        return {

        }
    }
}
</script>

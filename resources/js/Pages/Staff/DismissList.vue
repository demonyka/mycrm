<template>
    <Head title="Уволенные сотрудники"/>
    <Sidebar :links="links">
        <StaffTable :users="users"/>
    </Sidebar>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import {VueAwesomePaginate} from "vue-awesome-paginate";
import StaffTable from "@/Pages/Staff/Elements/StaffTable.vue";
export default {
    name: "Index",
    components: {
        StaffTable,
        VueAwesomePaginate,
        Sidebar,
        Head
    },
    data() {
        return {}
    },
    props: [
        'users',
        'links'
    ],
    methods: {

    },

}
</script>

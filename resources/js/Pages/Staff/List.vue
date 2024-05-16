<template>
    <Head title="Сотрудники"/>
    <Sidebar :links="links">
        <div v-if="$page.props.auth.user.permissions.includes('staff.create')" style="margin-bottom: 20px">
            <button v-if="$page.props.auth.user.permissions.includes('staff.create')" class="primary" @click="$inertia.visit(route('staff.view.create'))">Добавить сотрудника</button>
        </div>
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

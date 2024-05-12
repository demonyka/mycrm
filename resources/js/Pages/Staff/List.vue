<template>
    <Head title="Сотрудники"/>
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
            links: [
                {
                    name: 'Все сотрудники',
                    href: route('staff.view.list'),
                    is_active: true
                },
                {
                    name: 'Уволенные сотрудники',
                    href: '',
                    is_active: false
                },
            ]
        }
    }
}
</script>

<template>
    <Head :title="`Редактирование шаблона «${template.name}»`"/>
    <Sidebar :links="links">

    </Sidebar>
</template>

<style scoped>

</style>

<script>
import {Head, Link} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
export default {
    name: "TemplateEdit",
    components: {
        Sidebar,
        Head, Link
    },
    props: [
        'links',
        'template'
    ]
}
</script>

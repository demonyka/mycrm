<template>
    <Head :title="user.fullname"/>
    <Sidebar :links="links">
        <Center>
            <Block>

            </Block>
        </Center>
    </Sidebar>
</template>

<style scoped>

</style>

<script>
import {Head, useForm} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import {VueAwesomePaginate} from "vue-awesome-paginate";
import Block from "@/Layouts/Block.vue";
import Center from "@/Layouts/Center.vue";
export default {
    name: "User",
    components: {
        Center,
        Block,
        VueAwesomePaginate,
        Sidebar,
        Head
    },
    data() {
        return {
            form: useForm({
                _token: this.$page.props.csrf_token,
                username: '',
                password: ''
            }),
            isPasswordShow: false
        }
    },
    props: [
        'links',
        'user'
    ],
    methods: {

    }
}
</script>

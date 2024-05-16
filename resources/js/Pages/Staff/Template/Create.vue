<template>
    <Head title="Новый шаблон"/>
    <Sidebar :links="links">
        <Center>
            <Block>
                <h3 class="title">Новый шаблон</h3>
                <form @submit.prevent="formSubmit" class="validation">
                    <div class="form-input">
                        <input
                            v-model="form.name"
                            required
                            placeholder="Название шаблона"
                            :class="{'error': form.errors.name}"
                            @focus="form.errors.name = null"
                        >
                    </div>
                    <transition name="fade">
                        <p v-if="form.errors.name" class="error">{{ form.errors.name }}</p>
                    </transition>
                    <button class="primary" type="submit">Создать</button>
                </form>
            </Block>
        </Center>
    </Sidebar>
</template>

<style scoped>

</style>

<script>
import {Head, useForm} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import Block from "@/Layouts/Block.vue";
import Center from "@/Layouts/Center.vue";
export default {
    name: "TemplateCreate",
    components: {
        Center,
        Block,
        Sidebar,
        Head
    },
    data() {
        return {
            form: useForm({
                _token: this.$page.props.csrf_token,
                name: '',
            }),
        }
    },
    props: [
        'links'
    ],
    methods: {
        formSubmit() {
            this.form.post(route('staff.template.create'), {});
        },
    }
}
</script>

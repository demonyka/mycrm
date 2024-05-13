<template>
    <Head title="Авторизация"/>
    <Center>
        <Block>
            <LogoTitle title="Login"/>
            <form @submit.prevent="formSubmit" class="validation">
                <div class="form-input">
                    <input
                        v-model="form.username"
                        required
                        placeholder="Имя пользователя"
                        :class="{'error': form.errors.username}"
                        @focus="form.errors.username = null"
                    >
                </div>
                <div class="form-input">
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        placeholder="Пароль"
                        :class="{'error': form.errors.password}"
                        @focus="form.errors.password = null"
                    >
                </div>
                <button class="primary" type="submit">Войти</button>
                <transition name="fade">
                    <p v-if="form.errors.password ?? form.errors.username" class="error">{{ form.errors.password || form.errors.username }}</p>
                </transition>
            </form>
        </Block>
    </Center>
</template>

<script>
import {Head, useForm} from "@inertiajs/vue3";
import Center from "@/Layouts/Center.vue";
import Block from "@/Layouts/Block.vue";
import LogoTitle from "@/Elements/LogoTitle.vue";
export default {
    name: "Login",
    components: {
        LogoTitle,
        Block,
        Center,
        Head
    },
    data() {
        return {
            form: useForm({
                _token: this.$page.props.csrf_token,
                username: '',
                password: ''
            })
        }
    },
    methods: {
        formSubmit() {
            this.form.post(route('auth.login.store'), {
                onError: () => this.form.reset('password'),
            });
        },
    }
}
</script>

<style scoped>

</style>

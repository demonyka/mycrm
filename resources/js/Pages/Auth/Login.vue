<template>
    <Head title="Авторизация"/>
    <Center>
        <Block>
            <LogoTitle title="Login"/>
            <form @submit.prevent="formSubmit" class="validation">
                <div class="form-input">
                    <input
                        v-model="form.login"
                        required
                        placeholder="Логин"
                        :class="{'error': form.errors.login}"
                        @focus="form.errors.login = null"
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
                    <p v-if="form.errors.password ?? form.errors.login" class="error">{{ form.errors.password || form.errors.login }}</p>
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
                login: '',
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
    form.validation {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        position: relative;
        width: 300px;
        div.form-input {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
            position: relative;
            width: 100%;
            input {
                border: 1px solid var(--gray4);
                border-radius: 15px;
                padding: 10px 20px;
                outline: none;
                position: relative;
                width: 100%;
            }
            input:focus {
                border-color: var(--blue1);
            }
        }
    }
</style>

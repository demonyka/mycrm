<template>
    <Head title="Авторизация"/>
    <Center>
        <Block>
            <LogoTitle title="Login"/>
            <div class="user-info">
                <h4 v-if="$page.props.user" class="title">С возращением, {{ $page.props.user.firstname }}</h4>
                <img class="user-avatar" v-if="user" :alt="user.username"
                     :src="user.avatar_path ? user.avatar_path : '/assets/images/default_avatar.png'"
                     @error="$event.target.src = '/assets/images/default_avatar.png'">
            </div>
            <form @submit.prevent="formSubmit" class="validation">
                <div v-if="!$page.props.user" class="form-input">
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
                        :type="isPasswordShow ? 'text' : 'password'"
                        required
                        placeholder="Пароль"
                        :class="{'error': form.errors.password}"
                        @focus="form.errors.password = null"
                    >
                    <svg v-if="!isPasswordShow" @click="isPasswordShow = true" class="password-show" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <svg v-else @click="isPasswordShow = false" class="password-show active" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <button class="primary" type="submit">Войти</button>
                <transition name="fade">
                    <p v-if="form.errors.password ?? form.errors.username" class="error">{{ form.errors.password || form.errors.username }}</p>
                </transition>
                <a v-if="$page.props.user" @click="deleteCookie('user_id')">Войти в другой аккаунт</a>
            </form>
        </Block>
    </Center>
</template>

<script>
import {Head, useForm, Link} from "@inertiajs/vue3";
import Center from "@/Layouts/Center.vue";
import Block from "@/Layouts/Block.vue";
import LogoTitle from "@/Elements/LogoTitle.vue";
export default {
    name: "Login",
    components: {
        LogoTitle,
        Link,
        Block,
        Center,
        Head
    },
    data() {
        return {
            form: useForm({
                _token: this.$page.props.csrf_token,
                username: this.$page.props.user && this.$page.props.user.username || '',
                password: ''
            }),
            isPasswordShow: false,
        }
    },
    props: [
        'user'
    ],
    methods: {
        formSubmit() {
            this.form.post(route('auth.login.store'), {
                onError: () => this.form.reset('password'),
            });
        },
        deleteCookie(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            location.reload();
        }
    }
}
</script>

<style scoped>
    .user-info {
        display: flex;
        align-items: center;
        gap: 5px;
        img.user-avatar {
            width: 24px;
            height: 24px;
            object-fit: cover;
            border-radius: 100%;
        }
    }
</style>

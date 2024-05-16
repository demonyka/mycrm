<template>
    <Head :title="`Редактирование сотрудника «${user.fullname}»`"/>
    <Sidebar :links="links">
        <Center>
            <Block class="block">
                <img class="avatar" :alt="user.username"
                     :src="user.tpl_data && JSON.parse(user.tpl_data).avatar_path ? JSON.parse(user.tpl_data).avatar_path : '/assets/images/default_avatar.png'"
                     @error="$event.target.src = '/assets/images/default_avatar.png'"
                     loading="eager">
                <div class="fullname">
                    <h2 class="title">{{ user.fullname }}</h2>
                    <span v-if="user.status !== 'active'" style="color: var(--red); font-size: 14px">Сотрудник уволен или удалён</span>
                </div>
                <form @submit.prevent="formMainSubmit" class="userdata">
                    <div class="info-line">
                        <label>Логин: </label>
                        <div class="holder">{{ user.username || 'Отсутствует' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Пароль: </label>
                        <div class="holder">
                            <input
                                type="password"
                                v-model="formMain.password"
                                :class="{ 'error': formMain.errors.password }"
                            >
                        </div>
                    </div>
                    <div class="info-line">
                        <label>Аватар: </label>
                        <div class="holder">
                            <input
                                type="file"
                                accept="image/png, image/jpeg"
                                ref="avatarInput"
                                :class="{ 'error': formMain.errors.avatar }"
                                @change="handleAvatarChange"
                            >
                        </div>
                    </div>
                    <button type="submit" style="margin-top: 10px" class="primary">Сохранить</button>
                    <transition-group name="fade">
                        <p class="error" style="margin-top: 10px" v-if="formMain.errors && formMain.errors.avatar">
                            {{ formMain.errors.avatar }}
                        </p>
                        <p class="error" style="margin-top: 10px" v-if="formMain.errors && formMain.errors.password">
                            {{ formMain.errors.password }}
                        </p>
                        <p class="success" style="margin-top: 10px" v-if="formMain.success">
                            {{ formMain.success }}
                        </p>
                    </transition-group>
                </form>
            </Block>
        </Center>
        <Center style="margin-top: 20px">
            <Block class="block">

            </Block>
        </Center>
    </Sidebar>
</template>

<style scoped>
    @media screen and (max-width: 1000px) {
        img.avatar {
            width: 100px !important;
            height: 100px !important;
        }
        .block {
            width: 100% !important;
        }
        .info-line {
            * {
                font-size: 10px !important;
            }
        }
    }
    .block {
        width: 40%;
    }
    img.avatar {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 100%;
    }
    .fullname {
        gap: 5px;
        align-items: center;
        display: flex;
        flex-direction: column;
        * {
            width: 100%;
        }
    }
    .userdata {
        width: 100%;
    }
    .info-line {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        position: relative;
        label {
            color: var(--gray3);
            font-size: 16px;
            width: 45%;
            text-align: right;
        }
        div.holder {
            font-size: 16px;
            width: 55%;
            margin-left: 20px;
            display: flex;
            text-align: left;
            input[type=password] {
                outline: none;
                border: 1px solid var(--gray4);
                padding: 5px 10px;
                border-radius: 5px;
            }
            input:focus {
                border-color: var(--blue1);
            }
        }
    }
    .empty {
        font-style: italic;
        color: var(--gray4);
        font-weight: 500;
    }
</style>

<script>
import {Head, useForm} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import Block from "@/Layouts/Block.vue";
import Center from "@/Layouts/Center.vue";
export default {
    name: "User",
    components: {
        Center,
        Block,
        Sidebar,
        Head
    },
    data() {
        return {
            tplData: this.user.tpl_data ? JSON.parse(this.user.tpl_data) : {},
            formMain: useForm({
                _token: this.$page.props.csrf_token,
                avatar: null,
                password: ''
            })
        }
    },
    props: [
        'links',
        'user'
    ],
    methods: {
        handleAvatarChange(event) {
            const file = event.target.files[0];
            if (file.size > 10 * 1024 * 1024) {
                this.formMain.errors.avatar = 'Слишком большой файл';
                return;
            }
            this.formMain.avatar = file;
        },
        formMainSubmit() {
            this.formMain.post(route('staff.edit.main', {id: this.user.id}), {
                onSuccess: (response) => {
                    this.formMain.success = 'Информация обновлена'
                    this.formMain.reset();
                    this.$refs.avatarInput.value = '';
                },
            });
        },
    },
    watch: {
        'formMain.success': {
            handler(newMessage) {
                setTimeout(() => {
                    this.formMain.success = null;
                }, 5000);
            },
            deep: true
        }
    }
}
</script>

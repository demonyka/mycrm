<template>
    <Head :title="`Редактирование сотрудника «${user.fullname}»`"/>
    <Sidebar :links="links">
        <Center>
            <Block class="block">
                <div class="actions">
                    <Link :href="route('staff.view', {id: user.id})">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </Link>
                </div>
                <h2 class="title">Редактирование</h2>
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
                    <div class="info-line">
                        <label>Шаблон: </label>
                        <div class="holder">
                            <select v-model="formMain.template_id">
                                <option v-for="template in templates" :key="template.id" :value="template.id">{{ template.name }}</option>
                            </select>
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
        <Center v-if="user.template" style="margin-top: 20px">
            <Block class="block">
                <h2 class="title">{{ user.template.name }}</h2>
                <form @submit.prevent="formDataSubmit" class="userdata" style="margin-top: 10px">
                    <div v-for="(field, index) in JSON.parse(user.template['fields'])" class="info-line">
                        <label>{{ field.name }}: </label>
                        <div class="holder">
                            <input
                                :placeholder="field.name"
                                :type="field.type"
                                v-model="formData[field.slug]"
                                :class="{ 'error': formData.errors[field.slug] }"
                            >
                        </div>
                    </div>
                    <transition-group name="fade" v-if="formData.errors">
                        <p v-for="error in formData.errors" class="error" style="margin-top: 5px">
                            {{ error }}
                        </p>
                    </transition-group>
                    <button class="primary" style="margin-top: 10px" type="submit">Сохранить</button>
                    <transition name="fade">
                        <p class="success" style="margin-top: 10px" v-if="formData.success">
                            {{ formData.success }}
                        </p>
                    </transition>
                </form>
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
        .title {
            font-size: 16px;
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
            input, select {
                max-width: 100%;
            }
            input[type=password], input[type=text] {
                outline: none;
                border: 1px solid var(--gray4);
                padding: 5px 10px;
                border-radius: 5px;
            }
            input:focus {
                border-color: var(--blue1);
            }
            select {
                outline: none;
                border: 1px solid var(--gray4);
                padding: 5px 10px;
                width: 200px;
                border-radius: 5px;
            }
            option {
                border-radius: 5px;
            }
            option:checked {
                background-color: var(--blue1);
                color: white;
            }
        }
    }
    .actions {
        position: absolute;
        left: 20px;
        top: 20px;
        z-index: 10000;
        svg {
            cursor: pointer;

            path {
                stroke: var(--gray3);
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
import {Head, useForm, Link} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import Block from "@/Layouts/Block.vue";
import Center from "@/Layouts/Center.vue";
import ActionEditButton from "@/Pages/Staff/Elements/Actions/ActionEditButton.vue";
import ActionDismissRestoreButton from "@/Pages/Staff/Elements/Actions/ActionDismissRestoreButton.vue";
export default {
    name: "User",
    components: {
        ActionDismissRestoreButton, ActionEditButton,
        Center,
        Block,
        Sidebar,
        Head, Link
    },
    data() {
        return {
            tplData: this.user.tpl_data ? JSON.parse(this.user.tpl_data) : {},
            formMain: useForm({
                _token: this.$page.props.csrf_token,
                avatar: null,
                password: '',
                template_id: this.user.template ? this.user.template.id : null
            }),
            formData: useForm({
                _token: this.$page.props.csrf_token,
            })
        }
    },
    props: [
        'links',
        'user',
        'templates'
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
            this.formMain.post(route('staff.edit', {id: this.user.id}), {
                onSuccess: () => {
                    this.formMain.success = 'Информация обновлена'
                    this.formMain.reset();
                    this.$refs.avatarInput.value = '';
                },
            });
        },
        formDataSubmit() {
            this.formData.post(route('staff.edit.tpl', {id: this.user.id}), {
                onSuccess: () => {
                    this.formData.success = 'Информация обновлена'
                },
            });
        },
    },
    watch: {
        'formMain.success': {
            handler() {
                setTimeout(() => {
                    this.formMain.success = null;
                }, 5000);
            },
            deep: true
        },
        'formData.success': {
            handler() {
                setTimeout(() => {
                    this.formData.success = null;
                }, 5000);
            },
            deep: true
        }
    },
    mounted() {
        const fields = JSON.parse(this.user.template['fields']);
        let data = {}; // Используем объект, а не массив
        fields.forEach((field) => {
            data[field.slug] = this.tplData[field.slug] || '';
        });
        this.formData = useForm(data);
    }
}
</script>

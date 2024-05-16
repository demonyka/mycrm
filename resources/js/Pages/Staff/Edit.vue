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
                <h2 class="title">Основные данные</h2>
                <div class="userdata" style="margin-top: 10px">
                    <div class="info-line">
                        <label>Фамилия: </label>
                        <div class="holder" :class="{'empty': !tplData.lastname}">{{ tplData.lastname || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Имя: </label>
                        <div class="holder" :class="{'empty': !tplData.firstname}">{{ tplData.firstname || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Отчество: </label>
                        <div class="holder" :class="{'empty': !tplData.middlename}">{{ tplData.middlename || 'Не указано' }}</div>
                    </div>
                </div>
                <div class="userdata">
                    <div class="info-line">
                        <label>Telegram: </label>
                        <div class="holder" :class="{'empty': !tplData.telegram}">{{ tplData.telegram || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Моб. телефон: </label>
                        <div class="holder" :class="{'empty': !tplData.phone_number}">{{ tplData.phone_number || 'Не указано' }}</div>
                    </div>
                </div>
                <div class="userdata">
                    <div class="info-line">
                        <label>Должность: </label>
                        <div class="holder empty" v-if="user.positions && user.positions.length === 0">Отсутствует</div>
                        <div class="holder" v-else>{{ user.positions.map(position => position.name).join(', ') }}</div>
                    </div>
                    <div class="info-line">
                        <label>Дата приёма: </label>
                        <div class="holder" :class="{'empty': !tplData.employment_date}">{{ tplData.employment_date || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Начало рабочего дня: </label>
                        <div class="holder" :class="{'empty': !tplData.work_start}">{{ tplData.work_start || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Рабочий график: </label>
                        <div class="holder" :class="{'empty': !tplData.work_schedule}">{{ tplData.work_schedule || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Ставка: </label>
                        <div class="holder" :class="{'empty': !tplData.work_rate}">{{ tplData.work_rate || 'Не указано' }}</div>
                    </div>
                </div>
                <div class="userdata" style="margin-top: 10px">
                    <div class="info-line">
                        <label>Дата рождения: </label>
                        <div class="holder" :class="{'empty': !tplData.birthday}">{{ tplData.birthday || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Адрес регистрации: </label>
                        <div class="holder" :class="{'empty': !tplData.address_reg}">{{ tplData.address_reg || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Адрес проживания: </label>
                        <div class="holder" :class="{'empty': !tplData.address_live}">{{ tplData.address_live || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Серия и номер паспорта: </label>
                        <div class="holder" :class="{'empty': !tplData.passport}">{{ tplData.passport || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Кем выдан: </label>
                        <div class="holder" :class="{'empty': !tplData.passport_by}">{{ tplData.passport_by || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Код подразделения: </label>
                        <div class="holder" :class="{'empty': !tplData.passport_code}">{{ tplData.passport_code || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Дата выдачи: </label>
                        <div class="holder" :class="{'empty': !tplData.passport_date}">{{ tplData.passport_date || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>ИНН: </label>
                        <div class="holder" :class="{'empty': !tplData.inn}">{{ tplData.inn || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>СНИЛС: </label>
                        <div class="holder" :class="{'empty': !tplData.snils}">{{ tplData.snils || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Полис ДМС: </label>
                        <div class="holder" :class="{'empty': !tplData.dms}">{{ tplData.dms || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Водительское удостверение: </label>
                        <div class="holder" :class="{'empty': !tplData.drive_license}">{{ tplData.drive_license || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Семейное положение: </label>
                        <div class="holder" :class="{'empty': !tplData.family_status}">{{ tplData.family_status || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Сведения о супруге: </label>
                        <div class="holder" :class="{'empty': !tplData.spouse_info}">{{ tplData.spouse_info || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Сведения о детях: </label>
                        <div class="holder" :class="{'empty': !tplData.children_info}">{{ tplData.children_info || 'Не указано' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Воинская обязанность: </label>
                        <div class="holder" :class="{'empty': !tplData.army_duty}">{{ tplData.army_duty || 'Не указано' }}</div>
                    </div>
                </div>
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

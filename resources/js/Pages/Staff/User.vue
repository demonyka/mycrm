<template>
    <Head :title="user.fullname"/>
    <Sidebar :links="links">
        <Center>
            <Block class="block">
                <div @click.stop class="actions">
                    <svg @click="openActions()" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 12H18.01M12 12H12.01M6 12H6.01M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12ZM19 12C19 12.5523 18.5523 13 18 13C17.4477 13 17 12.5523 17 12C17 11.4477 17.4477 11 18 11C18.5523 11 19 11.4477 19 12ZM7 12C7 12.5523 6.55228 13 6 13C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11C6.55228 11 7 11.4477 7 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <transition name="fade">
                        <div
                            v-if="actionsOpened &&
                            (($page.props.auth.user.permissions.includes('staff.delete') && user.status === 'active') || ($page.props.auth.user.permissions.includes('staff.restore') && user.status === 'dismiss') || $page.props.auth.user.permissions.includes('staff.edit'))"
                            class="actions-buttons" ref="actions">
                            <svg v-if="$page.props.auth.user.permissions.includes('staff.edit')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.4998 5.49994L18.3282 8.32837M3 20.9997L3.04745 20.6675C3.21536 19.4922 3.29932 18.9045 3.49029 18.3558C3.65975 17.8689 3.89124 17.4059 4.17906 16.9783C4.50341 16.4963 4.92319 16.0765 5.76274 15.237L17.4107 3.58896C18.1918 2.80791 19.4581 2.80791 20.2392 3.58896C21.0202 4.37001 21.0202 5.63634 20.2392 6.41739L8.37744 18.2791C7.61579 19.0408 7.23497 19.4216 6.8012 19.7244C6.41618 19.9932 6.00093 20.2159 5.56398 20.3879C5.07171 20.5817 4.54375 20.6882 3.48793 20.9012L3 20.9997Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg @click="deleteUser(user.id)" v-if="user.status === 'active' && $page.props.auth.user.permissions.includes('staff.delete')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg @click="restoreUser(user.id)" v-else-if="$page.props.auth.user.permissions.includes('staff.restore')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 8H16.5C18.9853 8 21 10.0147 21 12.5C21 14.9853 18.9853 17 16.5 17H3M3 8L6 5M3 8L6 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </transition>
                </div>


                <img class="avatar" :alt="user.username"
                     :src="user.tpl_data && JSON.parse(user.tpl_data).avatar_path ? JSON.parse(user.tpl_data).avatar_path : '/assets/images/default_avatar.png'"
                     @error="$event.target.src = '/assets/images/default_avatar.png'"
                     loading="eager">
                <div class="fullname">
                    <h2 class="title">{{ user.fullname }}</h2>
                    <span v-if="user.status !== 'active'" style="color: var(--red); font-size: 14px">Сотрудник уволен или удалён</span>
                </div>
                <div class="userdata">
                    <div class="info-line">
                        <label>Логин: </label>
                        <div class="holder">{{ user.username || 'Отсутствует' }}</div>
                    </div>
                    <div class="info-line">
                        <label>E-Mail: </label>
                        <div class="holder">{{ user.email || 'Отсутствует' }}</div>
                    </div>
                    <div class="info-line">
                        <label>Роли: </label>
                        <div class="holder empty" v-if="user.roles && user.roles.length === 0">Отсутствуют</div>
                        <div class="holder" v-else>{{ user.roles.map(role => role.name).join(', ') }}</div>
                    </div>
                </div>
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
        p.info {
            font-size: 12px;
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
        }
    }
    .empty {
        font-style: italic;
        color: var(--gray4);
        font-weight: 500;
    }
    .actions {
        position: absolute;
        right: 20px;
        top: 20px;
        svg {
            cursor: pointer;
            path {
                stroke: var(--gray3);
            }
        }
        .actions-buttons {
            background: white;
            position: absolute;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            left: -250%;
            top: 50%;
            transform: translate(50%, -50%);
            cursor: default;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            svg {
                cursor: pointer;
            }
            svg:hover {
                path {
                    stroke: var(--blue1);
                }
            }
        }
    }
</style>

<script>
import {Head} from "@inertiajs/vue3";
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
            actionsOpened: false
        }
    },
    props: [
        'links',
        'user'
    ],
    methods: {
        deleteUser(id) {
            this.$inertia.post(route('staff.delete', {id: id}));
        },
        restoreUser(id) {
            this.$inertia.post(route('staff.restore', {id: id}));
        },
        openActions() {
            this.actionsOpened = true;
            this.$nextTick(() => {
                document.addEventListener('click', this.closeActions);
            });
        },
        closeActions() {
            this.actionsOpened = false;
            document.removeEventListener('click', this.closeActions);
        },
    }
}
</script>

<template>
    <Head :title="`Сотрудник «${user.fullname}»`"/>
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
                            <ActionEditButton :user_id="user.id"/>
                            <ActionDismissRestoreButton :user="user"/>
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
        <TemplateData v-if="user.template" style="margin-top: 20px" :data="tplData" :template="user.template"/>
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
import ActionEditButton from "@/Pages/Staff/Elements/Actions/ActionEditButton.vue";
import ActionDismissRestoreButton from "@/Pages/Staff/Elements/Actions/ActionDismissRestoreButton.vue";
import TemplateData from "@/Pages/Staff/Elements/TemplateData.vue";
export default {
    name: "User",
    components: {
        TemplateData,
        ActionDismissRestoreButton,
        ActionEditButton,
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

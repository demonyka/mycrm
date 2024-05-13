<script>
import {Head, Link} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import {VueAwesomePaginate} from "vue-awesome-paginate";
export default {
    name: "StaffTable",
    components: {
        VueAwesomePaginate,
        Sidebar,
        Head, Link
    },
    props: [
        'users'
    ],
    data() {
        return {
            settings: JSON.parse(localStorage.getItem('settings')) || {
                fullname: {
                    name: 'ФИО',
                    status: false
                },
                positions: {
                    name: 'Должность',
                    status: false
                }
            },
            currentPage: this.users.current_page,
            actionsOpened: {},
            isSettingOpened: false
        }
    },
    methods: {
        onClickHandler(page) {
            this.$inertia.visit(this.users.path + '?page=' + page);
        },
        deleteUser(id) {
            this.$inertia.post(route('staff.delete', {id: id}));
        },
        restoreUser(id) {
            this.$inertia.post(route('staff.restore', {id: id}));
        },

        openSettings() {
            console.log('settings')
            this.isSettingOpened = true;
            this.$nextTick(() => {
                document.addEventListener('click', this.closeActionsOrSettings);
            });
        },
        openActions(id) {
            this.actionsOpened = {};
            this.actionsOpened[id] = true;
            this.$nextTick(() => {
                document.addEventListener('click', this.closeActionsOrSettings);
            });
        },
        closeActionsOrSettings() {
            this.actionsOpened = {};
            this.isSettingOpened = false;
            document.removeEventListener('click', this.closeActionsOrSettings);
        },
    },
    watch: {
        settings: {
            handler(newSettings) {
                localStorage.setItem('settings', JSON.stringify(newSettings));
            },
            deep: true
        }
    }
}
</script>

<template>
    <table>
        <thead>
        <tr>
            <th @click.stop style="display: flex; align-items: center; justify-content: center">
                <svg @click="openSettings()" class="settings" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="var(--gray4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.9046 3.06005C12.6988 3 12.4659 3 12 3C11.5341 3 11.3012 3 11.0954 3.06005C10.7942 3.14794 10.5281 3.32808 10.3346 3.57511C10.2024 3.74388 10.1159 3.96016 9.94291 4.39272C9.69419 5.01452 9.00393 5.33471 8.36857 5.123L7.79779 4.93281C7.3929 4.79785 7.19045 4.73036 6.99196 4.7188C6.70039 4.70181 6.4102 4.77032 6.15701 4.9159C5.98465 5.01501 5.83376 5.16591 5.53197 5.4677C5.21122 5.78845 5.05084 5.94882 4.94896 6.13189C4.79927 6.40084 4.73595 6.70934 4.76759 7.01551C4.78912 7.2239 4.87335 7.43449 5.04182 7.85566C5.30565 8.51523 5.05184 9.26878 4.44272 9.63433L4.16521 9.80087C3.74031 10.0558 3.52786 10.1833 3.37354 10.3588C3.23698 10.5141 3.13401 10.696 3.07109 10.893C3 11.1156 3 11.3658 3 11.8663C3 12.4589 3 12.7551 3.09462 13.0088C3.17823 13.2329 3.31422 13.4337 3.49124 13.5946C3.69158 13.7766 3.96395 13.8856 4.50866 14.1035C5.06534 14.3261 5.35196 14.9441 5.16236 15.5129L4.94721 16.1584C4.79819 16.6054 4.72367 16.829 4.7169 17.0486C4.70875 17.3127 4.77049 17.5742 4.89587 17.8067C5.00015 18.0002 5.16678 18.1668 5.5 18.5C5.83323 18.8332 5.99985 18.9998 6.19325 19.1041C6.4258 19.2295 6.68733 19.2913 6.9514 19.2831C7.17102 19.2763 7.39456 19.2018 7.84164 19.0528L8.36862 18.8771C9.00393 18.6654 9.6942 18.9855 9.94291 19.6073C10.1159 20.0398 10.2024 20.2561 10.3346 20.4249C10.5281 20.6719 10.7942 20.8521 11.0954 20.94C11.3012 21 11.5341 21 12 21C12.4659 21 12.6988 21 12.9046 20.94C13.2058 20.8521 13.4719 20.6719 13.6654 20.4249C13.7976 20.2561 13.8841 20.0398 14.0571 19.6073C14.3058 18.9855 14.9961 18.6654 15.6313 18.8773L16.1579 19.0529C16.605 19.2019 16.8286 19.2764 17.0482 19.2832C17.3123 19.2913 17.5738 19.2296 17.8063 19.1042C17.9997 18.9999 18.1664 18.8333 18.4996 18.5001C18.8328 18.1669 18.9994 18.0002 19.1037 17.8068C19.2291 17.5743 19.2908 17.3127 19.2827 17.0487C19.2759 16.8291 19.2014 16.6055 19.0524 16.1584L18.8374 15.5134C18.6477 14.9444 18.9344 14.3262 19.4913 14.1035C20.036 13.8856 20.3084 13.7766 20.5088 13.5946C20.6858 13.4337 20.8218 13.2329 20.9054 13.0088C21 12.7551 21 12.4589 21 11.8663C21 11.3658 21 11.1156 20.9289 10.893C20.866 10.696 20.763 10.5141 20.6265 10.3588C20.4721 10.1833 20.2597 10.0558 19.8348 9.80087L19.5569 9.63416C18.9478 9.26867 18.6939 8.51514 18.9578 7.85558C19.1262 7.43443 19.2105 7.22383 19.232 7.01543C19.2636 6.70926 19.2003 6.40077 19.0506 6.13181C18.9487 5.94875 18.7884 5.78837 18.4676 5.46762C18.1658 5.16584 18.0149 5.01494 17.8426 4.91583C17.5894 4.77024 17.2992 4.70174 17.0076 4.71872C16.8091 4.73029 16.6067 4.79777 16.2018 4.93273L15.6314 5.12287C14.9961 5.33464 14.3058 5.0145 14.0571 4.39272C13.8841 3.96016 13.7976 3.74388 13.6654 3.57511C13.4719 3.32808 13.2058 3.14794 12.9046 3.06005Z" stroke="var(--gray4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <transition name="fade">
                    <div v-if="isSettingOpened" class="settings-buttons" ref="settings">
                        <div class="settings-checkbox" v-for="(param, key) in settings">
                            <input type="checkbox" v-model="param.status" @click="param.status = !param.status" :id="key">
                            <label :for="key">{{ param.name }}</label>
                        </div>
                    </div>
                </transition>
            </th>
            <th>ID</th>
            <th>Логин</th>
            <th>E-Mail</th>
            <th v-for="param in settings" :style="{ 'display': param.status ? 'table-cell' : 'none'}">{{ param.name }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users.data">
            <td class="avatar_cell">
                <Link
                    :style="{ pointerEvents: !$page.props.auth.user.permissions.includes('staff.view') ? 'none' : 'auto' }"
                    :href="route('staff.view', {id: user.id})">
                    <img :alt="user.username"
                         :src="user.tpl_data && JSON.parse(user.tpl_data).avatar_path ? JSON.parse(user.tpl_data).avatar_path : '/assets/images/default_avatar.png'"
                         @error="$event.target.src = '/assets/images/default_avatar.png'">
                </Link>
            </td>
            <td><span>{{ user.id }}</span></td>
            <td><span>{{ user.username }}</span></td>
            <td><span>{{ user.email }}</span></td>
            <td v-for="(param, key) in settings" :style="{ 'display': param.status ? 'table-cell' : 'none'}"><span v-if="user[key] && user[key] !== user.username">{{ Array.isArray(user[key]) ? user[key].join(', ') : user[key] }}</span></td>
            <td @click.stop class="actions">
                <svg @click="openActions(user.id)" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 12H18.01M12 12H12.01M6 12H6.01M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12ZM19 12C19 12.5523 18.5523 13 18 13C17.4477 13 17 12.5523 17 12C17 11.4477 17.4477 11 18 11C18.5523 11 19 11.4477 19 12ZM7 12C7 12.5523 6.55228 13 6 13C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11C6.55228 11 7 11.4477 7 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <transition name="fade">
                    <div
                        v-if="actionsOpened[user.id] &&
                            (($page.props.auth.user.permissions.includes('staff.delete') && user.status === 'active') || ($page.props.auth.user.permissions.includes('staff.restore') && user.status === 'dismiss'))"
                        class="actions-buttons" ref="actions">
                        <svg @click="deleteUser(user.id)" v-if="user.status === 'active' && $page.props.auth.user.permissions.includes('staff.delete')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg @click="restoreUser(user.id)" v-else-if="$page.props.auth.user.permissions.includes('staff.restore')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8H16.5C18.9853 8 21 10.0147 21 12.5C21 14.9853 18.9853 17 16.5 17H3M3 8L6 5M3 8L6 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </transition>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-if="users && users.total > users.per_page" style="text-align: center">
        <vue-awesome-paginate
            :current-page="users.current_page"
            :total-items="users.total"
            :max-pages-shown="5"
            :items-per-page="users.per_page"
            v-model="currentPage"
            :on-click="onClickHandler"
            :show-breakpoint-buttons="true"
        />
    </div>
</template>

<style scoped>
.avatar_cell {
    width: 56px;
    padding: 12px;
    img {
        width: 56px;
        height: 56px;
        object-fit: cover;
    }
}
.settings-buttons {
    background: white;
    position: absolute;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 10px;
    color: black;
    top: 50px;
    left: 0;
    .settings-checkbox {
        display: flex;
        align-items: center;
        gap: 5px;
        label, input {
            cursor: pointer;
        }
    }
}
.actions {
    position: relative;
    padding: 28px 28px;
    width: 0;
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
        left: 0;
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
table {
    width: 100%;
    min-width: 100%;
    border-collapse: collapse;
    padding: 40px 40px 40px 40px;
    background-color: #ffffff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    position: relative;
    margin-bottom: 24px;
    text-indent: initial;
    border-spacing: 2px;
}
thead {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
tr {
    display: table-row;
    vertical-align: inherit;
    unicode-bidi: isolate;
    border-color: inherit;
}
table thead tr th {
    color: var(--gray4);
    padding: 16px;
    font-weight: normal;
    text-align: left;
    border-bottom: 2px solid var(--gray5);
}
table tr td {
    border-bottom: 1px solid var(--gray5);
    padding: 20px 15px;
}
svg.settings {
    cursor: pointer;
}
svg.settings:hover {
    opacity: .7;
}
</style>

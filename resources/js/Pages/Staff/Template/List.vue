<template>
    <Head title="Шаблоны данных"/>
    <Sidebar :links="links">
        <div v-if="$page.props.auth.user.permissions.includes('staff.template.create')" style="margin-bottom: 20px">
            <button @click="$inertia.visit(route('staff.template.create.view'))" v-if="$page.props.auth.user.permissions.includes('staff.template.create')" class="primary">Новый шаблон</button>
        </div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Поля</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="template in templates">
                <td class="min"><span>{{ template.id }}</span></td>
                <td><span>{{ template.name }}</span></td>
                <td><span>{{ fieldNames[template.id - 1] }}</span></td>
                <td @click.stop class="actions">
                    <svg @click="openActions(template.id)" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 12H18.01M12 12H12.01M6 12H6.01M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12ZM19 12C19 12.5523 18.5523 13 18 13C17.4477 13 17 12.5523 17 12C17 11.4477 17.4477 11 18 11C18.5523 11 19 11.4477 19 12ZM7 12C7 12.5523 6.55228 13 6 13C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11C6.55228 11 7 11.4477 7 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <transition name="fade">
                        <div v-if="actionsOpened[template.id]"
                             class="actions-buttons" ref="actions">
                            <svg @click="$inertia.visit(route('staff.template.edit.view', {id: template.id}))" v-if="$page.props.auth.user.permissions.includes('staff.template.edit')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.4998 5.49994L18.3282 8.32837M3 20.9997L3.04745 20.6675C3.21536 19.4922 3.29932 18.9045 3.49029 18.3558C3.65975 17.8689 3.89124 17.4059 4.17906 16.9783C4.50341 16.4963 4.92319 16.0765 5.76274 15.237L17.4107 3.58896C18.1918 2.80791 19.4581 2.80791 20.2392 3.58896C21.0202 4.37001 21.0202 5.63634 20.2392 6.41739L8.37744 18.2791C7.61579 19.0408 7.23497 19.4216 6.8012 19.7244C6.41618 19.9932 6.00093 20.2159 5.56398 20.3879C5.07171 20.5817 4.54375 20.6882 3.48793 20.9012L3 20.9997Z" stroke="var(--gray3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg @click="wantDelete = template" v-if="$page.props.auth.user.permissions.includes('staff.template.delete')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="var(--gray3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </transition>
                </td>
            </tr>
            </tbody>
        </table>
    </Sidebar>
    <ModalConfirm @confirm="deleteTemplate(wantDelete.id)" :content="`Удаление шаблона «${wantDelete.name}»`" @reject="wantDelete = null" v-if="wantDelete"/>
</template>

<style scoped>
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
        left: -50%;
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
import {Head, Link, router} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import ModalConfirm from "@/Elements/ModalConfirm.vue";
export default {
    name: "List",
    components: {
        ModalConfirm,
        Sidebar,
        Head, Link
    },
    data() {
        return {
            actionsOpened: {},
            wantDelete: null
        }
    },
    props: [
        'links',
        'templates'
    ],
    computed: {
        fieldNames() {
            return this.templates.map(template => {
                const fields = JSON.parse(template.fields);
                return fields.map(field => field.name).join(', ');
            });
        }
    },
    methods: {
        openActions(id) {
            this.actionsOpened = {};
            this.actionsOpened[id] = true;
            this.$nextTick(() => {
                document.addEventListener('click', this.closeActionsOrSettings);
            });
        },
        closeActionsOrSettings() {
            this.actionsOpened = {};
            document.removeEventListener('click', this.closeActionsOrSettings);
        },
        deleteTemplate(id) {
            this.$inertia.post(route('staff.template.delete', {id: id}));
            this.wantDelete = null;
        }
    }
}
</script>

<template>
    <Head :title="`Редактирование шаблона «${template.name}»`"/>
    <Sidebar :links="links">
        <Center>
            <Block class="block">
                <div class="actions">
                    <Link :href="route('staff.template.view')">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </Link>
                </div>
                <h2 class="title">{{ template.name }}</h2>
                <form @submit.prevent="formEditSubmit" style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 10px">
                    <div v-for="(field, index) in JSON.parse(template.fields)" class="userdata">
                        <div class="info-line">
                            <label>Название:</label>
                            <div class="holder">
                                <input
                                    placeholder="Название"
                                    v-model="form[index]['name']"
                                    type="text"
                                >
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Slug:</label>
                            <div class="holder">
                                <input
                                    placeholder="Slug"
                                    v-model="form[index]['slug'] "
                                    type="text"
                                >
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Тип:</label>
                            <div class="holder">
                                <select v-model="form[index]['type']">
                                    <option v-for="type in types" :value="type.type">{{ type.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Скрытое:</label>
                            <div class="holder">
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="form[index]['hidden']"
                                        value="true"
                                    >
                                    <span>Да</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="form[index]['hidden']"
                                        value="false"
                                    >
                                    <span>Нет</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Обязательное:</label>
                            <div class="holder">
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="form[index]['required']"
                                        value="true"
                                    >
                                    <span>Да</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="form[index]['required']"
                                        value="false"
                                    >
                                    <span>Нет</span>
                                </div>
                            </div>
                        </div>
                        <div class="edit-bottom">
                            <div class="edit-bottom-line">
                                <svg @click="deleteField(form[index]['slug'])" style="position: absolute; bottom: 10px; right: 20px" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="var(--gray3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button class="primary" type="submit">
                        Сохранить
                    </button>
                    <transition name="fade">
                        <p class="success" v-if="form.success">
                            {{ form.success }}
                        </p>
                    </transition>
                </form>
            </Block>
        </Center>

        <Center style="margin-top: 20px">
            <Block>
                <h2 class="title">Новое поле</h2>
                <form @submit.prevent="formNewSubmit" style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 10px">
                    <div class="userdata">
                        <div class="info-line">
                            <label>Название:</label>
                            <div class="holder">
                                <input
                                    placeholder="Название"
                                    v-model="formNew.name"
                                    required
                                    :class="{'error': formNew.errors.name}"
                                    @focus="formNew.errors.name = null"
                                    type="text"
                                >
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Slug:</label>
                            <div class="holder">
                                <input
                                    placeholder="Slug"
                                    v-model="formNew.slug"
                                    required
                                    :class="{'error': formNew.errors.slug}"
                                    @focus="formNew.errors.slug = null"
                                    type="text"
                                >
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Тип:</label>
                            <div class="holder">
                                <select v-model="formNew.type">
                                    <option v-for="type in types" :value="type.type">{{ type.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Скрытое:</label>
                            <div class="holder">
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="formNew.hidden"
                                        value="true"
                                    >
                                    <span>Да</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="formNew.hidden"
                                        value="false"
                                    >
                                    <span>Нет</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-line">
                            <label>Обязательное:</label>
                            <div class="holder">
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="formNew.required"
                                        value="true"
                                    >
                                    <span>Да</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px">
                                    <input
                                        style="margin: 0"
                                        type="radio"
                                        v-model="formNew.required"
                                        value="false"
                                    >
                                    <span>Нет</span>
                                </div>
                            </div>
                        </div>
                        <transition-group name="fade">
                            <p v-for="error in formNew.errors" class="error">{{ error }}</p>
                            <p class="success" v-if="form.success">
                                {{ form.success }}
                            </p>
                        </transition-group>
                    </div>
                    <button class="primary" type="submit">
                        Добавить
                    </button>
                </form>
            </Block>
        </Center>
    </Sidebar>
</template>

<style scoped>
@media screen and (max-width: 1000px) {
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
.userdata {
    width: 100%;
    .edit-bottom {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        position: relative;
        .edit-bottom-line {
            position: relative;
            margin-top: 5px;
            width: 80%;
            border-bottom: 1px solid var(--gray4);
            svg {
                cursor: pointer;
            }
            svg:hover path {
                stroke: var(--blue1)
            }
        }
    }

}
.info-line {
    display: flex;
    align-items: center;
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
        align-items: center;
        vertical-align: middle;
        text-align: left;
        gap: 10px;
        position: relative;
        input, select {
            max-width: 100%;
        }
        input[type=radio], select {
            cursor: pointer;
        }
        input[type=password], input[type=text], input[type=number] {
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
import {Head, Link, useForm} from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Sidebar.vue";
import Center from "@/Layouts/Center.vue";
import Block from "@/Layouts/Block.vue";
export default {
    name: "TemplateEdit",
    components: {
        Block,
        Center,
        Sidebar,
        Head, Link
    },
    props: [
        'links',
        'template'
    ],
    data() {
        return {
            types: [
                {'name': 'Строка', type: 'text'},
                {'name': 'Число', type: 'number'}
            ],
            form: useForm(JSON.parse(this.template.fields)),
            formNew: useForm({
                name: '',
                slug: '',
                type: 'text',
                hidden: false,
                required: false,
            }),
            formDelete: useForm({
                slug: ''
            })
        }
    },
    methods: {
        formNewSubmit() {
            this.formNew.post(route('staff.template.edit.field.add', {id: this.template.id}), {
                preserveScroll: true,
                onSuccess: (response) => {
                    this.template.fields = response.props.template.fields;
                    this.form = useForm(JSON.parse(this.template.fields));
                    this.formNew.reset();
                    this.form.success = "Шаблон успешно обновлён";
                }
            });
        },
        deleteField(slug) {
            this.formDelete.slug = slug;
            this.formDelete.post(route('staff.template.edit.field.delete', {id: this.template.id}), {
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.success = "Шаблон успешно обновлён";
                    this.template.fields = response.props.template.fields;
                    this.form = useForm(JSON.parse(this.template.fields));
                    this.formDelete.reset();
                }
            });
        },
        formEditSubmit() {
            this.form.post(route('staff.template.edit.field', {id: this.template.id}), {
                preserveScroll: true,
                onSuccess: (response) => {
                    this.template.fields = response.props.template.fields
                    this.form = useForm(JSON.parse(this.template.fields));
                    this.form.success = "Шаблон успешно обновлён";
                }
            });
        }
    },
    watch: {
        'form.success': {
            handler() {
                setTimeout(() => {
                    this.form.success = null;
                }, 5000);
            },
            deep: true
        },
    },
}
</script>

<script>
import Block from "@/Layouts/Block.vue";
import Center from "@/Layouts/Center.vue";

export default {
    name: "TemplateData",
    components: {Center, Block},
    props: [
        'data',
        'template'
    ]
}
</script>

<template>
    <Center>
        <Block class="block">
            <h2 class="title">{{ template.name }}</h2>
            <div class="userdata" style="margin-top: 10px">
                <div v-for="(field, index) in JSON.parse(template['fields'])" class="info-line">
                    <label v-if="field.hidden ? $page.props.auth.user.permissions.includes('staff.template.edit') : true">{{ field.name }}: </label>
                    <div v-if="field.hidden ? $page.props.auth.user.permissions.includes('staff.template.edit') : true" class="holder" :class="{'empty': !data[field.slug]}">{{ data[field.slug] || 'Не указано' }}</div>
                </div>
            </div>
        </Block>
    </Center>
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
}
.block {
    width: 40%;
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
</style>

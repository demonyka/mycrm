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
                    <label>{{ field.name }}: </label>
                    <div class="holder" :class="{'empty': !data[field.slug]}">{{ data[field.slug] || 'Не указано' }}</div>
                </div>
            </div>
        </Block>
    </Center>
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

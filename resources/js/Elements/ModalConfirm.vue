

<template>
    <div class="modal" @click="reject">
        <Center>
            <Block @click.stop>
                <h2 class="title">Подтвердите действие</h2>
                <p>{{ content }}</p>
                <div class="buttons">
                    <button class="primary" @click="confirm">Подтвердить</button>
                    <button class="secondary" @click="reject">Отклонить</button>
                </div>
            </Block>
        </Center>
    </div>
</template>

<style scoped>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        button {
            width: 100%;
        }
    }
</style>

<script>
import Center from "@/Layouts/Center.vue";
import Block from "@/Layouts/Block.vue";

export default {
    name: "ModalConfirm",
    components: {Block, Center},
    props: [
        'content'
    ],
    methods: {
        confirm() {
            this.$emit('confirm');
        },
        reject() {
            this.$emit('reject');
        }
    }
}
</script>

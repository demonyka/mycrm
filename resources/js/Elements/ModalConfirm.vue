

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
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,.3);
        display: flex;
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

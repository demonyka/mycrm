<script>
export default {
    name: "Block",
}
</script>

<template>
    <div class="block">
        <div class="block-content">
            <slot/>
        </div>
    </div>
</template>

<style scoped>
    .block {
        position: relative;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background: white;
        border-radius: 15px;
    }
    .block-content {
        padding: 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
</style>

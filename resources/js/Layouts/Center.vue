<script>
export default {
    name: "Center"
}
</script>

<template>
    <div class="center">
        <slot/>
    </div>
</template>

<style scoped>
    .center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

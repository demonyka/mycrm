<script>
import SmallLogo from "@/Elements/SmallLogo.vue";

export default {
    name: "LogoTitle",
    components: {SmallLogo},
    props: [
        'title'
    ]
}
</script>

<template>
    <div class="logo-title">
        <SmallLogo/>
        <h2 class="title">{{ title }}</h2>
    </div>
</template>

<style scoped>
    div.logo-title {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: default;
        user-select: none;
    }
</style>

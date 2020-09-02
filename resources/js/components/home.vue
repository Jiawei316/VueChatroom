<template>

</template>

<script>
    export default {
        mounted() {
            let user = this.$store.getters.userData;

            this.$router.push(user.length === 0 ? 'login' : 'chat');
        }
    }
</script>

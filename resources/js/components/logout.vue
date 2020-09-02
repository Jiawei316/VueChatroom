<template>

</template>

<script>
    export default {
        async mounted() {
            await axios.post('/api/users/logout',{token:this.$store.getters.userData._token})
                .then(res => {
                    swal.fire({
                        title:'Message',
                        text: '登出成功。',
                        timer:500,
                        showConfirmButton:false,
                        timerProgressBar:true
                    }).then(() => {
                        this.$store.dispatch('logout');
                        this.$router.push('/login');
                    });
                });
        }
    }
</script>

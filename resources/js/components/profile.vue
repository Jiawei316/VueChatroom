<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Profile
            </div>

            <div class="card-body">
                <h5 class="card-title">您的ID: {{ userData.id }}</h5>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default{
        computed:{
            ...mapGetters([
                'userData'
            ])
        }
    }
</script>

<template>
    <div class="container">
        <div class="card text-center ml-2 w-18" v-for="item in friendsInvitation">
            <div class="card-header">
                好友邀請
            </div>

            <div class="body">
                <h5 class="card-title">
                    傳送人
                </h5>

                <p class="card-text">
                    {{ item.selfName}}
                </p>

                <div class="card-text">
                    <button class="btn btn-success" @click="changeFriendInvitation(item.id,1)">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </button>

                    <button class="btn btn-danger" @click="changeFriendInvitation(item.id,2)">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        mounted(){
            axios.post('/api/getFriendsInvitation',{token:this.$store.getters.userData._token})
                .then(res => {
                    this.$store.dispatch('setFriendsInvitation', res.data);
                });
        },
        computed:{
            ...mapGetters([
                'friendsInvitation'
            ])
        },
        methods:{
            async changeFriendInvitation(id,bool){
                let token = this.$store.getters.userData._token;

                await axios.post('/api/changeFriendInvitation',{id:id,bool:bool});
                await axios.post('/api/getFriendsInvitation',{token:token})
                           .then(res => this.$store.dispatch('setFriendsInvitation', res.data));
            }
        }
    }
</script>

<template>
    <div class="container">
        <div class="container d-flex">
            <div class="menu">
                <div class="people" @click="changeCurrentChat(item.username)" v-for="(item,index) in friendsList">
                    <div class="d-flex">
                        <avatar :username="item.username" :size="30"></avatar>

                        <div class="name">
                            {{ item.username }}
                            <div class="lastMessage">
                                {{ friendsList[index].lastMessage }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat">
                <div class="header text-center">
                    <span>{{ currentChat }}</span>
                </div>

                <div class="message">
                    <div class="board d-flex justify-content-center align-items-center" v-if="currentChat === '聊天訊息'">
                        開始聊天吧 !
                    </div>

                    <div class="main-message" v-for="item in chatList.filter(d => d.From == currentChat && d.For == selfName || d.From == selfName && d.For == currentChat)" v-else>
                        <div class="d-flex align-items-end" v-if="item.From === currentChat" @contextmenu="handler">
                            <avatar :username="item.From" :size="30"></avatar>

                            <div class="message-value">
                                <span class="ml-1" :style="{width:'100%'}">
                                    {{ item.content }}
                                </span>
                            </div>

                            <div class="message-time align-items-end">
                                {{ item.time }}
                            </div>
                        </div>

                        <div class="d-flex align-items-end float-right" v-else>
                            <div class="message-time align-items-end">
                                {{ item.time }}
                            </div>

                            <div class="message-value">
                                <span class="ml-1" :style="{width:'100%'}">
                                    {{ item.content }}
                                </span>
                            </div>

                            <avatar :username="item.From" :size="30"></avatar>
                        </div>
                    </div>
                </div>

                <div class="inputMessage">
                    <textarea @keypress.enter="sendMessage()" v-model="currentMessage" placeholder="輸入訊息"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data(){
            return {
                currentChat:'聊天訊息',
                selfName:this.$store.getters.userData.username,
                currentMessage:'',
                poll:null
            }
        },
        created() {
            this.pollData();
        },
        computed:{
            ...mapGetters([
                'friendsList',
                'chatList',
                'userData'
            ])
        },
        methods:{
            changeCurrentChat(username){
                this.currentChat = username;
            },
            sendMessage(){
                event.preventDefault()

                if(event.keyCode === 13 && this.currentMessage.length > 0) {
                    let fromId = this.$store.getters.userData.id;
                    let forId = this.$store.getters.friendsList.filter(d => d.username === this.currentChat)[0].id;
                    let content = event.target.value;

                    axios.post('/api/users/chat',{
                        fromId:fromId,
                        forId:forId,
                        content:content
                    });

                    this.currentMessage = '';
                }
            },
            pollData(){
                this.poll = setInterval(async () => {
                    let id = this.$store.getters.userData.id;

                    await axios.get(`/api/users/getFriendsList/${id}`)
                        .then(res => {
                            console.log(res.data);
                            this.$store.dispatch('setFriendsList',res.data);
                        });

                    await axios.get(`/api/users/getChatList/${id}`)
                        .then(res => {
                            this.$store.dispatch('setChatList',res.data);
                        });

                    let ele = document.querySelector('.message');

                    ele.scroll(0,ele.scrollHeight);
                },3000);
            },
            handler(){
                event.preventDefault();
                console.log(event);
            }
        },
        beforeDestroy(){
            clearInterval(this.poll);
        }
    }
</script>

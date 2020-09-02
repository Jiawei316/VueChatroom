<template>
    <div class="container text-center">
        <div class="logo">
            <span>
                LINE
            </span>
        </div>

        <div class="content">
            <div class="content-header">
                <button class="main-button" :style="{backgroundColor: mode == 'login' ? '#E0E0E0' : 'white'}" @click="mode = 'login'">
                    登入
                </button>

                <button class="main-button" :style="{backgroundColor: mode == 'register' ? '#E0E0E0' : 'white'}" @click="mode = 'register'">
                    註冊
                </button>
            </div>

            <div v-if="mode == 'login'">
                <div>
                    <input type="account" v-model="account" placeholder="帳號">
                </div>

                <div>
                    <input type="password" v-model="password" placeholder="密碼">
                </div>

                <div>
                    <button @click="login">登入</button>
                </div>
            </div>

            <div v-else>
                <div>
                    <input type="username" v-model="username" placeholder="使用者姓名">
                </div>

                <div>
                    <input type="account" v-model="account" placeholder="帳號">
                </div>

                <div>
                    <input type="password" v-model="password" placeholder="密碼">
                </div>

                <div>
                    <button @click="register">註冊</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                username:'',
                account:'',
                password:'',
                mode:'login'
            }
        },
        methods:{
            async login(){
                let response = await this.process('/api/users/login',{
                    account:this.account,
                    password:this.password
                });

                swal.fire({
                    title:'Message',
                    text: response.msg,
                    timer:2000,
                    showConfirmButton:false,
                    timerProgressBar:true
                }).then(() =>{
                    if(response.status){
                        this.$store.dispatch('setUserData',response.data);
                        this.$router.push('/chat');
                    }
                });
            },
            async register(){
                let response = await this.process('api/users/register',{
                    username:this.username,
                    account:this.account,
                    password:this.password
                });

                swal.fire({
                    title:'Message',
                    text: response.msg,
                    timer:2000,
                    showConfirmButton:false,
                    timerProgressBar:true
                }).then(() => {
                    this.mode = 'login';
                });
            },
            async process(url,data){
                return await axios.post(url,data).then(res => res.data);
            }
        }
    }
</script>

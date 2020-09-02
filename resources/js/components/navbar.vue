<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" v-if="this.$route.meta.displayNavBar">
        <div class="container">
            <router-link class="navbar-brand" to="/">LINE</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown" v-if="user">
                        <span id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ user.username }}
                        </span>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <router-link class="nav-link" to="/profile">Profile</router-link>
                            <router-link class="nav-link" to="/friends">Friends</router-link>
                            <router-link class="nav-link" to="/logout">Logout</router-link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        computed:{
            user:function(){
                return this.$store.getters.userData;
            }
        }
    }
</script>

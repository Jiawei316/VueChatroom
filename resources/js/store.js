import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

const defaultData = {
    userData:[],
    friendsInvitations:[],
    friendsList:[],
    chatList:[],
}

export default new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    state:defaultData,
    getters:{
        userData: state => state.userData,
        friendsInvitation: state => state.friendsInvitations,
        friendsList: state => state.friendsList,
        chatList: state => state.chatList,
    },
    mutations:{
        setUserData: (state,payload) => state.userData = payload,
        setFriendsInvitation: (state,payload) => state.friendsInvitations = payload,
        setFriendsList: (state,payload) => state.friendsList = payload,
        setChatList: (state,payload) => state.chatList = payload,
        logout: (state) => Object.assign(state,defaultData),
    },
    actions:{
        setUserData({commit},res){
            commit('setUserData',res);
        },
        setFriendsInvitation({commit},res){
          commit('setFriendsInvitation',res);
        },
        setFriendsList({commit},res){
            commit('setFriendsList',res);
        },
        setChatList({commit},res){
            commit('setChatList',res);
        },
        logout({commit}){
            commit('logout');
        }
    }
});

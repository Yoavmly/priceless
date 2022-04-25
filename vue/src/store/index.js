import {createStore} from "vuex";
import axiosClient from "../axios";
const store = createStore(
    {
        state : {
            user : {
                data : JSON.parse(sessionStorage.getItem('USER')),
                token : sessionStorage.getItem('TOKEN')
            },
            notifications :[],
            posts : {
                topPosts : [],
                post : null
            },
            topics :{
                topics : [],
                topic : null
            },
            loading : false,
        },
        getters : {},
        actions : {
            register({commit}, user) {
                return axiosClient.post('/register', user)
                    .then(({data}) => {

                        commit('setUser', data);
                        return data;
                    })
            },
            login({commit}, user) {
                return axiosClient.post('/login', user)
                    .then(({data}) => {
                        console.log(data)
                        commit('setUser', data);
                        return data;
                    })
            },
            logout({commit}) {
              if (sessionStorage.getItem('TOKEN')) {
                  commit('startLoader')
                  sessionStorage.removeItem('TOKEN');
                  commit('clearUser')
                  commit('clearToken')
                  commit('stopLoader')
                  return true;
              }
            },
            topPosts({commit}) {
                commit('startLoader');
                return axiosClient.get('/posts/top/top_posts')
                    .then(({data}) => {

                        commit('setTopPosts', data);
                        commit('stopLoader');
                        return data;
                    })
            },
            topics({commit}) {
                commit('startLoader');
                return axiosClient.get('/topics/topic/all')
                    .then(({data})=> {
                        commit('setTopics', data);
                        commit('stopLoader');
                        return data;
                    })
            },
            getTopic({commit}, id) {
                commit('startLoader');
                return axiosClient.get(`/topics/topic/${id}`)
                    .then(({data}) => {
                        commit('setTopic', data);
                        commit('stopLoader');
                        return data;
                    })
            },
            getPost({commit}, id) {
                commit('startLoader');
                return axiosClient.get(`/posts/post/${id}`)
                    .then(({data}) =>{
                        commit('setPost' , data);
                        commit('stopLoader');
                        return data;
                    })
            },
            postComment({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/comments',data)
                    .then(({data}) => {
                        commit('stopLoader');
                        return data;
                    })
            },
            postReply({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/replies',data)
                    .then(({data}) => {
                        commit('stopLoader');
                        return data;
                    })
            },
            postPost({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/posts',data)
                    .then(({data}) => {
                        commit('stopLoader');
                        return data;
                    })
            },
            upvotePost({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/posts/vote', data)
                    .then(({data})=> {
                    commit('stopLoader');
                    return data;
                })

            },
            downvotePost({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/posts/vote', data)
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })

            },
            upvoteReply({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/replies/vote', data)
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })

            },
            downvoteReply({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/replies/vote', data)
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })

            },
            upvoteComment({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/comments/vote', data)
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })

            },
            downvoteComment({commit}, data) {
                commit('startLoader');
                return axiosClient.post('/comments/vote', data)
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })
            },
            getNotifications({commit}) {
                if (store.state.user.token!==null) {
                    commit('startLoader');
                    return axiosClient.get('/notifications')
                        .then(({data})=> {
                            commit('setNotifications', data)
                            commit('stopLoader');
                            return data;
                        })
                }

            },
            sendResetPasswordLink({commit} , data) {
                commit('startLoader');
                return axiosClient.post('/password/email',data)
                    .then(({data})=> {
                        console.log(data)
                        commit('stopLoader');
                        return data;
                    })
            },
            resetPassword({commit} , data) {
                commit('startLoader');
                return axiosClient.post('/password/reset',data)
                    .then(({data})=> {
                        console.log(data)
                        commit('stopLoader');
                        return data;
                    })
            },
            resendEmailConfirmationLink({commit}){
                commit('startLoader');
                return axiosClient.get('/email/resend')
                    .then(({data})=> {
                        commit('stopLoader');
                        return data;
                    })
            },
        },
        mutations : {
            setUser : (state,userData) => {
                state.user.token = userData.token;
                state.user.data = userData.user;
                sessionStorage.setItem('TOKEN' , userData.token);
                sessionStorage.setItem('USER' , JSON.stringify(userData.user));
            },
            setTopPosts(state,postsData){
                state.posts.topPosts = postsData;
            },
            setTopics(state,topicData) {
                state.topics.topics = topicData;
            },
            setTopic(state,topicData) {
                state.topics.topic = topicData;
            },
            startLoader(state) {
                state.loading = true;
            },
            stopLoader(state) {
                state.loading = false;
            },
            setPost(state,postData) {
                state.posts.post = postData;
            },
            setNotifications(state,notificationsData) {
                state.notifications = notificationsData
            },
            clearUser(state) {
                state.user.data = null;
            },
            clearToken(state) {
                state.user.token = null;
            }

        },
        modules : {}
    }
)

export default store;

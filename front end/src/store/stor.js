import { createStore } from 'vuex'

const store = createStore({
  state: {
      authForm:'',
      closesideBar:false,
      titleDashbord:'Home'
  },
  mutations: {
    setAuthForm(state,value){
      state.authForm=value;
    },
    setCloseSideBar(state){
      state.closesideBar=!state.closesideBar;
    },
    setTitleDashbord(state,value){
      state.titleDashbord=value;
    }
    
  },
  actions: {
    
  },
  getters: {
    getAuthForm(state){
        return state.authForm;
    },
    getCloseSideBar(state){
      return state.closesideBar;
    },
    getTitleDashbord(state){
      return state.titleDashbord;
    }
  }
})

export default store

// Import from external libraries
import router from '../router/index';
import axios from 'axios';

import { createStore } from 'vuex'

const url='http://127.0.0.1:8000/api';
const store = createStore({
  state: {
      authForm:'',
      closesideBar:false,
      titleDashbord:'Home',
      auth:'',
      user_info:'',
      permissions_roles:[''],
      message:'',
      classes:'',
      class:'',
      elevs:'',
      eleve_rechercher:'',
      DevoirHome:'',
      ContenuHome:'',
      Roome:'',
      events:'',
      Statistique:'',
      Users:'',
      Note:'',
      Notification:'',
      Contenus:'',
      Devoirs:'',
      Contenu:'',
      StatistiqueContenu:'',
      NotificationMessage:'',
      Config:''
  },
  mutations: {
    setAuthForm(state,value){
      state.authForm=value;
    },
    setCloseSideBar(state){
      state.closesideBar=!state.closesideBar;
    },
    setSideBarClose(state){
      state.closesideBar=true
    },
    setTitleDashbord(state,value){
      state.titleDashbord=value;
    },
    setAuth(state,value){
      state.auth=value;
    },
    setUser(state,value){
      state.user_info=value;
    },
    setPermissions_roles(state,value){
      state.permissions_roles=value;
    },
    setMessage(state,value){
      state.message=value;
    },
    setclasses(state,value){
      state.classes=value;
    },
    setelevsClass(state,value){
      state.elevs=value
    },
    setClass(state,value){
      state.class=value;
    },
    setEleve_rechercher(state,value){
      state.eleve_rechercher=value;
    },
    setDevoirHome(state,value){
      state.DevoirHome=value;
    },
    setRoome(state,value){
      state.Roome=value;
    },
    setContenuHome(state,value){
      state.ContenuHome=value;
    },
    setevents(state,value){
      state.events=value;
    },
    setStatistique(state,value){
      state.Statistique=value;
    },
    setUsers(state,value){
      state.Users=value;
    },
    setNote(state,value){
      state.Note=value
    },
    setNotification(state,value){
      state.Notification=value
    },
    setContenus(state,value){
      state.Contenus=value;
    },
    setDevoirs(state,value){
      state.Devoirs=value;
    },
    setContenu(state,value){
      state.Contenu=value;
    },
    SetStatistiqueContenu(state,value){
      state.StatistiqueContenu=value;
    },
    setNotificationMessage(state,value){
      state.NotificationMessage=value;
    },
    setConfig(state,value){
      state.Config=value;
    }
    
  },
  actions: {
     //sign up 
     async signUp(context,user){
      try {
        const response = await axios.post(url+'/auth/register',user);
        sessionStorage.setItem('token', response.data.access_token);
        context.commit('setAuthForm','');
        router.push('/dashboard');
      } catch (error) {
          let errorMessage = "Une erreur s'est produite lors de la création du compte. Veuillez réessayer.";
          if (error.response && error.response.data && error.response.data.message) {
              errorMessage = error.response.data.message;
          } else if (error.response && error.response.data && typeof error.response.data === 'object') {
              errorMessage = Object.values(error.response.data).join(', ');
          }
          context.commit('setAuth',errorMessage );
      }
      },
      // sign in
      async signIn(context,user){
        try {
          const response = await axios.post(url+'/auth/login',user);
          sessionStorage.setItem('token', response.data.access_token);
          context.commit('setAuthForm','');
          router.push('/dashboard');
        } catch (error) {
            let errorMessage = "L'e-mail ou le mot de passe de l'utilisateur sont incorrects"; 
            context.commit('setAuth',errorMessage );
        }
      },
      //me
      async me(context){
        try {
          const response = await axios.post(url+'/me',{},
            {
              headers: {
                'Authorization': `Bearer ${sessionStorage.getItem('token')}`
              }
            }
          )
          context.commit('setUser',response.data);
      }catch(error){
        console.log(error);
      }
  },
  // log out
      async logOut(context){
        try{
           await axios.post(url+'/logout',{},
            {
              headers: {
                'Authorization': `Bearer ${sessionStorage.getItem('token')}`
              }
            }
          )
          context.commit('setPermissions_roles','');
          sessionStorage.clear();
          localStorage.clear();
          sessionStorage.removeItem('token');
          window.location.replace('/');

        }catch(erreur){
          console.log(erreur);
        }
  },
  // permissions-roles
      async getPermissions_role(context){
        try{
          const response = await axios.get(url+'/permissions-roles',{
            headers: {
               'Authorization': `Bearer ${sessionStorage.getItem('token')}`
            }
          })
          context.commit('setPermissions_roles',response.data);
      }catch(erreur){
        console.log(erreur);
      }
},
//class
    async addClass(context,value){
      try{
         await axios.post(url+'/classe',{name:value},{
          headers: {
             'Authorization': `Bearer ${sessionStorage.getItem('token')}`
          }
        })
        context.commit('setMessage','Classe creee avec succes');
    }catch(erreur){
        context.commit('setMessage','Une erreur s\'est produite, réessayez');
    }
    },
    //get all class
    async getClasses(context){
      try{
         const response=await axios.get(url+'/classes',{
          headers: {
             'Authorization': `Bearer ${sessionStorage.getItem('token')}`
          }
        })
        context.commit('setclasses',response.data);
    }catch(erreur){
        console.log(erreur); 
    }
    }, 
    //get all class inscri eleve
    async getClassesEleve(context){
      try{
         const response=await axios.get(url+'/accesclass',{
          headers: {
             'Authorization': `Bearer ${sessionStorage.getItem('token')}`
          }
        })
        context.commit('setclasses',response.data);
    }catch(erreur){
        console.log(erreur); 
    }
    }, 
    //get class
    async getClass(context,id){
      try{
         const response=await axios.get(url+`/classe/${id}`,{
          headers: {
             'Authorization': `Bearer ${sessionStorage.getItem('token')}`
          }
        })
        context.commit('setClass',response.data);
    }catch(erreur){
        console.log(erreur); 
    }},
    // get roome
    async getRoome(context,id){
      try{
         const response=await axios.get(url+`/room/${id}`,{
          headers: {
             'Authorization': `Bearer ${sessionStorage.getItem('token')}`
          }
        })
        context.commit('setRoome',response.data);
    }catch(erreur){
        console.log(erreur); 
    }},
    //delet class
    async deleteClass(context,id){
      try{
        await axios.delete(url+`/classe/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Classe supprimer avec succes');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //get Elevs
    async getElevs(context,id){
      try{
        const response=await axios.get(url+`/eleve/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setelevsClass',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //delet eleve inscrit a class
    async deleteEleve(context,id){
      try{
        await axios.delete(url+`/inscrit/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','eleve supprimer avec succes');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    // //rechercher eleve
    async rechercherElevs(context,email){
      try{
        const response=await axios.get(url+`/eleve/rocherch/${email}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setEleve_rechercher',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //ajouter eleve a class
    async inscritEleve(context,value){
      try{
        await axios.post(url+`/inscrit`,value,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','sinscrit avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    // get devoir de home 
    async getdevoir(context){
      try{
        const getdevoir = await axios.get(url+`/getdevoir`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setDevoirHome',getdevoir.data);
        }catch(erreur){
          context.commit(erreur);
        }
    },
    // get Contenu de home 
    async getcontenu(context){
      try{
        const response = await axios.get(url+`/getcontenu`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenuHome',response.data);
        }catch(erreur){
          context.commit(erreur);
        }
    },
    // get events 
    async getEvents(context,id){
      try{
        const response = await axios.get(url+`/calendars/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setevents',response.data);
        }catch(erreur){
          context.commit(erreur);
        }
    },
    // add events 
    async addEvents(context,event){
      try{
         await axios.post(url+`/calendar`,event,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
          context.commit('setMessage','succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    // delete events 
    async deletEvents(context,title){
      console.log(title);
      
      try{
         await axios.delete(url+`/calendar/${title}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        }catch(erreur){
          console.log(erreur);
        }
    },
    // get Statistique
    async getstatistique(context){
      try{
        const response = await axios.get(url+`/statistique`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setStatistique',response.data);
        
        }catch(erreur){
          console.log(erreur);
        }
    },
    // get Users
    async getusers(context){
      try{
        const response = await axios.get(url+`/users`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setUsers',response.data);
        
        }catch(erreur){
          console.log(erreur);
        }
    },
    // delet User
    async deletUsers(context,id){
      try{
        await axios.delete(url+`/user/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','User supprimée avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    // get les note
    async getNotes(context){
      try{
        const response = await axios.get(url+`/todos`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setNote',response.data);  
        }catch(erreur){
          console.log(erreur);
        }
    },
    // add note
    async addNote(context,Note){
      try{
        await axios.post(url+`/todo`,Note,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Not créée avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    // delet Note
    async deletNote(context,id){
      try{
        await axios.delete(url+`/todo/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Note supprimée avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  user update
    async UserUpdate(context,user){
      try{
        await axios.post(url+`/user/update`,user,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Votre compte à jour avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  user delet
    async UserDelet(context,id){
      try{
        await axios.delete(url+`/user/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        sessionStorage.clear();
        localStorage.clear();
        router.push('/');
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get contenus prof
    async getContenus(context,id){
      try{
        const response = await axios.get(url+`/contenus/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenus',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Exercices prof
    async getExercices(context,id){
      try{
        const response = await axios.get(url+`/devoirs/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setDevoirs',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get contenus eleve
    async getContenusEleve(context,id){
      try{
        const response = await axios.get(url+`/accescontenus/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenus',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Exercices eleve
    async getExercicesEleve(context,id){
      try{
        const response = await axios.get(url+`/accesdevoirs/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setDevoirs',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  delete Exercices 
    async deleteExercice(context,id){
      try{
         await axios.delete(url+`/devoir/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Exercice supprimée avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  delete contenus 
    async deletecontenu(context,id){
      try{
         await axios.delete(url+`/contenu/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','contenu supprimée avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  add Exercices
    async addExercices(context,value){
      try{
         await axios.post(url+`/devoir`,value,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Exercice cree avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  add Contenu
    async addContenu(context,value){
      try{
         await axios.post(url+`/contenu`,value,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setMessage','Contenu cree avec succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },
    //  get Contenu
    async getContenu(context,id){
      try{
        const response = await axios.get(url+`/contenu/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Exercice
    async getExercice(context,id){
      try{
        const response = await axios.get(url+`/devoir/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Exercice eleve
    async getExerciceEleve(context,id){
      try{
        const response = await axios.get(url+`/accesdevoir/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Contenu eleve
    async getContenuEleve(context,id){
      try{
        const response = await axios.get(url+`/accescontenu/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get statistique Contenu
    async getStatistique(context,id){
      try{
        const response = await axios.get(url+`/contenu/statistique/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('SetStatistiqueContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get statistique Exercice
    async getStatistiqueExercice(context,id){
      try{
        const response = await axios.get(url+`/devoir/statistique/${id}`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('SetStatistiqueContenu',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    },
    //  get Notification
    async getNotification(context){
      try{
        const response = await axios.get(url+`/notifications`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setNotificationMessage',response.data);
        }catch(erreur){
          console.log(erreur);
        }
    }, 
    //delete all Notification
    async deleteNotification(){
      try{
        await axios.delete(url+`/notifications`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        }catch(erreur){
          console.log(erreur);
        }
    },
    // get Config
    async getConfig(context){
      try{
        const response = await axios.get(url+`/config`,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
        context.commit('setConfig',response.data)
        }catch(erreur){
          console.log(erreur);
        }
    },
    // update Config
    async updateConfig(context,Config){
      console.log(Config);
      
      try{
        await axios.post(url+`/config/update`,Config,{
          headers: {
            'Authorization': `Bearer ${sessionStorage.getItem('token')}`
         }
        })
          context.commit('setMessage','succès');
        }catch(erreur){
          context.commit('setMessage','Une erreur s\'est produite, réessayez');
        }
    },


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
    },
    getAuth(state){
      return state.auth;  
    },
    getUser(state){
      return state.user_info;
    },
    getPermissions_roles(state){
      return state.permissions_roles;
    },
    getMessage(state){
      return state.message;
    },
    getClasses(state){
      return state.classes;
    },
    getelevsClass(state){
      return state.elevs;
    },
    getClass(state){
      return state.class;
    },
    getEleve_rechercher(state){
      return state.eleve_rechercher;
    },
    getDevoirHome(state){
      return state.DevoirHome;
    },
    getRoome(state){
      return state.Roome;
    },
    getContenuHome(state){
      return state.ContenuHome;
    },
    getevents(state){
      return state.events;
    },
    getStatistique(state){
      return state.Statistique;
    },
    getUsers(state){
      return state.Users;
    },
    getNotes(state){
      return state.Note;
    },
    getNotification(state){
      return state.Notification;
    },
    getContenus(state){
      return state.Contenus;
    },
    getDevoirs(state){
      return state.Devoirs;
    },
    getContenu(state){
      return state.Contenu;
    },
    getStatistiqueContenu(state){
      return state.StatistiqueContenu;
    },
    getNotificationMessage(state){
      return state.NotificationMessage;
    },
    getConfig(state){
      return state.Config;
    }
  }
})

export default store

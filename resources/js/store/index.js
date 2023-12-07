import { createStore } from "vuex";
import axiosClient from "../axios.js";
import router from '../router/index';

const store = createStore({
  state: {
    user: {
      data: null,
      token: null,
    },
    news: null,
    singleNews: null,
    carouselImages: null,
    coupons: null,
    loading: false,
    coupon: {
      discount: 0,
      type: '',
      code: '',
    },
    toast: {
      show: false,
      message: '',
      color: '',
    },
  },

  getters: {
  },

  actions: {
    setToast({commit}, toast) {
      commit('setToastMessage', toast);
    },

    checkCoupon({commit}, coupon) {
      commit('setLoading', true)

      return axiosClient.post('/coupon-check', { coupon: coupon })
        .then((response) => {
          commit('setCheckedCoupon', response.data.coupon);
          commit('setLoading', false)
        })
        .catch((error) => {
        })
    },
    
    login({commit}, data) {
      return axiosClient.post('/api/admin-login', data)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          console.log(this.state.user)
          router.push({name: 'admin.dashboard'})
          return data;
        })
    },

    logout({commit}) {
      commit('setUser', null);
      commit('setToken', null)
      return true;
    },

    /////////////////////// INDEX /////////////////////
    getNews({commit}) {
      commit('setLoading', true)

      return axiosClient.get('/news')
        .then((response) => {
          commit('setLoading', false)
          commit('setNews', response.data)
        })
        .catch(() => {})
    },

    getCarouselImages({commit}) {
      commit('setLoading', true)

      return axiosClient.get('/carousel-images')
        .then((response) => {
          commit('setLoading', false)
          commit('setCarouselImages', response.data)
        })
        .catch(() => {})
    },

    getCoupons({commit}) {
      commit('setLoading', true)

      return axiosClient.get('/api/coupons')
        .then((response) => {
          commit('setLoading', false)
          commit('setCoupons', response.data)
        })
        .catch(() => {})
    },
    
    /////////////////////// SHOW /////////////////////

    getSingleNews({commit}, id) {
      commit('setLoading', true)

      return axiosClient.get(`/news/${id}`)
        .then((response) => {
          commit('setLoading', false)
          commit('setSingleNews', response.data)
        })
        .catch((error) => {
          commit('setLoading', false)
          if (error.response.status === 404) {
            router.push({path: '/notfoundadmin'})
          }
        })
    },
    
    /////////////////////// STORE /////////////////////
    createNews({commit}, news) {
      return axiosClient.post('/news', news)
    },

    createCarouselImage({commit}, carouselImage) {
      if (carouselImage.image instanceof File) {
        const form = new FormData();
        form.append('title', carouselImage.title);
        form.append('sub_title', carouselImage.sub_title);
        form.append('image', carouselImage.image);
        form.append('published', carouselImage.published ? 1 : 0);
        carouselImage = form;
      }
      return axiosClient.post('/carousel-images', carouselImage)
    },

    createCoupons({commit}) {
      const couponData = {
        count: 2,
        value: 5000,
        expiration_date: '2023-12-31',
      };

      return axiosClient.post('api/coupons/generate', couponData)
    },

    /////////////////////// DELETE /////////////////////

    deleteNews({commit}, id) {
      commit('setLoading', true);

      return axiosClient.delete(`/news/${id}`)
        .then((response) => {
          commit('setLoading', false)
        })
        .catch(() => {})
    },

    deleteCarouselImage({commit}, id) {
      commit('setLoading', true);

      return axiosClient.delete(`/carousel-images/${id}`)
        .then((response) => {
          commit('setLoading', false)
        })
        .catch(() => {})
    },

    deleteCoupon({commit}, id) {
      commit('setLoading', true);

      return axiosClient.delete(`/coupons/${id}`)
        .then((response) => {
          commit('setLoading', false)
        })
        .catch(() => {})
    },

    /////////////////////// UPDATE /////////////////////
    updateNews({commit}, news) {
      const id = news.id
      news._method = 'PUT'
      
      return axiosClient.post(`/news/${id}`, news)
    },

    updateCarouselImage({commit}, carouselImage) {
      const id = carouselImage.id

      if (carouselImage.image instanceof File) {
        const form = new FormData();
        form.append('id', carouselImage.id);
        form.append('title', carouselImage.title);
        form.append('sub_title', carouselImage.sub_title);
        form.append('image', carouselImage.image);
        form.append('published', carouselImage.published ? 1 : 0);
        form.append('_method', 'PUT');
        carouselImage = form;
      } else {
        carouselImage._method = 'PUT'
      }
      return axiosClient.post(`/carousel-images/${id}`, carouselImage)
    },

    updateCoupon({commit}, coupon) {
      const id = coupon.id
      coupon._method = 'PUT'
      
      return axiosClient.post(`/coupons/${id}`, coupon)
    },
  },

  mutations: {
    setToastMessage(state, toast) {
      state.toast = toast;
    },

    setUser(state, user) {
      if (user) {
        state.user.data = user;

        localStorage.setItem('userData', JSON.stringify(user))
      } else {
        localStorage.removeItem('userData')
      }
    },
    
    setToken(state, token) {
      if (token) {
        state.user.token = token;
        const currentTime = new Date().getTime();
        const expirationTime = currentTime + (30 * 60 * 1000);

        const tokenToStore = { tokenName: token, expirationTime: expirationTime };

        localStorage.setItem('TOKEN', JSON.stringify(tokenToStore));
      } else {
        localStorage.removeItem('TOKEN')
      }
    },

    setNews(state, data = null) {
      if (data) {
        state.news = data.data;
      }
    },

    setSingleNews(state, data = null) {
      if (data) {
        state.singleNews = data;
      }
    },

    setCarouselImages(state, data = null) {
      if (data) {
        state.carouselImages = data.data;
      }
    },

    setLoading(state, loadingState) {
      state.loading = loadingState;
    },

    setCoupons(state, data = null) {
      if (data) {
        state.coupons = data.coupons;
      }
    },

    setCheckedCoupon(state, data = null) {
      if (data.length > 0) {
        state.coupon.discount = Number(data[0].discount);
        state.coupon.type = data[0].type;
        state.coupon.code = data[0].code;
      }
    },
  },
});

export default store;
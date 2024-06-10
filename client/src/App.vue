<template>
  <router-view v-slot="{ Component }">
    <transition name="slide" mode="out-in">
      <component :is="Component" />
    </transition>
  </router-view>
  <Navigation v-if="$route.meta.requireNavigator" />
</template>
<script>
import Navigation from '@/components/Navigation.vue';
export default {
  components: {
    Navigation
  },
  data() {
    return {

    };
  },
  created() {

    this.$socket.on('connect', () => {
      console.log('Connected to the server');
    });

    this.$socket.on('connect_error', (error) => {
      console.error('Connection error:', error);
    });
    this.$socket.on('disconnect', () => {
      console.log('Disconnected from the server');
    });

    this.$socket.on('notify', (data) => {
      if (data.type === 'logout') {
        localStorage.removeItem('userInfo');
        localStorage.removeItem('token');
        localStorage.removeItem('isLogin');
        alert(data.msg)
      }
    });

  },
  mounted() {
    this.updateUserInfo();
  },
  methods: {
    updateUserInfo() {
      const userInfo = JSON.parse(localStorage.getItem('userInfo'));
      if (userInfo) {
        this.$socket.emit('updateUserInfo', userInfo);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.5s ease;
}

.slide-enter,
.slide-leave-to {
  transform: translateX(-100%);
}

.slide-leave-active {
  transform: translateX(100%);
}
</style>

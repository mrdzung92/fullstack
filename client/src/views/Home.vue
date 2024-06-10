<template>
  <main class="home-page">
    <header>
      <div class="logo"><img src="@/assets/img/logo.png" alt=""></div>
      <div class="head-right">
        <div class="action" v-if="!isLogin">
          <router-link :to="{ name: 'Auth', params: { task: 'login' } }">Login</router-link>
          <router-link :to="{ name: 'Auth', params: { task: 'register' } }">Register</router-link>
        </div>

        <!-- <div class="mode" @click="changeMode">
          <font-awesome-icon v-if="isDarkMode" class="icon" :icon="['fas', 'moon']" />
          <font-awesome-icon v-else class="icon" :icon="['far', 'moon']" />
        </div> -->
      </div>
    </header>
    <div class="slider">
      <van-swipe class="my-swipe" :autoplay="3000" indicator-color="white">
        <van-swipe-item v-for="item, index in slider" :key="index"><a :href="item.link"><img :src="item.img"
              :alt="item.name"></a></van-swipe-item>

      </van-swipe>
    </div>
    <div class="marquere">
      <van-notice-bar text="Technology is the common soul of the people who developed it." left-icon="volume-o" />
    </div>

    <ul class="menu-bar">
      <li v-for="item, index in menuBar" :key="index">
        <router-link class="link" :to="item.path">
          <img class="icon" :src="item.img" :alt="item.text">
          <span>{{ item.text }}</span>
        </router-link>
      </li>
    </ul>

    <div class="box-action">
      <van-tabs v-model:active="activeSelected">
        <van-tab v-for="item in  tabs " :title="item">
        </van-tab>
      </van-tabs>
      <div class="box2">
        <div class="box-category">
          <div class="title">
            <font-awesome-icon class="icon" :icon="['fas', 'list']" />
            <span>Category</span>
          </div>
        </div>
        <router-link class="search" to="#">
          <font-awesome-icon class="icon" :icon="['fas', 'magnifying-glass']" />
          <span>search</span>
        </router-link>
      </div>
    </div>
    <ul class="product-box">
      <li class="product-item" v-for="item, index in productList">
        <div class="img">
          <img :src="item.img" :alt="item.name">
        </div>
        <p class="name">{{ item.name }}</p>
        <p class="price"><span>value</span> <span>{{ item.price }}</span></p>
        <van-progress :percentage="(item.buy * 100 / item.total).toFixed(2)" stroke-width="6" />
        <div class="info">
          <p class="buy"><span>{{ item.buy }}</span> </p>
          <p class="total"><span>{{ item.total }}</span> </p>
          <p class="remaining"><span>{{ item.total }}</span> </p>
        </div>
        <div class="action">
          <div class="buy-btn">Buy</div>
          <router-link class="cart">
            <i></i>
          </router-link>
        </div>
        <div class="phase">
          <span>phase 100</span>
        </div>
      </li>
    </ul>
  </main>
</template>

<script>

// slider images
import slider1 from '@/assets/img/tmp/slider1.jpg';
import slider2 from '@/assets/img/tmp/slider2.jpg';
import slider3 from '@/assets/img/tmp/slider3.jpg';
import slider4 from '@/assets/img/tmp/slider4.jpg';
import slider5 from '@/assets/img/tmp/slider5.jpg';
import slider6 from '@/assets/img/tmp/slider6.jpg';
import slider7 from '@/assets/img/tmp/slider7.jpg';

// menu bar
import invite from '@/assets/img/home/invite.png';
import tutorial from '@/assets/img/home/tutorial.png';
import share from '@/assets/img/home/share.png';
import recharge from '@/assets/img/home/recharge.png';
import contact from '@/assets/img/home/contact.png';
import facebook from '@/assets/img/home/facebook.png';
import telegram from '@/assets/img/home/telegram.png';
import whatsapp from '@/assets/img/home/whatapp.jpeg';

//product demo
import product1 from '@/assets/img/tmp/product1.jpeg';
import product2 from '@/assets/img/tmp/product2.jpeg';

export default {
  components: {

  },
  data() {
    return {
      isDarkMode: false,
      isLogin: false,
      activeSelected: 0,
      slider: [
        {
          img: slider1,
          link: '#',
          name: 'slider1',
        },
        {
          img: slider2,
          link: '#',
          name: 'slider2',
        },
        {
          img: slider3,
          link: '#',
          name: 'slider3',
        },
        {
          img: slider4,
          link: '#',
          name: 'slider4',
        },
        {
          img: slider5,
          link: '#',
          name: 'slider5',
        },
        {
          img: slider6,
          link: '#',
          name: 'slider6',
        },
        {
          img: slider7,
          link: '#',
          name: 'slider7',
        },
      ],
      menuBar: [
        {
          path: '#',
          img: invite,
          text: 'Invite'
        },
        {
          path: '#',
          img: tutorial,
          text: 'Tutorial'
        },
        {
          path: '#',
          img: share,
          text: 'Share'
        },
        {
          path: '#',
          img: recharge,
          text: 'Recharge'
        },
        {
          path: '#',
          img: contact,
          text: 'Contact'
        },
        {
          path: '#',
          img: facebook,
          text: 'Facebook'
        },
        {
          path: '#',
          img: telegram,
          text: 'Telegram'
        },

        {
          path: '#',
          img: whatsapp,
          text: 'Whatsapp'
        },

      ],
      tabs: [
        'Like',
        'Newest',
        'Value',
        'Speed',
      ],
      productList: [
        {
          img: product1,
          name: 'lorem ipsum dolor sit amet',
          price: 100,
          buy: 0,
          total: 100,
        },
        {
          img: product2,
          name: 'lorem ipsum dolor sit amet lorem impsum dolor sit amet',
          price: 100,
          buy: 10,
          total: 100,
        },
        {
          img: product1,
          name: 'lorem ipsum dolor sit amet',
          price: 100,
          buy: 10,
          total: 100,
        },
        {
          img: product2,
          name: 'lorem ipsum dolor sit amet lorem impsum dolor sit amet',
          price: 100,
          buy: 10,
          total: 100,
        },
        {
          img: product1,
          name: 'lorem ipsum dolor sit amet',
          price: 100,
          buy: 10,
          total: 100,
        },
        {
          img: product2,
          name: 'lorem ipsum dolor sit amet lorem impsum dolor sit amet',
          price: 100,
          buy: 10,
          total: 100,
        },
      ]
    }
  },
  created() {
    this.checkLogin()
  },
  methods: {
    checkLogin() {
      const isLogin = JSON.parse(localStorage.getItem('isLogin'));
      if (isLogin) {
        this.isLogin = true;
      }
    },
    changeMode() {
      this.isDarkMode = !this.isDarkMode;
      if (this.isDarkMode) {
        this.setDarkMode();
      } else {
        this.setLightMode();
      }
    },
    setDarkMode() {
      document.documentElement.style.setProperty('--color-background', 'var(--black)');
      document.documentElement.style.setProperty('--color-background-soft', 'var(--vt-c-black-soft)');
      document.documentElement.style.setProperty('--color-background-mute', 'var(--vt-c-black-mute)');
      document.documentElement.style.setProperty('--color-border', 'var(--vt-c-divider-dark-2)');
      document.documentElement.style.setProperty('--color-border-hover', 'var(--vt-c-divider-dark-1)');
      document.documentElement.style.setProperty('--color-heading', 'var(--vt-c-text-dark-1)');
      document.documentElement.style.setProperty('--color-text', 'var(--vt-c-text-dark-2)');
      document.documentElement.style.setProperty('--color-text-disabled', 'var(--text-dark-disable)');
    },
    setLightMode() {
      document.documentElement.style.setProperty('--color-background', 'var(--white)');
      document.documentElement.style.setProperty('--color-background-soft', 'var(--vt-c-white-soft)');
      document.documentElement.style.setProperty('--color-background-mute', 'var(--vt-c-white-mute)');
      document.documentElement.style.setProperty('--color-border', 'var(--vt-c-divider-light-2)');
      document.documentElement.style.setProperty('--color-border-hover', 'var(--vt-c-divider-light-1)');
      document.documentElement.style.setProperty('--color-heading', 'var(--vt-c-text-light-1)');
      document.documentElement.style.setProperty('--color-text', 'var(--vt-c-text-light-1)');
      document.documentElement.style.setProperty(' --color-text-disabled', 'var(--text-light-disable)');
    }
  }
}

</script>

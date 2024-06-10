<template>
    <div class="my-page">
        <div class="box-head">
            <div class="user-info">
                <div class="user-avatar"><img src="@/assets/img/my/user.jpg" alt=""></div>
                <div class="info">
                    <h3>{{ userInfo.username }}</h3>
                    <div class="info-detail"> <span class="key">等级</span><span>:</span> <span class="value">{{
                        userInfo.level }}</span>
                    </div>
                    <div class="info-detail"> <span class="key">余额</span><span>:</span> <span class="value">{{
                        userInfo.money }}</span><font-awesome-icon :class="{ activeReload: activeIconReload }"
                            @click="reloadUserMoney()" class="icon" :icon="['fas', 'rotate']" /></div>
                </div>
            </div>
            <div class="action">
                <router-link class="link" to="/"><img src="@/assets/img/my/recharge.png" alt="">
                    <p class="text">充值</p>
                </router-link>
                <span class="line"></span>
                <router-link class="link" to="/"><img src="@/assets/img/my/withdraw.png" alt="">
                    <p class="text">提现</p>
                </router-link>
            </div>
        </div>
        <div class="menu-bar">
            <ul class="menu-list" ref="menuBar">
                <li class="menu-item" :class="{ active: activeMenuBar == 0 }" @click="handleActiveMenuBar(0)">
                    <img class="icon" src="@/assets/img/my/icon1.png" alt=""><span class="text">个人资料</span>
                </li>
                <li class="menu-item" :class="{ active: activeMenuBar == 1 }" @click="handleActiveMenuBar(1)">
                    <img class="icon" src="@/assets/img/my/icon10.png" alt=""> <span class="text">账单明细</span>
                </li>
                <li class="menu-item"><img class="icon" src="@/assets/img/my/email.png" alt=""> <span
                        class="text">站内信</span><router-link class="link" to="#"></router-link></li>
                <li class="menu-item"><img class="icon" src="@/assets/img/my/users.png" alt=""> <span
                        class="text">代理中心</span> <router-link class="link" to="#"></router-link></li>
                <li class="line"></li>
            </ul>

            <ul class="menu-detail-list">
                <!-- 个人资料 -->
                <li class="menu-detail-item" :class="{ active: activeMenuBar == 0 }">
                    <ul class="sub-menu-list">
                        <li class="sub-menu-item" v-for="item, index in personInfo" :key="index">
                            <div class="left">
                                <img class="icon" :src="item.icon" alt="">
                                <p class="text">{{ item.text }}</p>
                            </div>
                            <font-awesome-icon :icon="['fas', 'chevron-right']" />
                            <router-link class="link" :to="item.link"></router-link>
                        </li>
                        <li class="sub-menu-item">
                            <div class="left">
                                <img class="icon" src="@/assets/img/my/exit.png" alt="">
                                <p class="text">退出账号</p>
                            </div>
                            <font-awesome-icon :icon="['fas', 'chevron-right']" />
                        </li>
                    </ul>
                </li>

                <!-- 账单明细 -->
                <li class="menu-detail-item" :class="{ active: activeMenuBar == 1 }">
                    <ul class="sub-menu-list">
                        <li class="sub-menu-item" v-for="item, index in billingDetails" :key="index">
                            <div class="left">
                                <img class="icon" :src="item.icon" alt="">
                                <p class="text">{{ item.text }}</p>
                            </div>
                            <font-awesome-icon :icon="['fas', 'chevron-right']" />
                            <router-link class="link" :to="item.link"></router-link>
                        </li>

                    </ul>
                </li>
            </ul>

        </div>

    </div>
</template>


<script>
import card from '@/assets/img/my/card.png'
import icon1 from '@/assets/img/my/icon1.png'
import icon2 from '@/assets/img/my/icon2.png'
import icon3 from '@/assets/img/my/icon3.png'
import icon4 from '@/assets/img/my/icon4.png'
import icon5 from '@/assets/img/my/icon5.png'
import icon6 from '@/assets/img/my/icon6.png'
import icon7 from '@/assets/img/my/icon7.png'
import icon8 from '@/assets/img/my/icon8.png'

export default {
    components: {

    },
    data() {
        return {
            activeMenuBar: 0,
            personInfo: [
                {
                    icon: icon1,
                    text: '个人信息',
                    link: '/#',
                },
                {
                    icon: card,
                    text: '提款账号管理',
                    link: '/#'
                },
                {
                    icon: icon2,
                    text: '密码设置',
                    link: '/#'
                },
                {
                    icon: icon3,
                    text: '帮助中心',
                    link: '/#'
                }
            ],
            billingDetails: [
                {
                    icon: icon4,
                    text: '投注记录',
                    link: '/#',
                },
                {
                    icon: icon5,
                    text: '账变记录',
                    link: '/#'
                },
                {
                    icon: icon6,
                    text: '充值记录',
                    link: '/#'
                },
                {
                    icon: icon7,
                    text: '提现记录',
                    link: '/#'
                },
                {
                    icon: icon8,
                    text: '个人盈亏',
                    link: '/#'
                }
            ],
            userInfo: {
                username: 'ceshi2233',
                level: 'vip1',
                money: '19007'
            },
            activeIconReload: false
        }
    },
    methods: {
        handleActiveMenuBar(menuIndex) {
            this.activeMenuBar = menuIndex
            const menuBar = this.$refs.menuBar;
            const elementOfsetLeft = menuBar.querySelectorAll('.menu-item')[menuIndex].offsetLeft
            menuBar.lastChild.style.left = elementOfsetLeft + 'px'

        },
        reloadUserMoney() {
            this.activeIconReload = true;
            console.log('reload user money')
        }
    }
}
</script>
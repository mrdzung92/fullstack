<template>
    <div class="history-page">
        <van-nav-bar :title="headerTitle" left-text="Back" left-arrow @click-left="() => { this.$router.go(-1) }" />
        <div class="head">
            <div class="box-time">
                <div class="start-time">
                    <van-icon name="tosend" />
                    <p class="time" @click="showStartTime = true">{{ startTime }}</p>
                    <van-calendar v-model:show="showStartTime" @confirm="selectStartTime" />
                </div>
                <div class="end-time">
                    <van-icon name="tosend" />
                    <p class="time" @click="showStartTime = true">{{ startTime }}</p>
                    <van-calendar v-model:show="showStartTime" @confirm="selectStartTime" />
                </div>
                <div class="search-btn">
                    <van-icon name="search" />
                </div>
            </div>
            <van-tabs v-model:active="active" sticky title-active-color="#1989fa">
                <van-tab v-for=" item, index   in  tabs " :title="item" :key="index">

                </van-tab>
            </van-tabs>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            rechargeHistory: [],
            headerTitle: 'Recharge History',
            showStartTime: false,
            showEndTime: false,
            startTime: '',
            endTime: '',
            tabs: [
                'all',
                'success',
                'fail',
                'pending'
            ]
        };
    },
    created() {
        this.initDate();
    },
    methods: {
        selectStartTime(date) {
            this.showStartTime = false;
            this.startTime = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
        },
        selectEndTime(date) {
            this.showEndTime = false;
            this.endTime = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
        },

        initDate() {
            const date = new Date();
            this.startTime = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
            this.endTime = `${date.getMonth() + 1}/${date.getDate()}`;
        }
    }
}
</script>

<style lang="scss" scoped>
.history-page {


    .head {
        padding: 0 1rem;

        .box-time {
            display: flex;
            margin: 1rem 0rem;

            .start-time,
            .end-time {
                flex: 1;
                display: flex;
                align-items: center;
                background: #fff;
                border: 1px solid var(--color-border);
                padding: 2px 6px;
                border-radius: 4px;

                .time {
                    margin: 0 10px;
                }



            }

            .start-time {
                margin-right: 1rem;
            }

            .search-btn {
                margin-left: 1rem;

                .van-icon {
                    font-size: 2.4rem;
                    line-height: 3rem;

                }
            }

        }






    }
}
</style>

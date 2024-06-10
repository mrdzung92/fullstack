<template>
    <div class="navigation">
        <ul ref="ulRef">
            <li v-for="item, index in navigator" :class="{ active: activeIndex == index }" @click="handleChange(index)">
                <router-link :to="item.path">
                    <span class="icon"><i>&nbsp;</i></span>
                    <span class="text">{{ item.text }}</span>
                </router-link>
            </li>
            <div class="indicator" ref="indicator"></div>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            navigator: [
                {
                    text: 'Home',
                    path: '/'
                },
                {
                    text: 'Products',
                    path: '#'
                },
                {
                    text: 'Anouncements',
                    path: '#'
                },
                {
                    text: 'Cart',
                    path: '#'
                },
                {
                    text: 'My',
                    path: '/My'
                },
            ],
            activeIndex: 0
        }
    },
    methods: {
        handleChange(index) {
            this.activeIndex = index;
            this.handleIndicator(this.activeIndex)
        },
        handleIndicator() {
            const ulRef = this.$refs.ulRef;
            const indicator = this.$refs.indicator;
            const li = ulRef.children[this.activeIndex].querySelector('a .icon');
            const liRect = li.getBoundingClientRect();
            indicator.style.left = `${liRect.left - liRect.width / 2}px`;
        },
        windowResize() {
            this.handleIndicator(this.activeIndex)
        }
    },

    mounted() {
        this.handleIndicator(this.activeIndex)
        window.addEventListener('resize', this.windowResize)
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.windowResize)
    }
}
</script>
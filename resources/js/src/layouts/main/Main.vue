<!-- =========================================================================================
    File Name: Main.vue
    Description: Main layout
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div class="layout--main">
    <div class="relative">
      <div class="vx-navbar-wrapper navbar-full p-5">
        <vs-navbar
          class="navbar-custom navbar-skelton"
          :color="navbarColor"
          style="border-radius: 10px"
        >
          <router-link
            tag="div"
            to="/"
            class="vx-logo cursor-pointer mx-auto flex items-center"
          >
            <logo class="w-10 mr-4 fill-current text-primary" />
            <span class="vx-logo-text text-primary">Hungry</span>
          </router-link>
        </vs-navbar>
      </div>
    </div>

    <div id="content-overlay" />

    <div
      id="content-area"
      :class="['content-area-full', { 'show-overlay': bodyOverlay }]"
    >
      <div class="content-wrapper">
        <div class="router-view">
          <div class="router-content">
            <transition :name="routerTransition" mode="out-in">
              <router-view
                @changeRouteTitle="changeRouteTitle"
                @setAppClasses="
                  (classesStr) => $emit('setAppClasses', classesStr)
                "
              />
            </transition>

            <div class="content-area__content">
              <back-to-top
                bottom="5%"
                :right="$vs.rtl ? 'calc(100% - 2.2rem - 38px)' : '30px'"
                visibleoffset="500"
              >
                <vs-button
                  icon-pack="feather"
                  icon="icon-arrow-up"
                  class="shadow-lg btn-back-to-top"
                />
              </back-to-top>
            </div>
          </div>
        </div>
      </div>
      <the-footer />
    </div>
  </div>
</template>

<script>
import Logo from "@/layouts/components/Logo.vue";
import BackToTop from "vue-backtotop";
import TheFooter from "@/layouts/components/TheFooter.vue";
import themeConfig from "@/../themeConfig.js";

export default {
  components: {
    Logo,
    BackToTop,
    TheFooter,
  },
  data() {
    return {
      routerTransition: themeConfig.routerTransition || "none",
      routeTitle: this.$route.meta.pageTitle,
    };
  },
  watch: {
    $route() {
      this.routeTitle = this.$route.meta.pageTitle;
    },
  },
  computed: {
    navbarColor() {
      let color = "#fff";
      if (this.scrollY < 50) {
        color = "#f7f7f7";
      }

      return color;
    },
    bodyOverlay() {
      return this.$store.state.bodyOverlay;
    },
  },
  methods: {
    changeRouteTitle(title) {
      this.routeTitle = title;
    },
  },
  created() {},
};
</script>

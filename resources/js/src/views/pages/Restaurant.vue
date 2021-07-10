<template>
  <div id="search-page">
    <div class="search-page__search-bar">
      <vx-input-group class="mb-base">
        <vs-input
          icon-no-border
          placeholder="Where are you hungry at?"
          v-model="searchQuery"
          class="w-full input-rounded-full"
          icon="icon-search"
          icon-pack="feather"
        />

        <template slot="append">
          <div class="append-text btn-addon">
            <vs-button
              color="primary"
              class="button-round-right"
              @click="search"
              >{{ loading ? "loading" : "search" }}</vs-button
            >
          </div>
        </template>
      </vx-input-group>
    </div>

    <div>
      <div class="items-grid-view vx-row match-height">
        <Place v-for="item in results" :key="item.place_id" :item="item" />
      </div>
    </div>

    <div class="flex justify-center" v-if="results.length > 0">
      <vs-button
        type="gradient"
        class="w-1/2 mt-6"
        :color="nextPage ? '#7367F0' : '#626366'"
        :gradient-color-secondary="nextPage ? '#CE9FFC' : '#b5b7bd'"
        @click="getMore"
        >{{
          loading ? "loading" : nextPage ? "WANT MORE 🍔?" : "THAT'S ALL I HAVE"
        }}</vs-button
      >
    </div>
  </div>
</template>

<script>
import axios from "@/axios.js";
import Place from "@/components/Place.vue";

export default {
  components: {
    Place,
  },
  data() {
    return {
      loading: false,
      nextPage: null,
      searchQuery: "Bang sue",
      results: [],
    };
  },
  mounted() {
    this.search();
  },
  methods: {
    goToMap(placeId) {
      window
        .open(
          `https://www.google.com/maps/place/?q=place_id:${placeId}`,
          "_blank"
        )
        .focus();
    },
    async search() {
      try {
        if (this.loading) {
          return true;
        }
        this.loading = true;
        let { data } = await axios.get(
          `/api/restaurant/search?query=${this.searchQuery}`
        );
        if (data.status === "OK") {
          this.results = data.results;
          this.nextPage = data.next_page_token || null;
        }
        this.loading = false;
      } catch (error) {
        this.loading = false;
      }
    },
    async getMore() {
      try {
        if (this.loading || !this.nextPage) {
          return;
        }
        this.loading = true;
        let { data } = await axios.get(
          `/api/restaurant/nextPage?token=${this.nextPage}`
        );
        if (data.status === "OK") {
          this.results = this.results.concat(data.results);
          this.nextPage = data.next_page_token || null;
        }
        this.loading = false;
      } catch (error) {
        this.loading = false;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.search-tab-filter {
  padding: 0.5rem 1rem;
  border-radius: 25px;
  margin-right: 1rem;
  margin-bottom: 1.5rem;
  background: #fff;
  // box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08);
  cursor: pointer;
}

.button-round-right {
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
}
</style>

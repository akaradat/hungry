<template>
  <div class="vx-col lg:w-1/3 sm:w-1/2 w-full">
    <div class="vx-col w-full">
      <vx-card class="grid-view-item mb-base overflow-hidden 1234">
        <template slot="no-body">
          <!-- ITEM IMAGE -->
          <div
            class="
              item-img-container
              bg-white
              h-64
              flex
              items-center
              justify-center
              mb-4
            "
          >
            <img
              :src="item.image"
              :alt="item.name"
              class="grid-view-img px-4"
            />
          </div>
          <div class="item-details px-4">
            <!-- RATING & PRICE -->
            <div class="flex justify-end items-center">
              <div
                class="
                  text-warning
                  border border-solid border-warning
                  flex
                  py-1
                  px-2
                  rounded
                "
              >
                <span class="text-sm mr-1">{{ item.rating }}</span>
                <feather-icon icon="StarIcon" svgClasses="h-4 w-4" />
              </div>
            </div>

            <!-- TITLE & DESCRIPTION -->
            <div class="my-4">
              <h6
                class="
                  truncate
                  font-semibold
                  mb-1
                  hover:text-primary
                  cursor-pointer
                "
                @click="goToMap(item.place_id)"
              >
                {{ item.name }}
              </h6>
              <p class="item-description truncate text-sm">
                {{ item.address }}
              </p>
            </div>
          </div>

          <div
            class="
              item-view-secondary-action-btn
              bg-primary
              p-3
              flex flex-grow
              items-center
              justify-center
              text-white
              cursor-pointer
            "
            @click="goToMap(item.place_id)"
          >
            <feather-icon icon="MapIcon" svgClasses="h-4 w-4" />

            <span class="text-sm font-semibold ml-2">VIEW IN GOOGLE MAP</span>
          </div>
        </template>
      </vx-card>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
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
  },
};
</script>

<style lang="scss" scoped>
.grid-view-item {
  .grid-view-img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    transition: 0.35s;
  }

  &:hover {
    transform: translateY(-5px);
    box-shadow: 0px 4px 25px 0px rgba(0, 0, 0, 0.25);

    .grid-view-img {
      opacity: 0.9;
    }
  }
}
</style>

<template>
  <div class="map-search-container">
    <el-amap-search-box class="search-box"
                        :search-option="searchOption"
                        :on-search-result="onSearchResult"></el-amap-search-box>
    <amap :center="mapCenter"
          @click="onClick">
      <el-amap-marker v-for="(marker,index) in markers"
                      :key="index"
                      :position="marker"></el-amap-marker>
    </amap>
  </div>
</template>

<script>
import Amap from '@/common/components/FormControls/Amap'
export default {
  name: 'AMapSearch',
  components: {
    Amap
  },
  data: () => ({
    searchOption: {
      city: '惠州',
      citylimit: true
    },
    markers: [],
    mapCenter: [114.414659, 23.11059]
  }),
  methods: {
    addMarker() {
      const lng = 121.5 + Math.round(Math.random() * 1000) / 10000
      const lat = 31.197646 + Math.round(Math.random() * 500) / 10000
      this.markers.push([lng, lat])
    },
    onSearchResult(pois) {
      let latSum = 0
      let lngSum = 0
      if (pois.length > 0) {
        pois.forEach(poi => {
          const { lng, lat } = poi
          lngSum += lng
          latSum += lat
          this.markers.push([poi.lng, poi.lat])
        })
        const center = {
          lng: lngSum / pois.length,
          lat: latSum / pois.length
        }
        this.mapCenter = [center.lng, center.lat]
      }
    },
    onClick(data) {
      this.$emit('click', data)
    }
  }
}
</script>

<style lang="scss" scoped>
.map-search-container {
    position: relative;
    height: 100%;
}
.search-box {
    position: absolute;
    top: 25px;
    left: 20px;
}
</style>

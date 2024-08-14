<template>
  <iframe :src='"/user/clips/"+ allData.id + currentPageQueryString' id='display_frame' :style="`width:${dimensions.width};height:${dimensions.height}`"></iframe>
</template>

<script>



export default {
    name: 'PreviewIframe',
    data(){
      return {allData: {id: 1}, dimensions: {width: '100%', height: '100%'}, currentPageQueryString: ''}
    },
    mounted(){
      this.allData = siteData;

      switch(this.allData.type){
        case "clip":
          this.dimensions.width = this.allData.clip.width;
          this.dimensions.height = this.allData.clip.height;
        break;
        case "clip_template":
          this.dimensions.width = this.allData.clipTemplate.width;
          this.dimensions.height = this.allData.clipTemplate.height;
        break;
      }

      console.log(this.dimensions);

      var url = new URL(window.location.href);
      this.currentPageQueryString = url.search;

    }
}
</script> 
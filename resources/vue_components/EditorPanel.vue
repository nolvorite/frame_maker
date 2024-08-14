<template>
  <div id='frame_editor_panel' class='card'>
    <div v-if="allData.type === 'clip_template'" id='template_editor'>
      <div class="card-header">Editing Clip Template<button class='btn float-end btn-warning' @click="reloadIframe">Refresh Clip</button></div>

      <div class="card-body">       
        <div class="form-group mb-3">
            <label for="frame_name_input">Template Name</label>

            <input id="frame_name_input" name="frame_name" :value="allData.clipTemplate.frame_name" required="" type="text" class="form-control" aria-describedby="frame_name_input" placeholder="Frame Name">

        </div>

        <div class="form-group mb-3">
            <label for="frame_description_input">Template Description</label>

            <textarea id="frame_description_input" :value="allData.clipTemplate.frame_description" name="frame_description" class="form-control" aria-describedby="frame_description_input" placeholder="Frame Description"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="json_data_input">JSON Data</label>

            <json-editor-vue v-model="value2" :mode="Mode.text" class="jse-theme-dark"></json-editor-vue>
        </div>

        <div class="form-group mb-3">
            <label for="json_data_input">Dimensions</label>

            <div class="row">
                <div class="col-lg-5">
                    <input id="width_input" name="width" :value="allData.clipTemplate.width" value="1920px" required="" type="text" class="form-control col-lg-4" aria-describedby="width_input" placeholder="Width">
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <input id="height_input" name="height" :value="allData.clipTemplate.height" value="1080px" required="" type="text" class="form-control col-lg-4" aria-describedby="height_input" placeholder="Height">
                </div>
            </div>
        </div>

        <div class="mt-5 text-end">
            <button type="submit" class="btn btn-block btn-primary">Update Clip Template</button>
        </div>
      </div>
      
    </div>
    <form id="clip_editor" v-if="allData.type === 'clip'">
      <div class="card-header">Editing Clip&nbsp;&nbsp;

      <div class="btn-group" role="group">
        <a class='btn float-end btn-primary' :href="`/user/clips/${allData.clip.id}`" target="_blank">View Clip</a>
        <button class='btn float-end btn-warning' @click="reloadIframe">Refresh Clip</button>
      </div>

      

      </div>
        <div class="card-body">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">



          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-properties-tab" data-bs-toggle="pill" data-bs-target="#pills-properties" type="button" role="tab" aria-controls="pills-properties" aria-selected="true">Properties</button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-html-tab" data-bs-toggle="pill" data-bs-target="#pills-html" type="button" role="tab" aria-controls="pills-html" aria-selected="false">HTML</button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-css-tab" data-bs-toggle="pill" data-bs-target="#pills-css" type="button" role="tab" aria-controls="pills-css" aria-selected="false">CSS</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-properties" role="tabpanel" aria-labelledby="pills-properties-tab" tabindex="0">
            <div class="form-group mb-3">
                <label for="clip_name_input">Clip Name</label>

                <input id="clip_name_input" name="clip_name" :value="allData.clip.clip_name" required="" type="text" class="form-control" aria-describedby="clip_name_input" placeholder="Frame Name">

            </div>

            <div class="form-group mb-3">
                <label for="frame_description_input">Template Name</label>

                <input readonly :value="allData.clipTemplate.frame_name" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="json_data_input" class="mb-3">JSON Data <button class='btn btn-sm btn-success' @click="copyToJson">Copy current parameters</button></label>

                <json-editor-vue v-model="JSONData" :mode="Mode.text" class="jse-theme-dark"></json-editor-vue>
            </div>

            <div class="form-group mb-3">
                <label for="json_data_input">Dimensions</label>

                <div class="row">
                    <div class="col-lg-5">
                        <input id="width_input" name="width" :value="allData.clip.width" value="1920px" required="" type="text" class="form-control col-lg-4" aria-describedby="width_input" placeholder="Width">
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <input id="height_input" name="height" :value="allData.clip.height" value="1080px" required="" type="text" class="form-control col-lg-4" aria-describedby="height_input" placeholder="Height">
                    </div>
                </div>
            </div>

            <div class="mt-5 text-end">
              <button type="submit" class="btn btn-block btn-primary" @click="updateClip">Update Clip</button>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-css" role="tabpanel" aria-labelledby="pills-css-tab" tabindex="0">

              <textarea id='css_editor' v-model="cssEditor" placeholder="Your CSS can be edited here. It will automatically be saved by the server." class='form-control' style='min-height:300px;'></textarea>

          </div>
          <div class="tab-pane fade" id="pills-html" role="tabpanel" aria-labelledby="pills-html-tab" tabindex="0"></div>

        </div>

        
      </div>
    </form>
  </div>

</template>

<script setup>
  import { Mode } from 'vanilla-jsoneditor';
  import axios from 'axios';
  import Swal from 'sweetalert2/src/sweetalert2.js';
  import debounce from 'lodash.debounce';
  import { ref, reactive, watch } from 'vue';


</script>

<script>

const value = ref();
const cssEditor = ref();

export default {
    name: 'EditorPanel',
    data(){
      return {allData: {id: 1, clipTemplate: {frame_name: ''}, clip: {clip_name: '', id: ''}, type: 'clip'},JSONData: {}, debounceFn: null,cssEditor: null}
    },
    mounted(){
      this.allData = siteData;
      this.JSONData = siteData.clip.custom_json_data;

      cssEditor.value = siteData.clip.css;

      try {
        watch(cssEditor, debounce((input) => {
          
          this.updateCSS(input);

        }, 500))
      }catch(error){
        console.log(error);
      }

      

    },
    methods: {
      newIframeURL(url){
        document.getElementById("display_frame").src = url;
      },
      updateCSS(css){
        var formData = new FormData();
        formData.append('css',css);
        formData.append('_method','PUT');
        formData.append('_token',this.allData.csrf);

        document.getElementById('display_frame').contentWindow.document.getElementById('custom_clip_style').innerHTML = css;

        var id = this.allData.type === 'clip' ? this.allData.clip.id : this.allData.clipTemplate.id;

        axios.post('/user/clips/'+id+'?action=edit_css&type='+ this.allData.type, formData)
         .catch(error => {
           Swal.fire({
              title: 'Update Failed',
              icon: 'error',
              text: 'Failed to update CSS. Please try again.'
            });
         });
      },
      reloadIframe(event){
        event.preventDefault();
        document.getElementById("display_frame").src += "";
      },
      snakeToCamel(str){
          return str.toLowerCase().replace(/([-_][a-z])/g, group =>
            group
              .toUpperCase()
              .replace('-', '')
              .replace('_', '')
          );
      },
      delay(fn, ms) {
        let timer = 0;
        return function (...args) {
          clearTimeout(timer);
          timer = setTimeout(fn.bind(this, ...args), ms || 0);
        };
      },
      updateClip(event){

        event.preventDefault();

        var formData = new FormData(document.getElementById("clip_editor"));

        var data = typeof this.JSONData === 'string' ? this.JSONData : JSON.stringify(this.JSONData);

        formData.append('data',data);

        formData.append('_token',this.allData.csrf);

        formData.append('_method','PUT');

        var id = this.allData.type === 'clip' ? this.allData.clip.id : this.allData.clipTemplate.id;

        axios.post('/user/clips/'+id+'?type='+ this.allData.type, formData)
         .then(response => {
           Swal.fire({
            title: 'Success!',
            icon: 'success',
            text: 'Successfully updated clip details. Reloading clip...'
          });

          this.newIframeURL('/user/clips/'+id);

         })
         .catch(error => {
           Swal.fire({
              title: 'Update Failed',
              icon: 'error',
              text: 'Failed to update clip. Please try again.'
            });
         });
      },
      copyToJson(event){

          event.preventDefault();

          var url = new URL(window.location.href);

          for(const [key, value] of url.searchParams){
            var newKey = this.snakeToCamel(key);
            this.JSONData[newKey] = value;
          }

      }
    },
    components: {
      Mode
    }
}
</script>
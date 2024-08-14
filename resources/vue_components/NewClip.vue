<template>
	<form method="POST" action="/user/clips?type=clip" class="card">
		<input name="_token" :value="allData.csrf" type="hidden">
		<div class='card-header'>Create New Clip</div>
		<div class='card-body'>
		  <div class="form-group mb-3">
		    <label for="clip_name">Clip Name</label>

		    <input 
		    id="clip_name_input" 
		    name="clip_name"

		    required
		    type="text" 
		    class="form-control" 
		    aria-describedby="clip_name_input" 
		    placeholder="Clip Name">

			</div>
			<div class="form-group mb-3">
		    <label for="clip_template_id">Clip Template To Use</label>

		    <select @change="addJSONTemplate" name="clip_template_id" class='form-control' aria-describedby="clip_template_id">
		    	<option :value="template.id" v-for="template in allData.clipTemplates">{{ template.frame_name }}</option>
		    </select>

			</div>
			<div class="form-group mb-3">
				<label for="json_data_input">JSON Data</label>

				<json-editor-vue v-model="initialJSON" :mode="Mode.text" class="jse-theme-dark" @change="modifyJsonInput"></json-editor-vue>

				<input type='hidden' :value='custom_json_data' name="data">


			</div>

		<div class="form-group mb-3">
			<label for="json_data_input">Dimensions</label>
			<div class="row">
			<div class="col-lg-5">
			<input 
			id="width_input" 
			name="width"
			type="text" 
			class="form-control col-lg-4" 
			aria-describedby="width_input" 
			placeholder="Width">
			</div>
			<div class="col-lg-5 offset-lg-1">
			<input 
			id="height_input" 
			name="height"
			type="text" 
			class="form-control col-lg-4" 
			aria-describedby="height_input" 
			placeholder="Height">
			</div>
			</div>

			<div class="mt-5 text-end">
			<button type="submit" class="btn btn-block btn-primary">Create New Clip</button>
			</div>

			</div>
		</div>
        
  </form>
</template>
<script setup>
import { Mode } from 'vanilla-jsoneditor';
import VueCoreImageUpload  from 'vue-core-image-upload';
import JsonEditorVue from 'json-editor-vue';

</script>

<script>

import { ref } from 'vue';

export default {
    name: 'NewClip',
    data(){
      return {
      	allData: {
      		id: 1, 
      		clipTemplates: [],
      		csrf: ''
      	}, 
      	custom_json_data: '', 
      	initialJSON: {
          url: ""
        }
      }
    },
    mounted(){
      this.allData = siteData;
      console.log(siteData);
    },
    methods: {
      afterUpload: function(response){

      },
      modifyJsonInput: function(content){
      	this.custom_json_data = content.text;
      },
      addJSONTemplate: function(event){
      	//fetch JSON to get

      	for(var i in this.allData.clipTemplates){
      		var dt = this.allData.clipTemplates[i];

      		if(dt.id+'' === event.target.value+''){
      			this.custom_json_data = dt.json_data;
      			this.initialJSON = dt.json_data;
      		}
      	}
      }
    },
    components: {
      Mode,
      VueCoreImageUpload,
      JsonEditorVue
    }
}
</script>
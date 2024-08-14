<template>
	<div class="card mb-3">
        <div class="card-header">Images (Total: {{ total }})</div>
        <div class="card-body">
        	<div class='image-collection'>
        		<img :src="`/storage/${image.id}/${image.file_name}`" :alt='`Image Name: ${image.file_name}`' v-for="image in images" class='mini-image' @click="copyToClipboard(image)">
        	</div>
        </div>
    </div>
    <div class="card">
    	<div class='card-header'>Add Images...</div>
    	<div class='card-body'>
    		<div class="form-group mb-3">
	        	<label>Use Image...</label>

	        	<vue-core-image-upload
				  :class="['btn', 'btn-primary', 'd-block', 'mb-3']"
				  :crop="true"
				  @imageuploaded="afterUpload"
				  :max-file-size="5242880"
				  url="user/media" >
				</vue-core-image-upload>
	        </div>

	        <form class="form-group mb-3" id="upload_from_clipboard">
	        	<label>Or Upload From Clipboard...</label>

	        	<div id="image_clipboard" class="mb-3" contenteditable @paste="uploadFromClipboard" @click="clearText">
	        	<span>Upload your images from clipboard here.</span>
	        	</div>

	        	<div>
	  
	        	</div>
	        </form>
    	</div>
    </div>
</template>

<script setup>
import Swal from 'sweetalert2/src/sweetalert2.js';
import axios from 'axios';
import { Mode } from 'vanilla-jsoneditor';
import VueCoreImageUpload  from 'vue-core-image-upload';

</script>

<script>

export default {
    name: 'ImagesList',
    data(){
      return {images: [], total: 0, siteData: {appUrl: ''}}
    },
    mounted(){
			this.reloadImages();
			this.siteData.appUrl = siteData.appUrl;
    },
    methods: {
    	afterUpload(){
    		this.reloadImages();
    	},
    	async copyToClipboardFailsafe(textToCopy) {
		    // Navigator clipboard api needs a secure context (https)
		    if (navigator.clipboard && window.isSecureContext) {
		        await navigator.clipboard.writeText(textToCopy);
		    } else {
		        // Use the 'out of viewport hidden text area' trick
		        const textArea = document.createElement("textarea");
		        textArea.value = textToCopy;
		            
		        // Move textarea out of the viewport so it's not visible
		        textArea.style.position = "absolute";
		        textArea.style.left = "-999999px";
		            
		        document.body.prepend(textArea);
		        textArea.select();

		        try {
		            document.execCommand('copy');
		        } catch (error) {
		            console.error(error);
		        } finally {
		            textArea.remove();
		        }
		    }
		},
    	async copyToClipboard(image){
    		var urlToCopy = this.siteData.appUrl+ 'storage/'+ image.id + '/' + image.file_name;
    		console.log(image,urlToCopy);
    		await this.copyToClipboardFailsafe(urlToCopy);

    		Swal.fire({
    			title: 'Success!',
    			icon: 'success',
    			text: 'Successfully copied ' + urlToCopy + ' into your clipboard.'
    		});
    	},
    	clearText(){
    		document.getElementById('image_clipboard').innerHTML = '';
    	},
    	uploadFromClipboard(event){
    		event.preventDefault();

    		var imageFile = event.clipboardData.files[0];

    		var formData = new FormData();

    		formData.append("files",imageFile);

    		 axios.post('/user/media', formData, {
		       headers: {
		         'Content-Type': 'multipart/form-data'
		       }
		     })
		     .then(response => {
		       Swal.fire({
	    			title: 'Success!',
	    			icon: 'success',
	    			text: 'Successfully uploaded file. Reloading Image List...'
	    		});

	    		this.reloadImages();
		     })
		     .catch(error => {
		       Swal.fire({
		    			title: 'Upload Error',
		    			icon: 'error',
		    			text: 'Failed to upload image. Please try again later.'
		    		});
		     });

    	},
    	reloadImages(){
    		axios.get('/user/media')
			.then((response) => {

				if(response.data.status){
					this.total = response.data.images.length;
					this.images = response.data.images;
				}

			});
    	}
    },
    components: {
    	VueCoreImageUpload
    }
}
</script>
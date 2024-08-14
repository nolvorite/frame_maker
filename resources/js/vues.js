import './bootstrap';
import { vue, createApp } from 'vue';

import JsonEditorVue from 'json-editor-vue';
import { Mode } from 'vanilla-jsoneditor';
import VueCoreImageUpload  from 'vue-core-image-upload';
import debounce from 'lodash.debounce'

import interact from 'interactjs'

import NewClip from '../vue_components/NewClip.vue';
import PreviewIframe from '../vue_components/PreviewIframe.vue';
import DrawBoard from '../vue_components/DrawBoard.vue';
import EditorPanel from '../vue_components/EditorPanel.vue';
import ImagesList from '../vue_components/ImagesList.vue';
import Swal from 'sweetalert2/src/sweetalert2.js';
import axios from 'axios';


createApp({
    components: {
        PreviewIframe,
        EditorPanel
    }
}).use(JsonEditorVue).use(Mode).mount('#editor_page_app_wrap');

createApp({
    components: {
        DrawBoard
    }
}).mount('#draw_board');

createApp({
    components: {
        NewClip,
        VueCoreImageUpload,
        ImagesList
    }
})

.use(JsonEditorVue)
.use(Mode)
.use(VueCoreImageUpload)
.use(axios)

.mount('#dashboard');
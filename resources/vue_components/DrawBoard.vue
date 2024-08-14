<template>
  <div id="board_canvas">

  </div>
</template>

<script setup>
import interact from 'interactjs'
</script>

<script>

export default {
    name: 'PreviewIframe',
    data(){
      return {allData: {id: 1}}
    },
    mounted(){

      interact('.interacter').draggable({
        listeners: {
          move (event) {
            if(!event.target.hasAttribute('x')){
              event.target.setAttribute('x',0);
              event.target.setAttribute('y',0);
            }
            var position = {
              x: parseFloat(event.target.getAttribute('x')), 
              y: parseFloat(event.target.getAttribute('y'))
            };

            position.x += event.dx;
            position.y += event.dy;

            event.target.style.transform =
              `translate(${position.x}px, ${position.y}px)`

            event.target.setAttribute('x',position.x);
            event.target.setAttribute('y',position.y);

          }
        },
      });

    }
}
</script> 
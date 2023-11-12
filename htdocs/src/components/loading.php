<style>
    #NotiflixLoadingWrap{
        position: fixed;
        margin: auto;
        /*height: 2em;*/
        /*width: 2em;*/
        width: 0;
        height: 0;
        overflow: show;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }
    /* Transparent Overlay */
    #NotiflixLoadingWrap:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(20, 20, 20,.1), rgba(0, 0, 0, .1));
    }
    
    .hide {
        display: none!important;
    }

</style>
<div id="NotiflixLoadingWrap" class="notiflix-loading nx-with-animation hide" style="z-index: 4000; background: rgb(231, 231, 231); animation-duration: 400ms; font-family: Quicksand, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif; display: flex; flex-flow: column wrap; align-items: center; justify-content: center;">
   <div style="width:80px; height:80px;" class="notiflix-loading-icon nx-with-message">
      <svg xmlns="http://www.w3.org/2000/svg" stroke="#32c682" width="80px" height="80px" viewBox="0 0 44 44">
         <g fill="none" fill-rule="evenodd" stroke-width="2">
            <circle cx="22" cy="22" r="1">
               <animate attributeName="r" begin="0s" calcMode="spline" dur="1.8s" keySplines="0.165, 0.84, 0.44, 1" keyTimes="0; 1" repeatCount="indefinite" values="1; 20"></animate>
               <animate attributeName="stroke-opacity" begin="0s" calcMode="spline" dur="1.8s" keySplines="0.3, 0.61, 0.355, 1" keyTimes="0; 1" repeatCount="indefinite" values="1; 0"></animate>
            </circle>
            <circle cx="22" cy="22" r="1">
               <animate attributeName="r" begin="-0.9s" calcMode="spline" dur="1.8s" keySplines="0.165, 0.84, 0.44, 1" keyTimes="0; 1" repeatCount="indefinite" values="1; 20"></animate>
               <animate attributeName="stroke-opacity" begin="-0.9s" calcMode="spline" dur="1.8s" keySplines="0.3, 0.61, 0.355, 1" keyTimes="0; 1" repeatCount="indefinite" values="1; 0"></animate>
            </circle>
         </g>
      </svg>
   </div>
</div>
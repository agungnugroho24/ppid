<style>
  /*Slide Berita*/
  .slide-berita p{
    color: #ffffff;
     font-size: 14px;
     line-height:1.5em;
     max-height:5em;
     overflow: hidden;
     text-overflow: ellipsis;
     display: -webkit-box;
     -webkit-line-clamp: 3;
     -webkit-box-orient: vertical;
  }
  /*End Slide Berita*/
 
  /*Card custom hover effect*/
 .card-custom-hover {
   transition-duration: 0.4s;
   transition-property: box-shadow;
   -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
   transform: translate(0, -10px);
   box-shadow: 0 0 1px rgba(0, 0, 0, 0);
 }
 .card-custom-hover:hover {
   box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
 }
 
 .header-card-custom{
   background-color: #6c757d;
   color: #ffffff;
 }
 
 .card-custom-hover:hover .card-header{
   background-color: #6c757d;
   color: #ffffff;
   font-weight: 500;
 }
 
 .card-custom-fly {
   transition-duration: 0.4s;
   transition-property: box-shadow;
   -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
   transform: scale(101%);
   box-shadow: 0 0 1px rgba(0, 0, 0, 0);
 }
 .card-custom-fly:hover {
   box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
   border: none;
   background: rgb(253, 254, 255);
 }
 
 .card-custom:hover{
   background-color: #6c757d;
   color: #ffffff;
   font-weight: 600;
   border: none;
 }
 
 .card-custom:hover .card-body{
   background: rgb(255, 255, 255);
   color: rgb(141, 141, 141);
   font-weight: 400;
 }
 
 .card-custom:hover button{
   color:rgb(255, 255, 255);
   font-weight:600;
 }
 
 a.btn-read-custom:hover{
   background: rgb(254, 254, 255);
   color: rgb(89, 89, 89);
   font-weight: 600;
 }
 
   /*End Card custom hover effect*/
 
 
 /* Float Shadow */
 /*.card-custom-hover {
   display: inline-block;
   position: relative;
   transition-duration: 0.3s;
   transition-property: transform;
   -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
   transform: translate(0, -20px);
   box-shadow: 0 0 1px rgba(0, 0, 0, 0);
 }
 .card-custom-hover:before {
   pointer-events: none;
   position: absolute;
   z-index: -1;
   content: "";
   top: 100%;
   left: 5%;
   height: 10px;
   width: 90%;
   opacity: 0;
   background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
   transition-duration: 0.3s;
   transition-property: transform opacity;
 }
 .card-custom-hover:hover {
   transform: translateY(-5px);
 }
 .card-custom-hover:hover:before {
   opacity: 1;
   transform: translateY(5px);
 }*/
 
 
 
   /*header top custom*/
   .header-top-custom{
     margin-top: 0;
     width: auto;
     height: 50px;
     background-color: #f9f9f9;
   }
   /*end header top custom*/
 
   /*select2 custom*/
   .select2-selection__rendered {
       line-height: 35px !important;
   }
   .select2-container .select2-selection--single {
       height: 39px !important;
   }
   .select2-selection__arrow {
       height: 38px !important;
   }  
   /*endselect2 custom*/
 
   /* css readmore */
   #info + .readmore-js-toggle { padding-bottom: 1.5em; border-bottom: 1px solid #999; font-weight: bold;}
   #white-shadow{
     position:relative;
   }
 
   #white-shadow:after{
     background: linear-gradient(to bottom, rgba(255, 255, 255, 0), #f9f9f9 85%);
     bottom: 100%;
     content: '';
     display: inline-block;
     height: 150px;
     position: absolute;
     right: 0;
     width: 100%;
   }
   /* end of css readmore */
 
   
   /* css navbar */
   @media screen and (max-width: 800px) and (min-width: 300px) {  
     .mobile{
       display: block;
     }
     .window{
       display: none;
     }
 
     /*header top custom*/
     .header-top-custom{
       margin-top: 0;
       width: auto;
       height: 60px;
       background-color: #333;
     }
     /*end header top custom*/    
   }
 
   @media screen and (max-width: 1920px) and (min-width: 801px) {  
     .mobile{
       display: none;
     }
     .window{
       display: block;
     }
   }
   /* end of css navbar */
 
   /* css berita */
   @media screen and (max-width: 800px) and (min-width: 200px) {  
     #gadget{
       display: block;
     }
     #desktop{
       display: none;
     }
 
     /*header top custom*/
     .header-top-custom{
       margin-top: 0;
       width: auto;
       height: 60px;
       background-color: #333;
     }
     /*end header top custom*/    
   }
 
   @media screen and (max-width: 1920px) and (min-width: 801px) {  
     #gadget{
       display: none;
     }
     #desktop{
       display: block;
     }
   }
   /* end of css berita */
 
   /* css search navbar */
   #cari {
     display:block;
     margin: 0 0 0 auto;
     width: 100px;
     box-sizing: border-box;
     border: 2px solid #ccc;
     border-radius: 4px;
     font-size: 16px;
     background-color: white;
     background-image: url('{{ asset('img/searchicon.png') }}');
     background-position: right;
     background-repeat: no-repeat;
     padding: 12px 20px 12px 10px;
     -webkit-transition: width 0.4s ease-in-out;
     transition: width 0.4s ease-in-out;
   }
 
   #cari:focus {
     width: 100%;
   }
 
   #mobile {
     margin-left: 5%;
     width: 130px;
     height: 40px;
     box-sizing: border-box;
     border: 2px solid #ccc;
     border-radius: 4px;
     background-color: white;
     background-image: url('{{ asset('img/searchicon.png') }}');
     background-position: 10px 10px; 
     background-repeat: no-repeat;
     padding: 12px 20px 12px 40px;
     -webkit-transition: width 0.4s ease-in-out;
     transition: width 0.4s ease-in-out;
   }
   #mobile:focus {
     width: 90%;
   }
   /* end of css search navbar */
 
   /* css button alur informasi */
   #alur {
     display: block;
     position: fixed;
     bottom: 10px;
     right: 5%;
     z-index: 99;
     font-size: 15px;
     border: none;
     outline: none;
     background-color: #3ec1d5;
     color: white;
     cursor: pointer;
     padding: 10px;
     border-radius: 5px;
     font-family: 'Cookie', cursive;
     transition: 1s;
     -webkit-tap-highlight-color: transparent;
     display: flex;
     align-items: center;
     justify-content: center;
     cursor: pointer;
   }
 
   #alur #circle {
     width: 5px;
     height: 5px;
     background: transparent;
     border-radius: 50%;
     position: absolute;
     top: 0;
     left: 50%;
     overflow: hidden;
     transition: 500ms;
     color: #000000;
     font-weight: 900;
   }
 
   .noselect {
   -webkit-touch-callout: none;
     -webkit-user-select: none;
     -khtml-user-select: none;
     -moz-user-select: none;
       -ms-user-select: none;
         user-select: none;
   }
 
   #alur:hover {
     background: transparent;
     color: #000000;
     font-weight: 900;
   }
 
   #alur:hover #circle {
     height: 50px;
     width: 130px;
     left: 0;
     border-radius: 0;
     border-bottom: 2px solid #000000;
     color: #000000;
     font-weight: 900;
   }
 
   @media screen and (max-width: 800px) and (min-width: 300px) {  
     #alur {
       display: block;
       position: fixed;
       bottom: 10px;
       left: 5%;
       z-index: 99;
       font-size: 15px;
       border: none;
       outline: none;
       background-color: #3ec1d5;
       color: white;
       cursor: pointer;
       padding: 10px;
       border-radius: 5px;
       font-family: 'Cookie', cursive;
       transition: 1s;
       -webkit-tap-highlight-color: transparent;
       display: flex;
       align-items: center;
       justify-content: center;
       cursor: pointer;
     }
   }
   /* end of css button alur informasi */
 
 /* Card informasi permohonan dan kunjungan */
 .pri_table_list{
   border-radius: 5px;
   background: #fff;
   padding: 30px 18px;
 }
 
 /*** effect - shadow 3 ***/
 .shadow-3:hover
 {
 transform:scale(1.05);
 -webkit-transform:scale(1.05);
 -moz-transform:scale(1.05);
 -ms-transform:scale(1.05);
 -o-transform:scale(1.05);
 }
 
 .shadow-3:before, .shadow-3:after
 {
 position:absolute;
 z-index:-1;
 content:'';
 left:12px;
 bottom:12px;
 background:transparent;
 
 -webkit-box-shadow:0px 9px 12px rgba(0, 0, 0, 0.9);
 -moz-box-shadow:0px 9px 12px rgba(0, 0, 0, 0.9);
 box-shadow:0px 9px 12px rgba(0, 0, 0, 0.9);
 
 -webkit-transform: skew(-5deg) rotate(-5deg);
 -moz-transform: skew(-5deg) rotate(-5deg);
 -ms-transform: skew(-5deg) rotate(-5deg);
 -o-transform: skew(-5deg) rotate(-5deg);
 transform: skew(-5deg) rotate(-5deg);
 }
 
 .shadow-3:after
 {
 left:auto;
 right:12px;
 
 -webkit-transform: skew(5deg) rotate(5deg);
 -moz-transform: skew(5deg) rotate(5deg);
 -ms-transform: skew(5deg) rotate(5deg);
 -o-transform: skew(5deg) rotate(5deg);
 transform: skew(5deg) rotate(5deg);
 }
 
 .shadow-3:hover:before, .shadow-3:hover:after
 {
 -webkit-box-shadow:0px 9px 22px rgba(0, 0, 0, 0.9);
 -moz-box-shadow:0px 9px 22px rgba(0, 0, 0, 0.9);
 box-shadow:0px 9px 22px rgba(0, 0, 0, 0.9);
 }
 
 .shadow-3:before, .shadow-3:after, .shadow-3
 {
 transition:all .6s ease-in-out;
 -webkit-transition:all .6s ease-in-out;
 -moz-transition:all .6s ease-in-out;
 -ms-transition:all .6s ease-in-out;
 -o-transition:all .6s ease-in-out;
 }
 
 .shadow-3:hover:before, .shadow-3:hover
 {
 transition:all .6s ease-in-out;
 -webkit-transition:all .6s ease-in-out;
 -moz-transition:all .6s ease-in-out;
 -ms-transition:all .6s ease-in-out;
 -o-transition:all .6s ease-in-out;
 }
 .wrapper {
 height: auto !important;
 height: 100%;
 margin: 0 auto;
 overflow: hidden;
 }
 
 .pointer {
 color: #00B0FF;
 font-family: 'Pacifico';
 font-size: 24px;
 margin-top: 15px;
 position: absolute;
 top: 130px;
 right: -40px;
 }
 .pointer2 {
 color: #00B0FF;
 font-family: 'Pacifico';
 font-size: 24px;
 margin-top: 15px;
 position: absolute;
 top: 130px;
 left: -40px;
 }
 pre {
 margin: 80px auto;
 }
 pre code {
 padding: 35px;
 border-radius: 5px;
 font-size: 15px;
 background: rgba(0,0,0,0.1);
 border: rgba(0,0,0,0.05) 5px solid;
 max-width: 500px;
 }
 .gallery {
 width: 70%;
 height: 300px;
 margin: 150px auto 100px;
 margin-top: 20%;
 }
 .navigation {
 margin-bottom: 150px;
 }
 .fg-card, .fg-card > img {
 border-radius: 3px;
 }
 .fg-caption {
 color: #000000;
 font-style: italic;
 font-family: noto serif;
 font-size: 17px;
 margin-top: 15%;
 }
 @media screen and (max-width: 800px) and (min-width: 300px) {  
   #img1 {
     width: 250px;
     height: 300px;
   }
 }  
 
   /* css login */
   .card0 {
     box-shadow: 0px 4px 8px 0px #757575;
     border-radius: 0px;
   }
 
   .card2 {
     margin: 0px 40px;
   }
 
   .image {
     margin-top: 20%;
     width: 36%;
     height: 28%;
   }
 
   .vl {
     border-left: 2px solid #dcdcdc;
     height: 45vh;
   }
 
   .text-sm {
     font-size: 14px !important;
   }
 
   ::placeholder {
     color: #BDBDBD;
     opacity: 1;
     font-weight: 300;
   }
 
   :-ms-input-placeholder {
     color: #BDBDBD;
     font-weight: 300;
   }
 
   ::-ms-input-placeholder {
     color: #BDBDBD;
     font-weight: 300;
   }
 
   input.input-login ,
   textarea {
     padding: 10px 12px 10px 12px;
     border: 1px solid lightgrey;
     border-radius: 2px;
     margin-bottom: 5px;
     margin-top: 2px;
     width: 100%;
     box-sizing: border-box;
     color: #2C3E50;
     font-size: 14px;
     letter-spacing: 1px;
   }
 
   input.input-login :focus,
   textarea:focus {
     -moz-box-shadow: none !important;
     -webkit-box-shadow: none !important;
     box-shadow: none !important;
     border: 1px solid #304FFE;
     outline-width: 0;
   }
 
   a {
     color: inherit;
     cursor: pointer;
   }
 
   @media screen and (max-width: 991px) {
     .image {
       width: 70%;
       height: 40%;
     }
 
     .card2 {
       border-top: 1px solid #EEEEEE !important;
       margin: 0px 15px;
     }
   }
   /* end of css login */
 
   /* css register */
   .register{
     background: -webkit-linear-gradient(left, #3931af, #00c6ff);
     margin-top: 3%;
     padding: 3%;
   }
   .register-left{
     text-align: center;
     color: #fff;
     margin-top: 4%;
   }
   .register-right{
     background: #f8f9fa;
     border-top-left-radius: 10% 50%;
     border-bottom-left-radius: 10% 50%;
   }
   .register-left img{
     margin-top: 15%;
     margin-bottom: 5%;
     width: 70%;
     -webkit-animation: mover 2s infinite  alternate;
     animation: mover 1s infinite  alternate;
   }
   @-webkit-keyframes mover {
     0% { transform: translateY(0); }
     100% { transform: translateY(-20px); }
   }
   @keyframes mover {
     0% { transform: translateY(0); }
     100% { transform: translateY(-20px); }
   }
   .register-left p{
     font-weight: lighter;
     padding: 12%;
     margin-top: -9%;
   }
   .register .register-form{
     padding: 10%;
     margin-top: 10%;
   }
   .register .nav-tabs{
     margin-top: 3%;
     border: none;
     background: #0062cc;
     border-radius: 1.5rem;
     width: 28%;
     float: right;
   }
   .register .nav-tabs .nav-link{
     padding: 2%;
     height: 34px;
     font-weight: 600;
     color: #fff;
     border-top-right-radius: 1.5rem;
     border-bottom-right-radius: 1.5rem;
   }
   .register .nav-tabs .nav-link:hover{
     border: none;
   }
   .register .nav-tabs .nav-link.active{
     width: 100px;
     color: #0062cc;
     border: 2px solid #0062cc;
     border-top-left-radius: 1.5rem;
     border-bottom-left-radius: 1.5rem;
   }
   .register-heading{
     text-align: center;
     margin-top: 8%;
     margin-bottom: -15%;
     color: #495057;
   }
   /* end of css register */
 
   /* css accordion */
   .btn-coll:after {
     content: "\f107";
     font-family: 'Font Awesome 5 Free';
     font-weight: 900;
     float: right;
   }
   .btn-coll.collapsed:after {
     content: "\f106";
   }
   .list-group-item{
     line-height: 1.6;font-family: Helvetica;text-align: justify;
   }
   /* end of css accordion */
 
 
   /*Searching Data*/
 
 ::selection {
    background: #212129;
 }
 
 .search-wrapper {
     position: absolute;
     transform: translate(0%, -80%);
     top:50%;
     left:2px;
 }
 
 .search-wrapper.active {
     transform: translate(0%, 30%);
     transition: all 1.8s ease-in-out;
 
 }
 
 .search-wrapper .input-holder {    
     height: 70px;
     width:70px;
     overflow: hidden;
     background: rgba(255,255,255,0);
     border-radius:20px;
     border: 2px solid rgba(255, 255, 255, 0.1);
     position: relative;
     transition: all 0.3s ease-in-out;
 }
 
 .search-wrapper.search-wrapper-scrolled .input-holder {    
     height: 60px;
     width:70px;
     overflow: hidden;
     background: rgba(255,255,255,0);
     border-radius:20px;
     border: 2px solid rgba(255, 255, 255, 0.1);
     position: relative;
     transition: all 0.3s ease-in-out;
     margin-bottom: 5px;
 }
 .search-wrapper.active.search-wrapper-scrolled .input-holder {
     width:450px;
     height: 70px;
     border-radius: 50px;
     background: rgba(0,0,0,0.5);
     transition: all .5s cubic-bezier(0.000, 0.105, 0.035, 1.570);
 }
 
 .search-wrapper.active .input-holder {
     width:450px;
     border-radius: 50px;
     background: rgba(0,0,0,0.5);
     transition: all .5s cubic-bezier(0.000, 0.105, 0.035, 1.570);
 }
 
 .search-wrapper .input-holder .search-input {
     width:100%;
     height: 50px;
     padding:0px 140px 0 20px;
     opacity: 0;
     position: absolute;
     top:0px;
     left:0px;
     background: transparent;
     box-sizing: border-box;
     border:none;
     outline:none;
     font-family:"Open Sans", Arial, Verdana;
     font-size: 16px;
     font-weight: 400;
     line-height: 20px;
     color:#FFF;
     transform: translate(0, 60px);
     transition: all .3s cubic-bezier(0.000, 0.105, 0.035, 1.570);
     transition-delay: 0.3s;
 }
 .search-wrapper.active .input-holder .search-input {
     opacity: 1;
     transform: translate(0, 10px);
 }
 .search-wrapper .input-holder .search-icon {
     width:70px;
     height:70px;
     border:none;
     border-radius:6px;
     background: rgb(55, 55, 55);
     padding:0px;
     outline:none;
     position: relative;
     z-index: 2;
     float:right;
     cursor: pointer;
     transition: all 0.3s ease-in-out;
 }
 
 .search-wrapper.search-wrapper-scrolled .input-holder .search-icon {
     width:70px;
     height:70px;
     border:none;
     border-radius:6px;
     background: rgb(38, 38, 38);
     padding:0px 0px 10px 0px;
     outline:none;
     position: relative;
     z-index: 2;
     float:right;
     cursor: pointer;
     transition: all 0.3s ease-in-out;
 }
 
 .search-wrapper.active .input-holder .search-icon {
     width: 50px;
     height:50px;
     margin: 10px;
     border-radius: 30px;
 }
 .search-wrapper .input-holder .search-icon span {
     width:22px;
     height:22px;
     display: inline-block;
     vertical-align: middle;
     position:relative;
     transform: rotate(45deg);
     transition: all .4s cubic-bezier(0.650, -0.600, 0.240, 1.650);
 }
 .search-wrapper.active .input-holder .search-icon span {
     transform: rotate(-45deg);
 }
 .search-wrapper .input-holder .search-icon span::before, .search-wrapper .input-holder .search-icon span::after {
     position: absolute; 
     content:'';
 }
 .search-wrapper .input-holder .search-icon span::before {
     width: 4px;
     height: 11px;
     left: 9px;
     top: 18px;
     border-radius: 2px;
     background: red;
     /*background: #FE5F55;*/
 }
 .search-wrapper .input-holder .search-icon span::after {
     width: 20px;
     height: 20px;
     left: 0px;
     top: 0px;
     border-radius: 16px;
     border: 4px solid red;
     /*border: 4px solid #FE5F55;*/
 }
 .search-wrapper .close {
     position: absolute;
     z-index: 1;
     top:24px;
     right:20px;
     width:25px;
     height:25px;
     cursor: pointer;
     transform: rotate(-180deg);
     transition: all .3s cubic-bezier(0.285, -0.450, 0.935, 0.110);
     transition-delay: 0.2s;
 }
 .search-wrapper.active .close {
     right:-30px;
     transform: rotate(45deg);
     transition: all .6s cubic-bezier(0.000, 0.105, 0.035, 1.570);
     transition-delay: 0.5s;
     opacity: 1;
 }
 .search-wrapper .close::before, .search-wrapper .close::after {
     position:absolute;
     content:'';
     background: red;
     /*background: #FE5F55;*/
     border-radius: 2px;
 }
 .search-wrapper .close::before {
     width: 5px;
     height: 25px;
     left: 10px;
     top: 0px;
 }
 .search-wrapper .close::after {
     width: 25px;
     height: 5px;
     left: 0px;
     top: 10px;
 }
 
   /*End Searching Data*/
 
   /*Searching Data Mobile Mode*/
 ::selection {
    background: #212129;
 }
 
 .search-wrapper-mobile {
     position: absolute;
     transform: translate(0%, -78%);
     /*top:0%;*/
     left: 33%;
 }
 
 .search-wrapper-mobile.active {
     transform: translate(0%, 30%);
     left: 1%;
     right: 1%;
     width: 88%; 
     transition: all 1.8s cubic-bezier(0.010,1.620,0.370,1.430);
 }
 
 .search-wrapper-mobile .input-holder-mobile {    
     height: 55px;
     width:55px;
     overflow: hidden;
     background: rgba(255,255,255,0);
     border-radius:20px;
     border: 2px solid rgba(255, 255, 255, 0.1);
     position: relative;
     transition: all 0.3s ease-in-out;
 }
 
 .search-wrapper-mobile.search-wrapper-mobile-scrolled .input-holder-mobile {    
     height: 55px;
     width:55px;
     overflow: hidden;
     background: rgba(255,255,255,0);
     border-radius:20px;
     border: 2px solid rgba(255, 255, 255, 0.1);
     position: relative;
     transition: all 0.3s ease-in-out;
 }
 .search-wrapper-mobile.active.search-wrapper-mobile-scrolled .input-holder-mobile {
     width:450px;
     height: 55px;
     border-radius: 50px;
     background: rgba(0,0,0,0.5);
     transition: all .5s cubic-bezier(0.000, 0.105, 0.035, 1.570);
 }
 
 .search-wrapper-mobile.active .input-holder-mobile {
     width:100%;
     border-radius: 50px;
     background: rgba(0,0,0,0.5);
     transition: all .5s cubic-bezier(0.000, 0.105, 0.035, 1.570);
 }
 
 .search-wrapper-mobile .input-holder-mobile .search-input-mobile {
     width:100%;
     height: 50px;
     padding:0px 120px 20px 20px;
     opacity: 0;
     position: absolute;
     top:0px;
     left:0px;
     background: transparent;
     box-sizing: border-box;
     border:none;
     outline:none;
     font-family:"Open Sans", Arial, Verdana;
     font-size: 16px;
     font-weight: 400;
     line-height: 20px;
     color:#FFF;
     transform: translate(0, 60px);
     transition: all .3s cubic-bezier(0.000, 0.105, 0.035, 1.570);
     transition-delay: 0.3s;
 }
 .search-wrapper-mobile.active .input-holder-mobile .search-input-mobile {
     opacity: 1;
     transform: translate(0, 10px);
 }
 .search-wrapper-mobile .input-holder-mobile .search-icon-mobile {
     width:70px;
     height:70px;
     border:none;
     border-radius:6px;
     background: rgb(51, 51, 51);
     padding:0px 0px 15px 20px;
     outline:none;
     position: relative;
     z-index: 2;
     float:right;
     cursor: pointer;
     transition: all 0.3s ease-in-out;
 }
 .search-wrapper-mobile.active .input-holder-mobile .search-icon-mobile {
     width: 50px;
     height:50px;
     margin: 0px 5px 0px 0px;
     padding: 0px;
     border-radius: 30px;
     background: rgba(0, 0, 0, 0.5); 
 }
 .search-wrapper-mobile .input-holder-mobile .search-icon-mobile span {
     width:22px;
     height:22px;
     display: inline-block;
     vertical-align: middle;
     position:relative;
     transform: rotate(45deg);
     transition: all .4s cubic-bezier(0.650, -0.600, 0.240, 1.650);
 }
 .search-wrapper-mobile.active .input-holder-mobile .search-icon-mobile span {
     transform: rotate(-45deg);
 }
 .search-wrapper-mobile .input-holder-mobile .search-icon-mobile span::before, .search-wrapper-mobile .input-holder-mobile .search-icon-mobile span::after {
     position: absolute; 
     content:'';
 }
 .search-wrapper-mobile .input-holder-mobile .search-icon-mobile span::before {
     width: 4px;
     height: 11px;
     left: 9px;
     top: 18px;
     border-radius: 2px;
     background: red;
     /*background: #FE5F55;*/
 }
 .search-wrapper-mobile .input-holder-mobile .search-icon-mobile span::after {
     width: 20px;
     height: 20px;
     left: 0px;
     top: 0px;
     border-radius: 16px;
     border: 4px solid red;
     /*border: 4px solid #FE5F55;*/
 }
 .search-wrapper-mobile .close-mobile {
     position: absolute;
     z-index: 1;
     top:24px;
     right:20px;
     width:25px;
     height:25px;
     cursor: pointer;
     transform: rotate(-180deg);
     transition: all .3s cubic-bezier(0.285, -0.450, 0.935, 0.110);
     transition-delay: 0.2s;
 }
 .search-wrapper-mobile.active .close-mobile {
     right:-45px;
     transform: rotate(45deg);
     transition: all .6s cubic-bezier(0.000, 0.105, 0.035, 1.570);
     transition-delay: 0.5s;
     width:50px;
     height:50px;   
     top: 20px; 
 }
 .search-wrapper-mobile .close-mobile::before, .search-wrapper-mobile .close-mobile::after {
     position:absolute;
     content:'';
     background: red;
     border-radius: 2px;
     /*background: #FE5F55;*/
 }
 .search-wrapper-mobile .close-mobile::before {
     width: 7px;
     height: 27px;
     left: 10px;
     top: 0px;
 }
 .search-wrapper-mobile .close-mobile::after {
     width: 27px;
     height: 7px;
     left: 0px;
     top: 10px;
 }
 
   /*End Searching Data - Mobile Mode*/
 
 
 .result-response-has-result{
   background: rgb(51, 51, 51, 0.1);
   padding: 5% 4% 5% 4%;
   font-weight: bold;
   font-size: 16px;
   margin-bottom: 3%;
   border-radius:7px;
 }
 
 /*Search input navbar*/
 input[id^="search"]::-webkit-input-placeholder { 
   color: #ffffff;
   font-weight: 500;
   font-size: 1em;
 }
 input[id^="search"]::-moz-placeholder { 
   color: #ffffff;
   font-weight: 500;
   font-size: 1em;
 }
 input[id^="search"]:-ms-input-placeholder { 
   color: #ffffff;
   font-weight: 500;
   font-size: 1em;
 }
 input[id^="search"]:-moz-placeholder { 
   color: #ffffff;
   font-weight: 500;
   font-size: 1em;
 }
 
 .search-popup {
   display: none;
   position: fixed;
   top: 0;
   right: 0;
   left: 0;
   bottom: 0;
 }
 .search-bg {
   position: absolute;
   top: 0;
   right: 0;
   left: 0;
   bottom: 0;
   background-color: rgba(0, 0, 0, .5);
 }
 
 .search-popup label {
   color: white;
 }
 
 .search-form {
   display: block;
   margin: 7em 4em;
   position: relative;
   right: -100%;
 }
 
 .form1 {
   position: relative;
 }
 
 .form1 input {
   outline: none;
   border-width: 0 0 1px 0;
   border-style: none none solid none;
   border-color: #dad6d5;
   background-color: transparent;
   width: 100%;
   padding: 1em 0;
   color: #dad6d5;
 }
 
 .form1 input:focus::-webkit-input-placeholder {
   opacity: 0;
 }
 
 .form1 input:focus::-moz-placeholder {
   opacity: 0;
 }
 
 .form1 input:-ms-input-placeholder {
   opacity: 0;
 }
 
 .form1 input:focus:-moz-placeholder {
   opacity: 0;
 }
 
 .form1 label {
   position: absolute;
   top: 25%;
   right: 0;
 }
 
 #search-menu {
   position: fixed;
   width: 100%;
   height: 20em;
   top: -20em;
   left: 0;
   right: 0;
   white-space: nowrap;
   z-index: 9999;
   background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 50%, rgba(0, 0, 0, 0.01) 100%);
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0.8)), color-stop(50%, rgba(0, 0, 0, 0.8)), color-stop(100%, rgba(0, 0, 0, 0.01)));
   background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 50%, rgba(0, 0, 0, 0.01) 100%);
   background: -o-linear-gradient(top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 50%, rgba(0, 0, 0, 0.01) 100%);
   background: -ms-linear-gradient(top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 50%, rgba(0, 0, 0, 0.01) 100%);
   background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 50%, rgba(0, 0, 0, 0.01) 100%);
   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#cc000000", endColorstr="#1a000000",GradientType=0);
   opacity: 0;
   visibility: hidden;
   -webkit-transition: 500ms ease all;
   -moz-transition: 500ms ease all;
   transition: 500ms ease all;
 }
 #search-menu.toggled {
   top: 0;
   opacity: 1;
   visibility: visible;
 }
 #search-menu .wrapper {
   position: relative;
   margin: 3em auto 0 auto;
   padding: 0 1em;
 }
 #search-menu .wrapper input {
   width: 90%;
   padding: 0 0 0.125em 0;
   background: transparent;
   border: none;
   border-bottom: 3px solid #bfbfbf;
   color: #bfbfbf;
 }
 #search-menu .wrapper input:focus {
   outline: none;
 }
 #search-menu .wrapper button {
   position: absolute;
   display: block;
   width: 10%;
   right: 0;
   top: 0;
   background: transparent;
   border: none;
   color: #bfbfbf;
   -webkit-transition: 500ms ease all;
   -moz-transition: 500ms ease all;
   transition: 500ms ease all;
 }
 #search-menu .wrapper button:hover {
   color: #fff;
 }
 #search-menu .wrapper button:focus {
   outline: none;
 }
 
 #search-icon {
   padding: 0 0.5em 0.25em 0.5em;
   cursor: pointer;
   color: #bfbfbf;
   text-align: center;
   -webkit-transition: 500ms ease all;
   -moz-transition: 500ms ease all;
   transition: 500ms ease all;
 }
 #search-icon:hover {
   color: #fff;
 }
 /*End of search input navbar*/
 
 </style>
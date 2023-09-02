  <!-- ======= Footer ======= -->
  <footer>
    <!-- ======= Contact Section ======= -->
    <div class="footer-area contact-area" style="background-color:#808080;color:#ffffff;">
      <div class="contact-inner">
        <div class="contact-overly"></div>
        <div class="container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="text-center">               
                <h2 style="font-size: 2em;color:#ffffff;">Kontak</h2>
              </div>
            </div>
          </div>
          <div class="row">              
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <a href="https://api.whatsapp.com/send/?phone=6281211002143&text&app_absent=0" target="_blank"><img src="{{ asset('img/icon-sosmed/wa.gif')}}" height="30" width="30" ></a>
                  <p style="color:#ffffff;">
                    @isset($kontak)
                      @foreach($kontak as $data)
                        @if($data->nama == 'Kontak Telepon')
                          <a href="https://api.whatsapp.com/send/?phone=6281211002143&text&app_absent=0" target="_blank">Chat: {{ $data->data }} </a>
                        @endif
                      @endforeach
                    @endisset                     
                      <br>
                  </p>
                </div>
              </div>
            </div>
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <img src="{{ asset('img/icon-sosmed/email.gif')}}" height="30" width="30" >
                  <p style="color:#ffffff;">
                    @isset($kontak)
                      @foreach($kontak as $data)
                        @if($data->nama == 'Email')
                          {{ $data->data }}
                        @endif
                      @endforeach
                    @endisset                     
                  </p>
                </div>
              </div>
            </div>
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <a href="https://goo.gl/maps/UQbFiqnvxU583hm16" target="_blank"><img src="{{ asset('img/icon-sosmed/location.gif')}}" height="30" width="30" ></a>
                  <p style="color:#ffffff;">
                    @isset($kontak)
                      @foreach($kontak as $data)
                        @if($data->nama == 'Alamat')
                          <a href="https://goo.gl/maps/UQbFiqnvxU583hm16" target="_blank">{{ $data->data }} </a>
                        @endif
                      @endforeach
                    @endisset 
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <h4 style="color:#ffffff;">Sosial Media Kami :</h4>
                <div class="footer-icons">
                  <ul>
                    @isset($sosialmedia)
                      @foreach($sosialmedia as $data)                      
                        <li>
                          <a href="{{ $data->data }}" target="_blank"><img src="{{ asset('storage/file_upload/'.$data->file) }}" width="18" height="18" style="padding-bottom: 9%;"></a>
                        </li>                      
                      @endforeach
                    @endisset                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Contact Section -->
    <div class="footer-area-bottom" style="background-color:#808080">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="copyright text-center">
              <p style="color:#ffffff">
                &copy; Copyright <?php echo date('Y');?> <strong>Kementerian PPN/Bappenas</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <button type="button" class="" onclick="topFunction()" id="alur" title="" data-toggle="modal" data-target="#myModal">
    <span class="noselect">Alur Informasi</span><div id="circle"></div>
  </button>

  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="5" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title w-100 text-center" id="myModalLabel">Informasi Permohonan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-12 col-step-icon">
                <div class="row row-step-icon">
                @isset($alur_informasi)
                  @foreach($alur_informasi as $data)
                  <div class="col-12 col-sm-4 col-icon-item text-center">
                    <img src="{{ asset('storage/file_upload/'.$data->file)}}">
                    <p>
                      <b>
                        {{ $data->nama }}
                      </b>
                    </p>
                    <p>
                      {{ $data->data }}
                    </p>
                  </div>
                  @endforeach
                @endisset                  

                </div>
              </div>
            </div>
            <div class="modal-footer remove-top">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /Modal -->

  <!-- Vendor JS Files -->
  <!-- <script src="{{ asset('assets/front-office/vendor/jquery/jquery.min.js')}}"></script> -->
  <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>

  <script src="{{ asset('assets/front-office/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/appear/jquery.appear.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/knob/jquery.knob.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/parallax/parallax.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/wow/wow.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/nivo-slider/js/jquery.nivo.slider.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/venobox/venobox.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

  <!-- Custom JS -->
  <script src="{{ asset('js/jquery.flipping_gallery.js') }}"></script>

  <!-- Datepicker Js -->
  <script src="{{ asset('assets/general/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
 
   <!-- Datatables -->
  <script src="{{ asset('assets/front-office/js/jquery.dataTables.min.js') }}"></script> 

  <!-- Select 2   -->
  <script src="{{ asset('assets/general/select2/dist/js/select2.min.js') }}"></script>   

<script>
  //Get the button
  var mybutton = document.getElementById("alur");

  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
    if (document.body.scrollTop == 0 || document.documentElement.scrollTop == 0) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    // document.body.scrollTop = 0;
    // document.documentElement.scrollTop = 0;
  }

  // $( document ).ready() block.
  $( document ).ready(function() {
    if (document.cookie.indexOf('visited=true') == -1){
      // load the overlay
      $('#myModal').modal({show:true});
      
      var year = 1000*60*60*24*365;
      var expires = new Date((new Date()).valueOf() + year);
      document.cookie = "visited=true;expires=" + expires.toUTCString();

    }
  }); 
</script>
<script>

// Fitur Search
function searchToggle(obj, evt){
    var container = $(obj).closest('.search-wrapper');
        if(!container.hasClass('active')){
            container.addClass('active');
            evt.preventDefault();
        }
        else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
            container.removeClass('active');
            // clear input
            container.find('.search-input').val('');
        }
}

function searchToggleMobile(obj, evt){
    var container = $(obj).closest('.search-wrapper-mobile');
        if(!container.hasClass('active')){
            container.addClass('active');
            evt.preventDefault();
        }
        else if(container.hasClass('active') && $(obj).closest('.input-holder-mobile').length == 0){
            container.removeClass('active');
            // clear input
            container.find('.search-input-mobile').val('');
        }
}

$(document).ready(function() {
  $(window).scroll(function() {
    scroll = $(window).scrollTop();
     
    if (scroll > 100) { 
      $("div#search-wrapper").addClass("search-wrapper-scrolled");
    }else { 
      $("div#search-wrapper").removeClass("search-wrapper-scrolled");
    }
  });

  $('#btn-search-icon-before').click(function(e){
    e.preventDefault();
    $(this).attr('disabled', true);
    $("i#i-icon").removeClass("fas fa-search").addClass("fas fa-exclamation-circle");
    $("i#i-icon").css({"color": "#666", "cursor": "not-allowed"});
  });

  $('#btn-search-close').click(function(e){
    e.preventDefault();
    $('#btn-search-icon-before').attr('disabled', false);
    $("i#i-icon").removeClass("fas fa-exclamation-circle").addClass("fas fa-search");
    $("i#i-icon").css({"color": "red", "cursor": "pointer"});
    $('#result-searching').hide(1500);
  });  

  // Mobile Search
  $('#btn-search-icon-before-mobile').click(function(e){
    e.preventDefault();
    $(this).attr('disabled', true);
    $("i#i-icon").removeClass("fas fa-search").addClass("fas fa-exclamation-circle");
    $("i#i-icon").css({"color": "#666", "cursor": "not-allowed"});
  });  

  $('#btn-search-close-mobile').click(function(e){
    e.preventDefault();
    $('#btn-search-icon-before-mobile').attr('disabled', false);
    $("i#i-icon").removeClass("fas fa-exclamation-circle").addClass("fas fa-search");
    $("i#i-icon").css({"color": "red", "cursor": "pointer"});
    $('#result-searching').hide(1500);
  }); 
  // End - Mobile Search

  // Ajax Dekstop Mode
  $('#btn-search-icon-after').click(function(e){
    e.preventDefault();
    var data = $('.search-input').val();

      $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });   
           
      $.ajax({          
          url: '{{ route("search-data") }}',
          type: 'POST',
          data: {'datasearch' : data},
          // dataType: 'json',
          beforeSend: function() {
              $("#loader").show();
          },          
          success: function(data, XHR) {

            if(typeof(data) == 'object'){
              var jumlahHasil = $(data).toArray().length;

              if(!jumlahHasil){
                  $('.jumlah-result').text('0');
                  var dataAlert = '<div class="alert alert-warning alert-block mt-2 text-center"><h6><strong>No result.!</strong></h6></div>';
                  $('.result-response-no-result').html(dataAlert); 
                  $('.result-response-no-result').show(1800);
                  $('.result-response-area').hide(1400); 
                  $('.result-response-has-result').hide(900);
              }else{
                  var text = "";
                  data.forEach(function (arrayItem) {
                      var x = arrayItem.judul;
                      var routesLink = arrayItem.url;

                      text += "<p class='mt-2'><a href='"+routesLink+"' target='_blank'>"+x+"</a></p><hr>";
                      $('.result-response-has-result').html(text);
                      $('.result-response-has-result').show(1900);
                      $('.result-response-no-result').hide(1500);
                      $('.result-response-area').hide(1100); 
                  });            
              }
              $('.jumlah-result').text(jumlahHasil);
            }
            $(document).scrollTop(650);
            $('#result-searching').delay(1500).show(1500);

          }, 
          complete:function(data){
            // Hide image container
            $("#loader").delay(1500).hide();
          },                 
          error: function(XHR, textStatus, errorThrown){
            var dataStatus = "Data yg anda masukkan kosong.!";
            $('.jumlah-result').text('0');
            if(XHR.status == 422){
              $(document).scrollTop(650);
              $('#result-searching').show(1500);
              var dataAlert = '<div class="alert alert-danger alert-block mt-2 text-center"><h6><strong>'+dataStatus+'</strong></h6></div>';
              $('.result-response-area').html(dataAlert); 
              $('.result-response-area').show(1600); 
              $('.result-response-no-result').hide(1200);
              $('.result-response-has-result').hide(800);
            }
          }
      });
  });

  // Ajax Mobile Mode
  $('#btn-search-icon-after-mobile').click(function(e){
    e.preventDefault();
    var data = $('.search-input-mobile').val();

      $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });   
           
      $.ajax({          
          url: '{{ route("search-data") }}',
          type: 'POST',
          data: {'datasearch' : data},
          // dataType: 'json',
          beforeSend: function() {
              $("#loader-mobile").show();
          },          
          success: function(data, XHR) {

            if(typeof(data) == 'object'){
              var jumlahHasil = $(data).toArray().length;

              if(!jumlahHasil){
                  $('.jumlah-result').text('0');
                  var dataAlert = '<div class="alert alert-warning alert-block mt-2 text-center"><h6><strong>No result.!</strong></h6></div>';
                  $('.result-response-no-result').html(dataAlert); 
                  $('.result-response-no-result').show(1800);
                  $('.result-response-area').hide(1400); 
                  $('.result-response-has-result').hide(900);
              }else{
                  var text = "";
                  data.forEach(function (arrayItem) {
                      var x = arrayItem.judul;
                      var routesLink = arrayItem.url;

                      text += "<p class='mt-2'><a href='"+routesLink+"' target='_blank'>"+x+"</a></p><hr>";
                      $('.result-response-has-result').html(text);
                      $('.result-response-has-result').show(1900);
                      $('.result-response-no-result').hide(1500);
                      $('.result-response-area').hide(1100); 
                  });            
              }
              $('.jumlah-result').text(jumlahHasil);
            }
            $(document).scrollTop(850);
            $('#result-searching').delay(1100).show(1500);

          }, 
          complete:function(data){
            // Hide image container
            $("#loader-mobile").delay(1100).hide();
          },                 
          error: function(XHR, textStatus, errorThrown){
            var dataStatus = "Data yg anda masukkan kosong.!";
            $('.jumlah-result').text('0');
            if(XHR.status == 422){
              $(document).scrollTop(850);
              $('#result-searching').show(1500);
              var dataAlert = '<div class="alert alert-danger alert-block mt-2 text-center"><h6><strong>'+dataStatus+'</strong></h6></div>';
              $('.result-response-area').html(dataAlert); 
              $('.result-response-area').show(1600); 
              $('.result-response-no-result').hide(1200);
              $('.result-response-has-result').hide(800);
            }
          }
      });
  });


});  
</script>
<script>
$(function () {
    $('#search-menu').removeClass('toggled');
    
    $('#search-icon').click(function (e) {
        e.stopPropagation();
        $('#search-menu').toggleClass('toggled');
        $("#search").focus();
    });
    
    $('#search-menu input').click(function (e) {
        e.stopPropagation();
    });

    $('#close').click(function () {
        $('#search-menu').removeClass('toggled');
        $('#result-searching').hide(1500);
    /*Clear all input type="text" box*/
    $('#form1 input[type="text"]').val('');
    });
});
</script>
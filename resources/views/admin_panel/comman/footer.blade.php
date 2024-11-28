
<script src="{{asset('../../assets/lib/feather-icons/feather.min.js')}}"></script>

  <script src="{{asset('../../assets/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('../../assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('../../assets/lib/feather-icons/feather.min.js')}}"></script>
  <script src="{{asset('../../assets/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

  <script src="{{asset('../../assets/js/dashforge.js')}}"></script>

  <!-- append theme customizer -->
  <script src="{{asset('../../assets/lib/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('../../assets/js/calendar-events.js')}}"></script>
  <script src="{{asset('../../assets/js/dashforge.settings.js')}}"></script>
  

  

  <script>
    $(function(){
      'use script'

      window.darkMode = function(){
        $('.btn-white').addClass('btn-dark').removeClass('btn-white');
      }

      window.lightMode = function() {
        $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
      }

      var hasMode = Cookies.get('df-mode');
      if(hasMode === 'dark') {
        darkMode();
      } else {
        lightMode();
      }
    })
  </script>
  
</body>
</html>

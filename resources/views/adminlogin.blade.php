@include('layouts.header')

    <main class="main">


        <section id="about" class=" hero about section dark-background">
    <br>
        <br>
        <br>
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between" >

          <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200" style="border: solid whitesmoke;padding: 25px;box-shadow: 5px 5px 5px 1px #dfd4ca;border-radius: 15px;">
          <br>
            <span class="about-meta">Login to Your Session</span>
            <h2 class="about-title">VStream.</h2>
            <p class="about-description"></p>

            <div class="row feature-list-wrapper">
                <form method="post">
               
                    <ul class="feature-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i> 
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>        
                           <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </li>
                    </ul>
                        
                </form>
                <div class="col-md-12" align='right'>
                    <input type="button" class="btn btn-primary btn-block" value="Sign In" id="login" name="login" onclick="getLogin();">
                </div>
               
                <br>
                <br>
            </div>
             

            
          </div>

          <div class="col-xl-6 imgviewdiv" data-aos="fade-up" data-aos-delay="300">
            <div class="image-wrapper animated">
              <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                <img src="{{ asset('assets/img/login.avif') }}" alt="Business Meeting" class="img-fluid main-image rounded-4">
                <img src="{{ asset('assets/img/signin.jpg')}}" alt="Team Discussion" class="img-fluid small-image rounded-4">
              </div>
              <!-- <div class="experience-badge floating">
                <h3>50+ <span>Years</span></h3>
                <p>Of experience in business service</p>
              </div> -->
            </div>
          </div>
        </div>

      </div>
        <br>
        <br>
        <br>    <br>
        <br>
        <br>
        <br>
    </section>



    </main>

@include('layouts.footer')

<script>
function getLogin()
{
  $.ajax({
        url: APP_URL + '/admin/getLogin',
        type: 'post',
        dataType: "json",
        data: { 'username': $("#username").val(), 'password': $("#password").val(),  "_token":'{{ csrf_token() }}' },
        success: function (data) {
          if ($.trim(data.message) == 'valid') {
            if ($.trim(data.status) == '1') {
            window.location.href = APP_URL + '/video-create';
            } else {
              $("#error_msg").html("ACCESS DENIED");
            }
          } else if ($.trim(data.message) == 'invalid') {
            var msg = '';
            if (data.error.msg) {
              createalert(data.error.msg,'warning','error_msg');
            } else if (data.error.msg_active) {
              alert(data.error.msg_active);
              location.reload();
            } else {
              if (data.error.username)
                msg += data.error.username + '<br>';
              if (data.error.password)
                msg += data.error.password + '<br>';
              if (data.error.captcha)
                msg += data.error.captcha;
              createalert(msg,'warning','error_msg');
            }
          }
        }
      });
}
</script>

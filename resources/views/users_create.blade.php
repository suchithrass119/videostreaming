@include('layouts.header')

<main class="main">


    <section id="about" class=" hero about section dark-background">
        <br>
        <br>
        <br>
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 align-items-center justify-content-between">

                <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200"
                    style="border: solid whitesmoke;padding: 25px;box-shadow: 5px 5px 5px 1px #dfd4ca;border-radius: 15px;">
                    <br>
                    <span class="about-meta">Create Your Session</span>
                    <h2 class="about-title">VStream</h2>
                    <p class="about-description"></p>

                    <div class="row feature-list-wrapper">
                        <form method="post" id='fromdata'>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="Mobile" name="Mobile"
                                            placeholder="Mobile" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="Password" name="Password"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="cPassword" name="cPassword"
                                            placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>

                                
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="acceptTerms" type="checkbox" value=""
                                        id="acceptTerms" required="" onclick="terms();">
                                    <label class="form-check-label" for="acceptTerms">I agree and accept the <a
                                            href="{{ URL::to('/terms') }}">terms and conditions</a></label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
                            <div class="col-md-12" align='right'>
                                <input type="button" class="btn btn-primary btn-block" value="Sign Up" id="login" name="login" onclick="UserCreation();" disabled>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Already have an account? <a href="{{ URL::to('/login') }}">Log
                                        in</a></p>
                            </div>
                        </form>

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
        <br> <br>
        <br>
        <br>
        <br>
    </section>



</main>

@include('layouts.footer')

<script>
function UserCreation()
{
  $.ajax({
        url: APP_URL + '/user/createuser',
        type: 'post',
        dataType: "json",
        data: $("#fromdata").serialize(),
        success: function (response) {
            if (response.success) {
                alert('User Created successfully!');
                $('#fromdata')[0].reset();  // Reset the form
                window.location.href = APP_URL + '/login';

            } else {
                alert('User Creation failed: ' + response.message);
            }
        }
      });
}

function terms()
{
    if ($('#acceptTerms').is(':checked'))
    {
        $("#login").prop('disabled',false);
    }
    else{
        $("#login").prop('disabled',true);
    }
}
</script>
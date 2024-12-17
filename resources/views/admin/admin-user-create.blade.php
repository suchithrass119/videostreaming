@include('layouts.admin-header')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">User Management</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New User Regitration Form</h5>

                            <!-- Floating Labels Form -->
                            <form class="row g-3" method="post" id="userform" name="userform" enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name"   placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="mob_number" name="mob_number"   placeholder="Your Mobile">
                                        <label for="mob_number">Your Mobile</label>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="propic"  placeholder="Your Profile Pic" name="propic">
                                        <label for="propic">Your Profile Pic</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="username"  placeholder="Your Username" name="username">
                                        <label for="username">Your Username</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Password">
                                        <label for="cpassword">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="userstatus" name="userstatus" placeholder="User Status">
                                            <option value="1">Active</option>
                                            <option value="2">In-Active</option>
                                        </select>
                                        <label for="userstatus">User Status</label>
                                    </div>
                                </div>
                                
                                
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" onclick="user_create();">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End floating Labels Form -->

                        </div>
                    </div>

                </div>


            </div>
        </section>

    </main><!-- End #main -->

@include('layouts.admin-footer')
<script>
   
   function user_create() {
        const form = document.getElementById('userform');
        const formData = new FormData(form); // Collect form data, including files
        var csrfToken = $('[name="_token"]').val();
        formData.append('_token', csrfToken);
       
       // Make AJAX request
       $.ajax({
            url: APP_URL + "/create-user",
            type: 'POST',
            dataType: 'json',
            data: formData, 
            processData: false, // Prevent jQuery from processing the data
            contentType: false,
           success: function(response) {
               if (response.success) {
                   alert('User Created successfully!');
                   $('#userform')[0].reset();  // Reset the form
               } else {
                   alert('User Creation failed: ' + response.message);
               }
           },
           error: function(xhr, status, error) {
               alert('An error occurred: ' + error);
           }
       });
   }

</script>
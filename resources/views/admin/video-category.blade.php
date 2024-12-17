@include('layouts.admin-header')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Video Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Video Category</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Video Category Add</h5>

                            <!-- Floating Labels Form -->
                            <form id='uploadForm'  class='row g-3' method="POST" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Title" name='Title'
                                            placeholder="Title" value="Title ">
                                        <label for="Title">Category Title</label>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="cateImg" name='cateImg'
                                            placeholder="Category Image">
                                        <label for="cateImg">Category Image</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="status" name='status'
                                            placeholder="Category Status">
                                            <option value="1">Active</option>
                                            <option value="2">In-Active</option>
                                        </select>
                                        <label for="status">Category Status</label>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" onclick='submitForm();'>Submit</button>
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
   
    function submitForm() {
        // Get form data
        const form = document.getElementById('uploadForm');
        const formData = new FormData(form); // Collect form data, including files
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        formData.append('_token', csrfToken);
        
        // Make AJAX request
        $.ajax({
            url: APP_URL + "/category-upload",
            type: 'POST',
            dataType: 'json',
            data: formData, // Send form data including files
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content-type header (form-data)
            success: function(response) {
                if (response.success) {
                    alert('Category Added successfully!');
                    $('#uploadForm')[0].reset();  // Reset the form
                } else {
                    alert('Failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }

</script>



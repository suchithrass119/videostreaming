@include('layouts.admin-header')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Video Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Video Management</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Video Upload Form</h5>

                            <!-- Floating Labels Form -->
                            <form id='uploadForm'  class='row g-3' method="POST" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Title" name='Title'
                                            placeholder="Title">
                                        <label for="Title">Title</label>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="videoFile" name='videoFile'
                                            placeholder="File">
                                        <label for="videoFile">File</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="Thumbnail" name='Thumbnail'
                                            placeholder="Thumbnail">
                                        <label for="Thumbnail">Thumbnail</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Description" id="Description"
                                            style="height: 100px;"></textarea>
                                        <label for="Description">Description</label>
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
            url: '{{ route('upload.video') }}',  // Route to handle the video upload (adjust route name)
            type: 'POST',
            dataType: 'json',
            data: formData, // Send form data including files
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content-type header (form-data)
            success: function(response) {
                if (response.success) {
                    alert('Video uploaded successfully!');
                    $('#uploadForm')[0].reset();  // Reset the form
                } else {
                    alert('Upload failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }

</script>



@include('layouts.header')

<style>
    #video-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive grid */
        gap: 1rem;
    }

    @media (max-width: 768px) {
        #video-container {
            grid-template-columns: 1fr; /* Single-column layout for mobile */
        }
    }

    .card img, .card video {
        width: 100%;
        height: auto;
    }
</style>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <!-- <div class="container">
        
        <div class="row gy-4 ">
            @foreach($videos as $video)
            
            <div class="col-md-3 video-thumbnail position-relative">
                <img src='{{ asset("storage/$video->url")}}' alt="Video Thumbnail" class="img-thumbnail img-fluid" style='height:400px !important'>
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="title text-white">{{ $video->title }}</h3>
                    <a href="{{ url('video_details/' . $video->id) }}" class="btn btn-primary mt-3">Watch Now</a>
                </div>
            </div>

           
            
           @endforeach
           
           
            

        </div>
        <br>
        <div class="row gy-4 d-flex justify-content-center">
        {{ $videos->links() }}
        </div>
        
      </div> -->

      <div class="container mt-4">
    <h2 class="text-center">Videos</h2>
    <div id="video-container row gy-4">
        <!-- Videos will be dynamically appended here -->
    </div>
    <div id="loading" class="text-center mt-4" style="display: none;">
        <p>Loading...</p>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

<script>
    let currentPage = 1;
    let isLoading = false;

    function loadVideos(page) {
        if (isLoading) return;
        isLoading = true;
        $('#loading').show();

        $.get('/videos?page=${page}', function (data) {
            data.data.forEach(video => {
                $('#video-container').append(`
                    <div class="card">
                        <img 
                            class="lazyload" 
                            data-src="${video.url}" 
                            alt="${video.title}" 
                        />
                        <div class="card-body">
                            <h5 class="card-title">${video.title}</h5>
                            <video controls preload="none" width="100%">
                                <source src="${video.main_url}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                `);
            });

            if (data.next_page_url) {
                currentPage++;
                isLoading = false;
            } else {
                $('#loading').text('No more videos to load.');
            }

            $('#loading').hide();
        });
    }

    $(document).ready(function () {
        loadVideos(currentPage);

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadVideos(currentPage);
            }
        });
    });
</script>


    </section><!-- /Hero Section -->

    
   
  </main>

  @include('layouts.footer')
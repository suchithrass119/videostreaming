@include('layouts.header')

<style>
#video-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    /* Responsive grid */
    gap: 1rem;
}

@media (max-width: 768px) {
    #video-container {
        grid-template-columns: 1fr;
        /* Single-column layout for mobile */
    }
}

.card img,
.card video {
    width: 100%;
    height: auto;
    border: #223b51 !important;
}
.card{
    border: #223b51 !important;
    background-color: #223b51 !important;
}
.card-body
{
    background-color: #223b51 !important;
    border: none !important;
}

.card-img-top
{
    border-radius: 15px;
}

/* .video-card {
    position: relative;
}

.video-thumbnail {
    transition: opacity 0.3s ease-in-out;
}

.video-trailer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 250px;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

.video-card:hover .video-thumbnail {
    opacity: 0; 
}

.video-card:hover .video-trailer {
    opacity: 1;
    visibility: visible; 
}

.video-card:hover .video-trailer.playing {
    opacity: 1; 
} */


.video-card {
    position: relative;
}

.video-thumbnail {
    transition: opacity 0.3s ease-in-out;
}

.video-trailer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 250px;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

.video-card:hover .video-thumbnail {
    opacity: 0; /* Hide thumbnail on hover */
}

.video-card:hover .video-trailer {
    opacity: 1; /* Show video on hover */
    visibility: visible; /* Ensure it's visible */
}


.card-title
{
    font-weight: 800;
}

</style>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div class="container">

            <div class="row gy-4 ">
                @foreach($videos as $video)
                    <!-- <div class="col-md-4 video-thumbnail position-relative  video-card">
                            <a href="{{ url('video_details/' . $video->id) }}">
                            <div class="card  top-0 start-0 w-100  d-flex flex-column ">
                                <img  src='{{ asset("storage/$video->url")}}' class="card-img-top video-thumbnail" alt="Video Thumbnail" style='height:250px !important'>
                                <div class="card-body ">
                                    <h5 class="card-title text-white">{{ $video->title }}</h5>
                                    <p class="card-text">Channel Name · 1M views</p>
                                </div>
                                
                            </div>
                        </a>
                    </div> -->

                    <!-- <div class="col-md-4 video-thumbnail position-relative video-card">
                        <a href="{{ url('video_details/' . $video->id) }}">
                            <div class="card top-0 start-0 w-100 d-flex flex-column">
                                <img src="{{ asset('storage/' . $video->url) }}" class="card-img-top video-thumbnail" alt="Video Thumbnail" style="height:250px !important">
                                
                                <video class="video-trailer w-100"  height="300px" preload="auto" muted>
                                    <source src="{{ asset('storage/' . $video->main_url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                
                                <div class="card-body">
                                    <h5 class="card-title text-white">{{ $video->title }}</h5>
                                    <p class="card-text">Channel Name · 1M views</p>
                                </div>
                            </div>
                        </a>
                    </div> -->

                    <div class="col-md-4 video-thumbnail position-relative video-card">
                        <a href="{{ url('video_details/' . $video->id) }}">
                            <div class="card top-0 start-0 w-100 d-flex flex-column">
                                <!-- Thumbnail Image -->
                                <img src="{{ asset('storage/' . $video->url) }}" class="card-img-top video-thumbnail" alt="Video Thumbnail" style="height:250px !important">

                                <!-- Video Player (hidden initially) -->
                                <media-player title="Sprite Fight" src="{{ asset('storage/' . $video->main_url) }}" class="video-trailer">
                                    <media-provider playsinline></media-provider>
                                    <media-video-layout></media-video-layout>
                                </media-player>

                                <!-- <div class="card-body">
                                    <h5 class="card-title text-white">{{ $video->title }}</h5>
                                    <p class="card-text">Channel Name · 1M views</p>
                                </div> -->

                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <img src="{{ asset('storage/Propic/FUPVrrMQ63N3bxhRVXiM5BvfBWIKG8H2P8KOSlri.png' ) }}" alt="Image" class="img-fluid rounded-circle" style="width: 50px; height: auto;">
                                    </div>
                                    <div>
                                        <h5 class="card-title text-white">{{ $video->title }}</h5>
                                        <p class="card-text">Channel Name · 1M views</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </a>
                    </div>


                   

 

                    
                @endforeach


            </div>
            <br>
            <div class="row gy-4 d-flex justify-content-center">
                {{ $videos->links() }}
            </div>

        </div>


      

        <!-- http://localhost/test/Vstream/public/storage/Videos/eaBzYJbJ3LBNzZCKEf5BBEvYkXT0ss6t0faXpI3S.mp4 -->














       

</script>





        <!-- 
      <div class="container mt-4">
    <h2 class="mb-4">Videos</h2>
    <div id="video-container" class="row g-4">
    </div>
    <div id="loading" class="text-center mt-4" style="display: none;">
        <p>Loading...</p>
    </div>
</div> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    let currentPage = 1;
    let isLoading = false;

    function loadVideos(page) {
        if (isLoading) return;
        isLoading = true;
        $('#loading').show();

        $.get(APP_URL +'/videos?page=${page}', function (data) {
            data.data.forEach(video => {
                $('#video-container').append(`
                    <div class="col-md-4">
                        <div class="card">
                            <a href="${video.main_url}" target="_blank">
                                <img 
                                    src="${video.url}" 
                                    alt="${video.title}" 
                                    class="card-img-top"
                                />
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">${video.title}</h5>
                                <p class="card-text">${video.description || ''}</p>
                            </div>
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
</script> -->


    </section><!-- /Hero Section -->



</main>

@include('layouts.footer')

<script>
//     document.querySelectorAll('.video-card').forEach(card => {
//     const video = card.querySelector('.video-trailer');
//     const thumbnail = card.querySelector('.video-thumbnail');
    
//     card.addEventListener('mouseenter', () => {
//         // Start video autoplay
//         video.play();
//         video.classList.add('playing');
//         thumbnail.style.opacity = '0';  // Hide the thumbnail
//     });

//     card.addEventListener('mouseleave', () => {
//         // Pause video and reset
//         video.pause();
//         video.currentTime = 0;  // Reset to the beginning
//         video.classList.remove('playing');
//         thumbnail.style.opacity = '1';  // Show the thumbnail again
//     });
// });


document.querySelectorAll('.video-card').forEach(card => {
    const videoPlayer = card.querySelector('media-player');
    const thumbnail = card.querySelector('.video-thumbnail');
    
    card.addEventListener('mouseenter', () => {
        // Play the video when hovering
        videoPlayer.play(); // Assuming the <media-player> element has a `play()` method
        videoPlayer.classList.add('playing');
        thumbnail.style.opacity = '0';  // Hide the thumbnail
    });

    card.addEventListener('mouseleave', () => {
        // Pause and reset video when hover ends
        videoPlayer.pause(); // Assuming the <media-player> element has a `pause()` method
        videoPlayer.currentTime = 0;  // Reset to the beginning of the video
        videoPlayer.classList.remove('playing');
        thumbnail.style.opacity = '1';  // Show the thumbnail again
    });
});


</script>
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

.card {
    border: #223b51 !important;
    background-color: #223b51 !important;
}

.card-body {
    background-color: #223b51 !important;
    border: none !important;
}

.card-img-top {
    border-radius: 15px;
}

#loading-indicator {
    text-align: center;
    padding: 20px;
    font-size: 18px;
    color: #fff;
}

.rounded-circle
{
    border-radius: 20px !important;
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
    opacity: 0;
    /* Hide thumbnail on hover */
}

.video-card:hover .video-trailer {
    opacity: 1;
    /* Show video on hover */
    visibility: visible;
    /* Ensure it's visible */
}


.card-title {
    font-weight: 800;
}



.fixed-top {
    position: absolute !important;
}
</style>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div class="container">

            <div id="video-list" class="row gy-4">
                @foreach ($videos as $video)
                <div class="col-md-4 video-thumbnail position-relative video-card">
                    <a href="{{ url('video_details/' . $video->id) }}">
                        <div class="card top-0 start-0 w-100 d-flex flex-column">
                            <!-- Thumbnail Image -->
                            <img src="{{ asset('storage/' . $video->url) }}" class="card-img-top video-thumbnail"
                                alt="Video Thumbnail" style="height:250px !important">

                            <!-- Video Player (hidden initially) -->
                            <media-player title="Sprite Fight" src="{{ asset('storage/' . $video->main_url) }}"
                                class="video-trailer">
                                <media-provider playsinline></media-provider>
                                <media-video-layout></media-video-layout>
                            </media-player>

                            <div class="card-body d-flex align-items-center">
                                <div>
                                    <img src="{{ asset('storage/'.$video->category->picpath ) }}" alt="Image"
                                        class="img-fluid rounded-circle" style="width: 80px; height: auto;">
                                </div>
                                &nbsp;&nbsp;&nbsp;
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

            <div id="loading-indicator" style="text-align: center; display: none;">
                Loading...
            </div>


        </div>






    </section><!-- /Hero Section -->



</main>

@include('layouts.footer')

<script>
document.querySelectorAll('.video-card').forEach(card => {
    const videoPlayer = card.querySelector('media-player');
    const thumbnail = card.querySelector('.video-thumbnail');

    card.addEventListener('mouseenter', () => {
        // Play the video when hovering
        videoPlayer.play(); // Assuming the <media-player> element has a `play()` method
        videoPlayer.classList.add('playing');
        thumbnail.style.opacity = '0'; // Hide the thumbnail
    });

    card.addEventListener('mouseleave', () => {
        // Pause and reset video when hover ends
        videoPlayer.pause(); // Assuming the <media-player> element has a `pause()` method
        videoPlayer.currentTime = 0; // Reset to the beginning of the video
        videoPlayer.classList.remove('playing');
        thumbnail.style.opacity = '1'; // Show the thumbnail again
    });
});



let nextPageUrl = "{{ $videos->nextPageUrl() }}"; // Get the next page URL from Laravel
let isLoading = false; // Prevent multiple simultaneous AJAX requests
const videoList = $('#video-list'); // Use jQuery to select the video list element
const loadingIndicator = $('#loading-indicator'); // Use jQuery to select the loading indicator

// Function to fetch more videos using jQuery AJAX
function fetchVideos() {
    if (!nextPageUrl || isLoading) return; // Don't load if no more pages or already loading
    isLoading = true;
    loadingIndicator.show(); // Show loading indicator
    $.ajax({
        url: nextPageUrl, // Send GET request to the next page URL
        type: 'GET',
        success: function(response) {
            // Append new videos to the video list
            $.each(response.videos, function(index, video) {
                const videoCard = `
                    <div class="col-md-4 video-thumbnail position-relative video-card">
                        <a href="${APP_URL}/video_details/${video.id}">
                            <div class="card top-0 start-0 w-100 d-flex flex-column">
                                <img src="{{ asset('storage/${video.url}')}}" class="card-img-top video-thumbnail" alt="Video Thumbnail" style="height:250px !important">
                                <media-player title="${video.title}" src="{{ asset('storage/${video.main_url}')}}" class="video-trailer">
                                    <media-provider playsinline></media-provider>
                                    <media-video-layout></media-video-layout>
                                </media-player>
                                <div class="card-body d-flex align-items-center">
                                    <div>
                                        <img src="{{ asset('/storage/${video.category.picpath}')}}" alt="Image" class="img-fluid rounded-circle" style="width: 80px; height: auto;">
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div>
                                        <h5 class="card-title text-white">${video.title}</h5>
                                        <p class="card-text">Channel Name · 1M views</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                videoList.append(videoCard); // Append the video card to the list
            });

            // Update the next page URL
            nextPageUrl = response.next_page_url;

            // If there's no more videos, stop the scroll listener
            if (!nextPageUrl) {
                $(window).off('scroll', handleScroll); // Remove scroll event listener
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching videos:', error);
        },
        complete: function() {
            isLoading = false;
            loadingIndicator.hide(); // Hide loading indicator
        }
    });
}

// Scroll event listener to detect when user reaches the bottom
function handleScroll() {
    const scrollTop = $(window).scrollTop(); // Get scroll position
    const windowHeight = $(window).height(); // Get window height
    const documentHeight = $(document).height(); // Get document height

    // If the user has scrolled near the bottom, fetch more videos
    if (scrollTop + windowHeight >= documentHeight - 100 && !isLoading) {
        fetchVideos();
    }
}

// Add scroll event listener to load more videos when scrolling
$(window).on('scroll', handleScroll);

// Initial fetch if there's a next page
if (nextPageUrl) {
    fetchVideos();
}
</script>
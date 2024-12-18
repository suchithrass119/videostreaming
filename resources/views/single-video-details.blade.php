@include('layouts.header')

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div class="container">

            <div class="row gy-4 d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card top-0 start-0 w-100 d-flex flex-column">
                        <media-player title="Sprite Fight" src='{{ asset("storage/$video->main_url")}}'>
                            <media-provider playsinline></media-provider>
                            <media-video-layout></media-video-layout>
                        </media-player>
                        <div class="card-body ">
                            <div class="row  ">
                                <div class="col-md-12 d-flex align-items-center">
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
                            <div class="row ">
                                <p class="card-text">
                                {{ $video->description }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="video-list" class="row gy-4">
                        @foreach ($videos as $catevideo)
                        <div class="col-md-12 video-thumbnail position-relative video-card">
                            <a href="{{ url('video_details/' . $catevideo->id) }}">
                                <div class="card top-0 start-0 w-100 d-flex flex-column">
                                    <!-- Thumbnail Image -->
                                    <img src="{{ asset('storage/' . $catevideo->url) }}" class="card-img-top video-thumbnail"
                                        alt="Video Thumbnail" style="height:250px !important">

                                    <!-- Video Player (hidden initially) -->
                                    <media-player title="Sprite Fight" src="{{ asset('storage/' . $catevideo->main_url) }}"
                                        class="video-trailer">
                                        <media-provider playsinline></media-provider>
                                        <media-video-layout></media-video-layout>
                                    </media-player>

                                    <div class="card-body d-flex align-items-center">
                                        <div>
                                            <img src="{{ asset('storage/'.$catevideo->category->picpath ) }}" alt="Image"
                                                class="img-fluid rounded-circle" style="width: 80px; height: auto;">
                                        </div>
                                        &nbsp;&nbsp;&nbsp;
                                        <div>
                                            <h5 class="card-title text-white">{{ $catevideo->title }}</h5>
                                            <p class="card-text">Channel Name · 1M views</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div id="loading-indicator"  class="row">
                        <div class="spinner"></div>
                    </div>
                </div>
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
  $('#loading-indicator').show(); // Show loading indicator
  $.ajax({
      url: nextPageUrl, // Send GET request to the next page URL
      type: 'GET',
      success: function(response) {
          // Append new videos to the video list
          $.each(response.videos, function(index, video) {
            $('#loading-indicator').hide();
              const videoCard = `
                  <div class="col-md-12 video-thumbnail position-relative video-card">
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
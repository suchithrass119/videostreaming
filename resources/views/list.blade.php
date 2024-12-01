@include('layouts.header')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="container">
        <div class="row gy-4 ">
            @foreach($videos as $video)
            <div class="col-md-3 video-thumbnail position-relative">
                <img src="{{ $baseurl }}{{ Storage::url($video->url) }}" alt="Video Thumbnail" class="img-thumbnail img-fluid" style='height:400px !important'>
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="title text-white">{{ $video->title }}</h3>
                    <a href="{{ url('video_details/' . $video->id) }}" class="btn btn-primary mt-3">Watch Now</a>
                </div>
            </div>

            <!-- insert into online.videos(title,url,main_url)values('Test Title','asset/img/services-1.jpg','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/2.webp','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/3.avif','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/4.jpg','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/5.jpg','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/6.jpg','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/7.avif','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/8.png','baners/nnn.webm');
            insert into online.videos(title,url,main_url)values('Test Title','baners/9.jpg','baners/nnn.webm'); -->
            
           @endforeach
           
           
            

        </div>
        <br>
        <div class="row gy-4 d-flex justify-content-center">
        {{ $videos->links() }}
        </div>
        
      </div>

    </section><!-- /Hero Section -->

    
   
  </main>

  @include('layouts.footer')
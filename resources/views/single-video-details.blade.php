@include('layouts.header')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="container">
        
        <div class="row gy-4 d-flex justify-content-center">
          <media-player title="Sprite Fight" src="{{ $baseurl }}{{ Storage::url($video->main_url) }}">
            <media-provider></media-provider>
            <media-video-layout></media-video-layout>
          </media-player>
        </div>

      </div>

    </section><!-- /Hero Section -->

    
   
  </main>

  
@include('layouts.footer')

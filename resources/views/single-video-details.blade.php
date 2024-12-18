@include('layouts.header')

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div class="container">

            <div class="row gy-4 d-flex justify-content-center">
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
        </div>



    </section><!-- /Hero Section -->



</main>


@include('layouts.footer')
<!-- 
  Create By Suchithra.ss
  created at june 2024
  page for 500 error
-->


@include('layouts.header')


  <main class="main">


  <section id="about" class=" hero about section dark-background">
      
         
<br>
        <br>
        <br>
        <div class="container" data-aos="fade-up" data-aos-delay="100" align='center'>

            <div class="row gy-4 align-items-center justify-content-between">

        <h1 style="color:red">Oops! Something went wrong.</h1>
        <p>We're experiencing technical difficulties. Please try again later.</p>
        <a href="{{ url('/') }}">Return to Home</a> <!-- Optional: Link back to home -->
        </div> 

       

      </div>

    </section>

    
  
  

  </main>

@include('layouts.footer')
 
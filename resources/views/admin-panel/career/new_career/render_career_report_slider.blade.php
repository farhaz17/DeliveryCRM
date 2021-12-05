<div class="carousel_wrap">
    <div class="carousel slide" id="carouselExampleKeyboard" data-ride="carousel">
        <div class="carousel-inner">
            <?php  $iterate = 1;?>
        @if($documents != null)
            @foreach($documents as $doc)

                @foreach($doc->image as $img)
                    @if($iterate=="1")
                <div class="carousel-item active "><img class="d-block w-100" src="{{ $img  }}" alt="{{ $iterate }} slide" /></div>
                        @else
                                <div class="carousel-item "><img class="d-block w-100" src="{{ $img  }}" alt="{{ $iterate }} slide" /></div>
                        @endif
                    <?php  $iterate = $iterate+1; ?>
                @endforeach

            @endforeach
        @endif
            @if($agreed_amounts != null)
                    <div class="carousel-item "><img class="d-block w-100" src="{{ $agreed_amounts->attachment  }}" alt="{{  $agreed_amounts->attachment }} slide" /></div>
            @endif


        </div><a class="carousel-control-prev" href="#carouselExampleKeyboard" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carouselExampleKeyboard" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
    </div>
</div>

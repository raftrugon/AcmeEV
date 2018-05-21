<div class="row">
    <div class="card-deck">
        @foreach($announcements as $announcement)
            <div class="col-md-12 col-xl-6" style="padding-bottom: 40px;">
                <div class="card">
                    <h5 class="card-header">
                        <div class="row">
                            <div class="col-md-6">{{$announcement->getTitle()}}</div>
                            <div class="col-md-6" align="right">{{$announcement->getCreationMoment()}}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            {{$announcement->getbody()  }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

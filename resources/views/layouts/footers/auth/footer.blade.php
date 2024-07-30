<footer class="footer">
    <div class="mt-2">
        <div class="row mt-5">
          <div class="col-lg-1 col-sm-6 m-3"></div>
          <div class="col-lg-3 col-sm-6 m-3">
            <h4 class="mb-2 text-lg"><a href="#" target="_blank" class="footer-text">{{env('APP_NAME')}} </a></h4>
            <span class="text-sm">Online portals</span>
            <div class="social-icon my-3">
              <a href="https://www.facebook.com/southernleytestateu" target="_blank" class="bg-gradient-info text-white p-2 border-radius-sm me-2"><i class="fa fa-facebook-square"></i></a>
              <a href="https://youtube.com/c/SouthernLeyteStateUniversity" target="_blank" class="bg-gradient-danger text-white p-2 border-radius-sm me-2"><i class="fa fa-youtube-play"></i></a>
              <a href="https://www.southernleytestateu.edu.ph/index.php/en/" target="_blank" class="bg-gradient-success text-white p-2 border-radius-sm me-2"><i class="	fa fa-globe"></i></a>
              <a href="https://gmail.com" target="_blank" class="bg-gradient-warning text-white p-2 border-radius-sm me-2"><i class="fa fa-google"></i></a>
            </div>
            <p class="pt-1 text-sm">
            {{ date('Y') }} © Province of Southern Leyte
            </p>
          </div>
          <div class="col-lg-2 col-sm-6 m-3">
            <h5 class = "mb-2">Quicklinks</h5>
            <ul class="list-unstyled">
              <li><a target = "_blank" href="https://southernleytestateu.edu.ph" class="footer-link d-block pb-1 text-xs">Southern Leyte State University</a></li>
              <li><a target = "_blank" href="https://southernleyte.gov.ph" class="footer-link d-block pb-1 text-xs">Province of Southern Leyte</a></li>
              <li><a target = "_blank" href="https://www.facebook.com/slsuccsit" class="footer-link d-block pb-1 text-xs">College of CSIT</a></li>
              <li><hr></li>
              
            </ul>
          </div>
          <div class="col-lg-4 col-sm-12 m-5">
            <div class="row">

              <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"><a target = "_blank" href="https://southernleyte.gov.ph"><img class = "mt-2 img-fluid rounded-circle" src = "{{asset('/storage/images/logo-province-so-leyte.jpg')}}" style = "width: 80px"></a></div>
              <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"><a target = "_blank" href="https://southernleytestateu.edu.ph"><img class = "mt-2 img-fluid rounded-circle" src = "{{asset('/storage/images/logo-slsu.png')}}" style = "width: 80px"></a></div>
              <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"><a target = "_blank" href="https://www.facebook.com/slsuccsit"><img class = "mt-2 img-fluid rounded-circle" src = "{{asset('/storage/images/logo-ccsit.jpg')}}" style = "width: 80px"></a></div>
            </div>
          </div>
        </div>
      </div>
</footer>

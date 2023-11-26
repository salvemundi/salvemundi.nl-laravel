 <!-- Site footer -->
 <footer class="site-footer">
     <div class="container">
         <div class="row">
             <div class="col-xs-6 col-md-3">
                 <h6>Informatie</h6>
                 <ul class="footer-links">
                     <li><a href="https://goo.gl/maps/dnv849aVPd8DyXqa8" target="https://goo.gl/maps/dnv849aVPd8DyXqa8">
                             <i class="fas fa-map-pin"></i> Rachelsmolen 1, 5612MA Eindhoven
                         </a></li>

                     <li><i class="far fa-building"></i> KvK nr. 70280606</li>

                     <li><br><b>Documenten:</b></li>
                     <li><a href="/responsible-disclosure">Responsible Disclosure</a></li>
                     <li><a href="{{ asset('storage/Files/privacy.pdf') }}" download>Download privacyvoorwaarden</a>
                     </li>
                     <li><a href="{{ asset('storage/Files/Huisregelement.pdf') }}" download>Download huisregelement</a>
                     </li>
                     <li><a href="{{ asset('storage/Files/Statuten-vereniging-Salve-Mundi.pdf') }}" download>Download
                             statuten</a></li>
                 </ul>
             </div>

             <div class="col-sm-6 col-md-3">
                 <h6 name="Wat is het eendrecord van vouweenbak.nl?">Contact</h6>
                 <ul class="footer-links">
                     <li><a href="mailto:info@salvemundi.nl"><i class="fas fa-envelope"></i> info@salvemundi.nl</a></li>
                     <li><a href="tel:+31 6 24827777"><i class="fas fa-phone"></i> +31 6 24827777</a></li>
                     <li><a href="https://api.whatsapp.com/send/?phone=%2B31624827777&text&app_absent=0"
                             target="_blank">
                             <i class="fab fa-whatsapp"></i> Whatsapp</a></li>
                 </ul>
             </div>

             <div class="col-xs-6 col-md-3">
                 <h6>Commissies</h6>
                 <ul class="footer-links">
                     <li><a href="/commissies#Bestuur">Bestuur</a></li>
                     @foreach ($Commissies as $commissie)
                         @if (str_contains($commissie->DisplayName, 'commissie'))
                             <li><a href="/commissies/{{ $commissie->DisplayName }}">{{ $commissie->DisplayName }}</a>
                             </li>
                         @endif
                     @endforeach
                 </ul>
             </div>

             <div class="col-xs-6 col-md-3">
                 <h6>Social media</h6>
                 <ul class="footer-links">
                     <li><i class="fa fa-instagram"></i> <a href="https://www.instagram.com/sv.salvemundi/"
                             target="_blank">Instagram</a></li>
                     <li><i class="fa fa-facebook"></i> <a href="https://nl-nl.facebook.com/sv.salvemundi/"
                             target="_blank">Facebook</a></li>
                     <li><i class="fa fa-linkedin"></i> <a href="https://www.linkedin.com/company/salve-mundi/"
                             target="_blank">LinkedIn</a></li>
                     <li><i class="fa fa-youtube"></i> <a href="https://www.youtube.com/@salvemundi5800"
                             target="_blank">Youtube</a></li>
                 </ul>
             </div>
         </div>
         <hr>
     </div>
     <div class="container">
         <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                 <p class="center">Copyright &copy; <?php echo date('Y'); ?>&nbsp;
                     <a href="#">Salve Mundi</a>&nbsp;alle rechten voorbehouden. <a
                         href="https://github.com/salvemundi/salvemundi.nl-laravel" target="_blank"> &nbsp;<i
                             class="fab fa-github"></i> Source code</a>
                 </p>
             </div>
         </div>
     </div>
 </footer>
 </div>

 @isset($bday)
     @if ($bday == true)
         <canvas class="widthFix" id="canvas"></canvas>
     @endif
 @endisset

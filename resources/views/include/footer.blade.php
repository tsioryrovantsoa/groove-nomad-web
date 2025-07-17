<footer class="footer {{ request()->routeIs('home') ? '' : 'footer--normal' }} spad set-bg"
    data-setbg="{{ asset('assets/img/footer-bg.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer__address">
                    <ul>
                        <li>
                            <i class="fa fa-phone"></i>
                            <p>Téléphone</p>
                            <h6>+33 1 23 45 67 89</h6>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <p>Email</p>
                            <h6>contact@groove-nomad.com</h6>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1 col-md-6">
                <div class="footer__social">
                    <h2>Groove Nomad</h2>
                    <div class="footer__social__links">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6">
                <div class="footer__newslatter">
                    <h4>Restez informé</h4>
                    <form action="#">
                        <input type="text" placeholder="Votre email" />
                        <button type="submit"><i class="fa fa-send-o"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="footer__copyright__text">
            <p>
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.barfiller.js') }}"></script>
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Music Plugin -->
<script src="{{ asset('assets/js/jquery.jplayer.min.js') }}"></script>
<script src="{{ asset('assets/js/jplayerInit.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "timeOut": "5000",
        "progressBar": true,
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

@livewireScripts

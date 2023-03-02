<script>
$(document).ready(function() {
  
  // Add class to mailto link
  // Needed to separate the disabling of the default action AND copy email to clipboard
  $('a[href^=mailto]').wrap('<span class="mailto-wrapper">');
  $('a[href^=mailto]').addClass('mailto-link');

  var mailto = $('.mailto-link');
  var mailtoWrapper = $('.mailto-wrapper');
  var messageCopy = 'Kliki, et kopeerida email aadressi.';
  var messageSuccess = 'Email kopeeritud.';
  
  mailtoWrapper.append('<span class="mailto-message"></span>');
  $('.mailto-message').append(messageCopy);
  
  // Disable default action (opening your email client. yuk.)
  $('a[href^=mailto]').click(function() {
    return false;
  })
  
  // On click, get href and remove 'mailto:'
  // Store email address in a variable.
  mailto.click(function() {
    var href = $(this).attr('href');
    var email = href.replace('mailto:', '');
    copyToClipboard(email);
    $('.mailto-message').empty().append(messageSuccess);
    setTimeout(function() {
      $('.mailto-message').empty().append(messageCopy);}, 2000); 
  });
  
});

// Grabbed this from Stack Overflow.
// Copies the email variable to clipboard
function copyToClipboard(text) {
    var dummy = document.createElement("input");
    document.body.appendChild(dummy);
    dummy.setAttribute('value', text);
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);
}
</script>

 <!-- Navigation -->

    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <li class="active1">
                        <a class="page-scroll" href="http://www.tkepandimaja.ee/">Avaleht</a>
                    </li>
                    <li class="active2">
                        <a class="page-scroll"" href="//www.tkepandimaja.ee/meist">Meist</a>
                    </li>
          <!-- UUENDUS -->
          <li class="active4">
                        <a class="page-scroll"" href="//www.tkepandimaja.ee/pandimaja">Pantimine</a>
                    </li>
                    <li class="active3">
                        <a class="page-scroll" href="//www.tkepandimaja.ee/teenused">Teenused</a>
                    </li>
          <li class="active5">
                        <a class="page-scroll" href="//www.tkepandimaja.ee/kontakt">Kontakt</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
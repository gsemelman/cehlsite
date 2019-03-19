
<html>
  <head>
  <title>My Now Amazing Webpage</title>

  <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  
  </head>
  <body>

	

  <div class="your-class">
  	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 1</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 2</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 3</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 4</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 5</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 6</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 7</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 8</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 9</div>
   	<div class = "slick-slide"><img style="width:250px" src="https://www-league.nhlstatic.com/images/logos/league-light/133-com-xl.svg"></img>content 10</div>
  </div>
  
  <div>
    <button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button" style="display: block;">Next</button>
  
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
        $('.your-class').slick({
        	slidesToShow: 3,
        	  slidesToScroll: 3,
        	  autoplay: true,
        	  autoplaySpeed: 2000,
      	});
    });


  </script>

  </body>
</html>

<?php
  // Build out URI to reload from form dropdown
  // Need full url for this to work in Opera Mini
  $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

  if (isset($_POST['sg_uri']) && isset($_POST['sg_section_switcher'])) {
     $pageURL .= $_POST[sg_uri].$_POST[sg_section_switcher];
     $pageURL = htmlspecialchars( filter_var( $pageURL, FILTER_SANITIZE_URL ) );
     header("Location: $pageURL");
  }

  // Display title of each markup samples as a select option
  function listMarkupAsOptions ($type) {
    $files = array();
    $handle=opendir('markup/'.$type);
    while (false !== ($file = readdir($handle))):
        if(stristr($file,'.html')):
            $files[] = $file;
        endif;
    endwhile;

    sort($files);
    foreach ($files as $file):
        $filename = preg_replace("/\.html$/i", "", $file); 
        $title = preg_replace("/\-/i", " ", $filename);
        $title = ucwords($title);
        echo '<option value="#sg-'.$filename.'">'.$title.'</option>';
    endforeach;
  }

  // Display markup view & source
  function showMarkup($type) {
    $files = array();
    $handle=opendir('markup/'.$type);
    while (false !== ($file = readdir($handle))):
        if(stristr($file,'.html')):
            $files[] = $file;
        endif;
    endwhile;

    sort($files);
    foreach ($files as $file):
        $filename = preg_replace("/\.html$/i", "", $file);
        $title = preg_replace("/\-/i", " ", $filename);
        $documentation = '_doc/'.$type.'/'.$file;
        echo '<div class="sg-markup sg-section">';
        echo '<div class="sg-display">';
        echo '<h2 class="sg-h2"><a id="sg-'.$filename.'" class="sg-anchor">'.$title.'</a></h2>';
        if (file_exists($documentation)) {
          echo '<div class="sg-doc">';
          echo '<h3 class="sg-h3">Usage</h3>';
          include($documentation);
          echo '</div>';
        }
        echo '<h3 class="sg-h3">Example</h3>';
        include('markup/'.$type.'/'.$file);
        echo '</div>';
        echo '<div class="sg-markup-controls"><a class="sg-btn sg-btn--source" href="#">View Source</a> <a class="sg-btn--top" href="#top">Back to Top</a> </div>';
        echo '<div class="sg-source sg-animated">';
        echo '<a class="sg-btn sg-btn--select" href="#">Copy Source</a>';
        echo '<pre class="prettyprint linenums"><code>';
        echo htmlspecialchars(file_get_contents('markup/'.$type.'/'.$file));
        echo '</code></pre>';
        echo '</div>';
        echo '</div>';
    endforeach;
  }
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
  <title>Style Guide Boilerplate</title>
  <meta name="viewport" content="width=device-width">
  <!-- Style Guide Boilerplate Styles -->
  <link rel="stylesheet" href="css/sg-style.css">
  
  <!-- Replace below stylesheet with your own stylesheet -->
  <link media="all" href="//education.unimelb.edu.au/_mappdesign/mgsestaging_design.css" type="text/css" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="http://fast.fonts.net/jsapi/7e9801db-a894-431d-8544-b85ad9cf5f1e.js" type="text/javascript"></script>
</head>
<body>
    
<div id="top" class="sg-header sg-container">
  <h1 class="sg-logo">STYLE GUIDE></h1>
  <form id="js-sg-nav" action=""  method="post" class="sg-nav">
    <select id="js-sg-section-switcher" class="sg-section-switcher" name="sg_section_switcher">
        <option value="">Jump To Section:</option>
        <optgroup label="Intro">
          <option value="#sg-about">About</option>
          <option value="#sg-colors">Colors</option>
          <option value="#sg-fontStacks">Font-Stacks</option>
        </optgroup>
        <optgroup label="Base Styles">
          <?php listMarkupAsOptions('base'); ?>
        </optgroup>
        <optgroup label="Pattern Styles">
          <?php listMarkupAsOptions('patterns'); ?>
        </optgroup>
    </select>
    <input type="hidden" name="sg_uri" value="<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>">
    <button type="submit" class="sg-submit-btn">Go</button>
  </form><!--/.sg-nav-->
</div><!--/.sg-header-->

<div class="sg-body sg-container">
  <div class="sg-info">               
    <div class="sg-about sg-section">
      <h2 class="sg-h2"><a id="sg-about" class="sg-anchor">About</a></h2>
      <p>MGSE web pattern library</p>
    </div>
    <!--/.sg-about-->
    
    <div class="sg-colors sg-section">
      <h2 class="sg-h2"><a id="sg-colors" class="sg-anchor">Colors</a></h2>
        <div class="sg-color sg-color--a"><span class="sg-color-swatch"><span class="sg-animated">#ffffff</span></span></div>
        <div class="sg-color sg-color--b"><span class="sg-color-swatch"><span class="sg-animated">#003366</span></span></div>
        <div class="sg-color sg-color--c"><span class="sg-color-swatch"><span class="sg-animated">#005596</span></span></div>
        <div class="sg-color sg-color--d"><span class="sg-color-swatch"><span class="sg-animated">#00457c</span></span></div>
        <div class="sg-color sg-color--e"><span class="sg-color-swatch"><span class="sg-animated">#444444</span></span></div>
        <div class="sg-color sg-color--f"><span class="sg-color-swatch"><span class="sg-animated">#badef5</span></span></div>
        <div class="sg-markup-controls"><a class="sg-btn--top" href="#top">Back to Top</a></div>
    </div>

    <!--/.sg-colors-->
    
    <div class="sg-font-stacks sg-section">
      <h2 class="sg-h2"><a id="sg-fontStacks" class="sg-anchor">Font Stacks</a></h2>
      <p class="sg-font-primary"><p>'Univers W01', 'Helvetica Neue', Helvetica, Arial, sans-serif !default;</p>
      <p class="sg-font-bold"><strong>'Univers W01', 'Helvetica', Arial, sans-serif;</strong></p>
      <section class="sg-font-headings"><h3>'Univers W02',Helvetica,Arial,sans-serif;</h3></section>
      <div class="sg-markup-controls"><a class="sg-btn--top" href="#top">Back to Top</a></div>
    </div><!--/.sg-font-stacks-->


  </div><!--/.sg-info-->    

  <div class="sg-base-styles">    
    <h1 class="sg-h1">Base Styles</h1>
    <?php showMarkup('base'); ?>
  </div><!--/.sg-base-styles-->

  <div class="sg-pattern-styles">
    <h1 class="sg-h1">Pattern Styles<small> - Design and mark-up patterns.</small></h1>
    <?php showMarkup('patterns'); ?>
    </div><!--/.sg-pattern-styles-->
  </div><!--/.sg-body-->

  <script src="js/sg-plugins.js"></script>
  <script src="js/sg-scripts.js"></script>
<script src="//education.unimelb.edu.au/__data/assets/js_file/0003/1159257/banner-roller.js"></script>
<!--these scripts should be kept below the slider stuff or it will break-->
<!--collapsible-->
<script src="//education.unimelb.edu.au/_design/js/jquery.collapsible.min.js"></script>
<!--js expander-->
<script src="//education.unimelb.edu.au/__data/assets/js_file/0011/590906/jquery.expander.min.js"></script>
<!--fitvid-->
<script src="//education.unimelb.edu.au/__data/assets/js_file/0009/1070388/fitVid.js"></script>

<!--lazy sizes-->
<script src="//education.unimelb.edu.au/__data/assets/js_file/0010/1263277/lazysizes.min.js"></script>

<script src="//education.unimelb.edu.au/__data/assets/js_file/0018/1063035/respsonsiveTabs.js"></script>

<script>
jQuery(document).ready(function() {

$("#main-content").fitVids();

$('.abstract').expander({
        slicePoint:       100,  // default is 100
        expandPrefix:     '...', // default is '... '
        detailClass: 'more-details',
        summaryClass: 'summary',
        expandText: 'read more',
        expandEffect: 'show',
        expandSpeed: 0,
        collapseEffect: 'hide',
        collapseSpeed: 0
        });

 var type = window.location.hash.substr(1);

 $('.collapsible').collapsible({
 defaultOpen: type,
 speed: 'fast'
 });

//force scroll to opened accordion in Firefox
 $('html,body').animate({
  scrollTop: $('.collapse-open').offset().top 
  },1000);

});
</script>

<script>
jQuery(document).ready(function() {

$("#main-content").fitVids();

$('.abstract').expander({
        slicePoint:       100,  // default is 100
        expandPrefix:     '...', // default is '... '
        detailClass: 'more-details',
        summaryClass: 'summary',
        expandText: 'read more',
        expandEffect: 'show',
        expandSpeed: 0,
        collapseEffect: 'hide',
        collapseSpeed: 0
        });

 var type = window.location.hash.substr(1);

 $('.collapsible').collapsible({
 defaultOpen: type,
 speed: 'fast'
 });

//force scroll to opened accordion in Firefox
 $('html,body').animate({
  scrollTop: $('.collapse-open').offset().top 
  },1000);

 $("ul.tabs").tabs("div.panes > div"); 
});


});
</script>
</body>
</html>
 